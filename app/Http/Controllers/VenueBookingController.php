<?php

namespace App\Http\Controllers;

use App\Venue;
use App\VenueBooking;
use App\VenueBookingIngredient;
use App\VenueBookingItem;
use App\VenueBookingPayment;
use App\IngredientStock;
use App\IngredientStockLog;
use App\BusinessLocation;
use App\Contact;
use App\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class VenueBookingController extends Controller
{
    /**
     * Display a listing of venue bookings.
     */
    public function index()
    {
        if (!auth()->user()->can('venue_booking.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        if (request()->ajax()) {
            $bookings = VenueBooking::where('venue_bookings.business_id', $business_id)
                ->join('venues', 'venue_bookings.venue_id', '=', 'venues.id')
                ->select([
                    'venue_bookings.*',
                    'venues.name as venue_name',
                ]);

            // Filter by status
            if (!empty(request()->status)) {
                $bookings->where('venue_bookings.status', request()->status);
            }

            // Filter by venue
            if (!empty(request()->venue_id)) {
                $bookings->where('venue_bookings.venue_id', request()->venue_id);
            }

            // Filter by date range
            if (!empty(request()->start_date) && !empty(request()->end_date)) {
                $bookings->whereBetween('venue_bookings.event_date', [request()->start_date, request()->end_date]);
            }

            return DataTables::of($bookings)
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-group">
                        <button type="button" class="btn btn-info dropdown-toggle btn-xs" data-toggle="dropdown" aria-expanded="false">
                            Aksi <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">';

                    if (auth()->user()->can('venue_booking.view')) {
                        $html .= '<li><a href="' . action('VenueBookingController@show', [$row->id]) . '"><i class="fa fa-eye"></i> Detail</a></li>';
                    }
                    if (auth()->user()->can('venue_booking.update') || auth()->user()->can('venue_booking.ingredient')) {
                        $html .= '<li><a href="' . action('VenueBookingController@ingredients', [$row->id]) . '"><i class="fa fa-list-alt"></i> Bahan Baku Event</a></li>';
                    }
                    if (auth()->user()->can('venue_booking.update')) {
                        $html .= '<li><a href="' . action('VenueBookingController@edit', [$row->id]) . '"><i class="fa fa-edit"></i> Edit</a></li>';
                    }
                    if (auth()->user()->can('venue_booking.delete')) {
                        $html .= '<li><a href="#" class="delete-booking" data-href="' . action('VenueBookingController@destroy', [$row->id]) . '"><i class="fa fa-trash"></i> Hapus</a></li>';
                    }

                    $html .= '</ul></div>';
                    return $html;
                })
                ->editColumn('event_date', function ($row) {
                    return $row->event_date ? $row->event_date->format('d/m/Y') : '-';
                })
                ->editColumn('total_amount', function ($row) {
                    return 'Rp ' . number_format($row->total_amount, 0, ',', '.');
                })
                ->editColumn('dp_amount', function ($row) {
                    return 'Rp ' . number_format($row->dp_amount, 0, ',', '.');
                })
                ->editColumn('remaining_amount', function ($row) {
                    return 'Rp ' . number_format($row->remaining_amount, 0, ',', '.');
                })
                ->addColumn('status_label', function ($row) {
                    return $row->status_label;
                })
                ->rawColumns(['action', 'status_label'])
                ->make(true);
        }

        $venues = Venue::forDropdown($business_id);

        return view('venue_booking.index', compact('venues'));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create()
    {
        if (!auth()->user()->can('venue_booking.create')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $venues = Venue::forDropdown($business_id);
        $contacts = Contact::where('business_id', $business_id)
            ->where('type', 'customer')
            ->orderBy('name')
            ->pluck('name', 'id')
            ->prepend('-- Tamu Baru --', '');

        return view('venue_booking.create', compact('venues', 'contacts'));
    }

    /**
     * Store a newly created booking.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('venue_booking.create')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = request()->session()->get('user.business_id');

            DB::beginTransaction();

            // Create booking
            $booking = VenueBooking::create([
                'business_id' => $business_id,
                'venue_id' => $request->venue_id,
                'contact_id' => $request->contact_id ?: null,
                'guest_name' => $request->guest_name,
                'guest_phone' => $request->guest_phone,
                'guest_email' => $request->guest_email,
                'guest_company' => $request->guest_company,
                'event_name' => $request->event_name,
                'event_date' => $request->event_date,
                'event_start_time' => $request->event_start_time,
                'event_end_time' => $request->event_end_time,
                'estimated_guests' => $request->estimated_guests ?? 0,
                'pic_name' => $request->pic_name,
                'pic_phone' => $request->pic_phone,
                'pricing_type' => $request->pricing_type ?? 'custom',
                'price_per_pax' => $request->price_per_pax ?? 0,
                'notes' => $request->notes,
                'status' => 'pending',
                'created_by' => auth()->id(),
            ]);

            // Create booking items
            $totalAmount = 0;
            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    if (empty($item['item_name'])) continue;

                    $qty = $item['quantity'] ?? 1;
                    $price = $item['price'] ?? 0;
                    $subtotal = $qty * $price;

                    VenueBookingItem::create([
                        'venue_booking_id' => $booking->id,
                        'item_name' => $item['item_name'],
                        'quantity' => $qty,
                        'unit' => $item['unit'] ?? null,
                        'price' => $price,
                        'subtotal' => $subtotal,
                        'note' => $item['note'] ?? null,
                    ]);

                    $totalAmount += $subtotal;
                }
            }

            if ($request->filled('total_amount')) {
                $totalAmount = (float) $request->total_amount;
            }

            if (($request->pricing_type ?? 'custom') === 'per_pax') {
                $totalAmount = (float) ($request->estimated_guests ?? 0) * (float) ($request->price_per_pax ?? 0);
            }

            $booking->total_amount = $totalAmount;

            // Record DP payment if provided
            $dpAmount = 0;
            if (!empty($request->dp_amount) && $request->dp_amount > 0) {
                VenueBookingPayment::create([
                    'venue_booking_id' => $booking->id,
                    'amount' => $request->dp_amount,
                    'method' => $request->dp_method ?? 'cash',
                    'payment_ref' => $request->dp_payment_ref,
                    'note' => 'DP Awal',
                    'paid_at' => $request->dp_paid_at ?? now()->toDateString(),
                    'created_by' => auth()->id(),
                ]);
                $dpAmount = $request->dp_amount;
            }

            $booking->dp_amount = $dpAmount;
            $booking->remaining_amount = $booking->total_amount - $dpAmount;
            $booking->save();

            DB::commit();

            $output = [
                'success' => true,
                'msg' => 'Booking venue berhasil disimpan.'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong')
            ];
        }

        return redirect()->action('VenueBookingController@index')->with('status', $output);
    }

    /**
     * Display the specified booking.
     */
    public function show($id)
    {
        if (!auth()->user()->can('venue_booking.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        $booking = VenueBooking::where('business_id', $business_id)
            ->with(['venue', 'items', 'payments', 'payments.createdBy', 'contact', 'createdBy', 'ingredientUsages.ingredient.unit', 'ingredientUsages.unit'])
            ->findOrFail($id);

        return view('venue_booking.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified booking.
     */
    public function edit($id)
    {
        if (!auth()->user()->can('venue_booking.update')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        $booking = VenueBooking::where('business_id', $business_id)
            ->with(['items', 'payments'])
            ->findOrFail($id);

        $venues = Venue::forDropdown($business_id);
        $contacts = Contact::where('business_id', $business_id)
            ->where('type', 'customer')
            ->orderBy('name')
            ->pluck('name', 'id')
            ->prepend('-- Tamu Baru --', '');

        return view('venue_booking.edit', compact('booking', 'venues', 'contacts'));
    }

    /**
     * Update the specified booking.
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('venue_booking.update')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = request()->session()->get('user.business_id');

            DB::beginTransaction();

            $booking = VenueBooking::where('business_id', $business_id)->findOrFail($id);
            $oldStatus = $booking->status;

            $booking->update([
                'venue_id' => $request->venue_id,
                'contact_id' => $request->contact_id ?: null,
                'guest_name' => $request->guest_name,
                'guest_phone' => $request->guest_phone,
                'guest_email' => $request->guest_email,
                'guest_company' => $request->guest_company,
                'event_name' => $request->event_name,
                'event_date' => $request->event_date,
                'event_start_time' => $request->event_start_time,
                'event_end_time' => $request->event_end_time,
                'estimated_guests' => $request->estimated_guests ?? 0,
                'pic_name' => $request->pic_name,
                'pic_phone' => $request->pic_phone,
                'pricing_type' => $request->pricing_type ?? 'custom',
                'price_per_pax' => $request->price_per_pax ?? 0,
                'notes' => $request->notes,
                'status' => $request->status ?? $booking->status,
            ]);

            // Rebuild items
            $booking->items()->delete();
            $totalAmount = 0;
            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    if (empty($item['item_name'])) continue;

                    $qty = $item['quantity'] ?? 1;
                    $price = $item['price'] ?? 0;
                    $subtotal = $qty * $price;

                    VenueBookingItem::create([
                        'venue_booking_id' => $booking->id,
                        'item_name' => $item['item_name'],
                        'quantity' => $qty,
                        'unit' => $item['unit'] ?? null,
                        'price' => $price,
                        'subtotal' => $subtotal,
                        'note' => $item['note'] ?? null,
                    ]);

                    $totalAmount += $subtotal;
                }
            }

            if ($request->filled('total_amount')) {
                $totalAmount = (float) $request->total_amount;
            }

            if (($request->pricing_type ?? 'custom') === 'per_pax') {
                $totalAmount = (float) ($request->estimated_guests ?? 0) * (float) ($request->price_per_pax ?? 0);
            }

            $paidTotal = $booking->payments()->sum('amount');
            $booking->total_amount = $totalAmount;
            $booking->dp_amount = $paidTotal;
            $booking->remaining_amount = $totalAmount - $paidTotal;
            $booking->save();

            $this->syncIngredientStockByStatus($booking, $oldStatus, $booking->status, $business_id);

            DB::commit();

            $output = [
                'success' => true,
                'msg' => 'Booking venue berhasil diupdate.'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong')
            ];
        }

        return redirect()->action('VenueBookingController@index')->with('status', $output);
    }

    /**
     * Remove the specified booking.
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('venue_booking.delete')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = request()->session()->get('user.business_id');
            VenueBooking::where('business_id', $business_id)->where('id', $id)->delete();

            $output = [
                'success' => true,
                'msg' => 'Booking venue berhasil dihapus.'
            ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong')
            ];
        }

        return $output;
    }

    /**
     * Add payment to a booking.
     */
    public function addPayment(Request $request, $id)
    {
        if (!auth()->user()->can('venue_booking.payment')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = request()->session()->get('user.business_id');
            $booking = VenueBooking::where('business_id', $business_id)->findOrFail($id);

            DB::beginTransaction();

            VenueBookingPayment::create([
                'venue_booking_id' => $booking->id,
                'amount' => $request->amount,
                'method' => $request->method ?? 'cash',
                'payment_ref' => $request->payment_ref,
                'note' => $request->note,
                'paid_at' => $request->paid_at ?? now()->toDateString(),
                'created_by' => auth()->id(),
            ]);

            // Recalculate
            $booking->recalculateTotal();

            DB::commit();

            $output = [
                'success' => true,
                'msg' => 'Pembayaran berhasil ditambahkan.'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong')
            ];
        }

        return redirect()->action('VenueBookingController@show', [$id])->with('status', $output);
    }

    /**
     * Show form to manage ingredient usage for an event.
     */
    public function ingredients($id)
    {
        if (!auth()->user()->can('venue_booking.update') && !auth()->user()->can('venue_booking.ingredient')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        $booking = VenueBooking::where('business_id', $business_id)
            ->with(['venue', 'ingredientUsages.ingredient.unit', 'ingredientUsages.unit'])
            ->findOrFail($id);

        $ingredients = Ingredient::where('business_id', $business_id)
            ->active()
            ->with('unit')
            ->orderBy('name')
            ->get();

        return view('venue_booking.ingredients', compact('booking', 'ingredients'));
    }

    /**
     * Save estimated ingredients for an event.
     */
    public function saveIngredients(Request $request, $id)
    {
        if (!auth()->user()->can('venue_booking.update') && !auth()->user()->can('venue_booking.ingredient')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = request()->session()->get('user.business_id');

            DB::beginTransaction();

            $booking = VenueBooking::where('business_id', $business_id)->findOrFail($id);

            // Jika booking sudah completed, kembalikan dulu stok lama supaya bisa hitung ulang.
            if ($booking->status === 'completed') {
                $this->restoreIngredientsForBooking($booking, $business_id);
            }

            $booking->ingredientUsages()->delete();

            foreach ($request->input('ingredients', []) as $line) {
                if (empty($line['ingredient_id']) || empty($line['qty']) || (float) $line['qty'] <= 0) {
                    continue;
                }

                $ingredient = Ingredient::where('business_id', $business_id)
                    ->with('unit')
                    ->findOrFail($line['ingredient_id']);

                VenueBookingIngredient::create([
                    'business_id' => $business_id,
                    'venue_booking_id' => $booking->id,
                    'ingredient_id' => $ingredient->id,
                    'unit_id' => $ingredient->unit_id,
                    'qty' => $line['qty'],
                    'note' => $line['note'] ?? null,
                    'created_by' => auth()->id(),
                ]);
            }

            // Jika booking completed, langsung potong lagi sesuai data terbaru.
            if ($booking->status === 'completed') {
                $booking->load('ingredientUsages');
                $this->deductIngredientsForBooking($booking, $business_id);
            }

            DB::commit();

            $output = [
                'success' => true,
                'msg' => 'Bahan baku event berhasil disimpan.'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong')
            ];
        }

        return redirect()->action('VenueBookingController@ingredients', [$id])->with('status', $output);
    }

    /**
     * Delete a payment record.
     */
    public function deletePayment($id, $paymentId)
    {
        if (!auth()->user()->can('venue_booking.payment')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = request()->session()->get('user.business_id');
            $booking = VenueBooking::where('business_id', $business_id)->findOrFail($id);

            VenueBookingPayment::where('venue_booking_id', $booking->id)
                ->where('id', $paymentId)
                ->delete();

            $booking->recalculateTotal();

            $output = [
                'success' => true,
                'msg' => 'Pembayaran berhasil dihapus.'
            ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong')
            ];
        }

        return $output;
    }

    /**
     * Update booking status via AJAX.
     */
    public function updateStatus(Request $request, $id)
    {
        if (!auth()->user()->can('venue_booking.update')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = request()->session()->get('user.business_id');

            DB::beginTransaction();

            $booking = VenueBooking::where('business_id', $business_id)->findOrFail($id);
            $oldStatus = $booking->status;
            $booking->status = $request->status;
            $booking->save();

            $this->syncIngredientStockByStatus($booking, $oldStatus, $booking->status, $business_id);

            DB::commit();

            $output = [
                'success' => true,
                'msg' => 'Status booking berhasil diupdate.'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong')
            ];
        }

        return $output;
    }

    /**
     * Sinkron stok bahan baku berdasarkan perubahan status booking.
     */
    protected function syncIngredientStockByStatus(VenueBooking $booking, $oldStatus, $newStatus, $business_id)
    {
        if ($oldStatus !== 'completed' && $newStatus === 'completed') {
            $booking->loadMissing('ingredientUsages');
            $this->deductIngredientsForBooking($booking, $business_id);
        }

        if ($oldStatus === 'completed' && $newStatus !== 'completed') {
            $this->restoreIngredientsForBooking($booking, $business_id);
        }
    }

    /**
     * Potong stok bahan baku untuk booking (sekali saja per booking).
     */
    protected function deductIngredientsForBooking(VenueBooking $booking, $business_id)
    {
        $hasLog = IngredientStockLog::where('ref_type', 'venue_booking')
            ->where('ref_id', $booking->id)
            ->exists();

        if ($hasLog) {
            return;
        }

        $location_id = $this->resolveStockLocationId($business_id);
        if (empty($location_id)) {
            throw new \Exception('Lokasi bisnis tidak ditemukan untuk update stok bahan baku.');
        }

        foreach ($booking->ingredientUsages as $usage) {
            $qty = (float) $usage->qty;
            if ($qty <= 0) {
                continue;
            }

            $stock = IngredientStock::firstOrCreate(
                [
                    'ingredient_id' => $usage->ingredient_id,
                    'location_id' => $location_id,
                ],
                [
                    'business_id' => $business_id,
                    'current_qty' => 0,
                ]
            );

            $stock->current_qty -= $qty;
            $stock->updated_at = now();
            $stock->save();

            IngredientStockLog::create([
                'ingredient_id' => $usage->ingredient_id,
                'business_id' => $business_id,
                'location_id' => $location_id,
                'qty_change' => -$qty,
                'ref_type' => 'venue_booking',
                'ref_id' => $booking->id,
                'notes' => 'Auto deduct bahan baku dari booking venue #' . $booking->booking_ref,
                'created_by' => auth()->id(),
                'created_at' => now(),
            ]);
        }
    }

    /**
     * Kembalikan stok bahan baku booking berdasarkan log sebelumnya.
     */
    protected function restoreIngredientsForBooking(VenueBooking $booking, $business_id)
    {
        $logs = IngredientStockLog::where('ref_type', 'venue_booking')
            ->where('ref_id', $booking->id)
            ->get();

        foreach ($logs as $log) {
            $stock = IngredientStock::firstOrCreate(
                [
                    'ingredient_id' => $log->ingredient_id,
                    'location_id' => $log->location_id,
                ],
                [
                    'business_id' => $business_id,
                    'current_qty' => 0,
                ]
            );

            // qty_change log deduct bernilai negatif, jadi dibalik dengan -= qty_change.
            $stock->current_qty -= (float) $log->qty_change;
            $stock->updated_at = now();
            $stock->save();
        }

        IngredientStockLog::where('ref_type', 'venue_booking')
            ->where('ref_id', $booking->id)
            ->delete();
    }

    /**
     * Ambil lokasi default untuk mutasi stok bahan baku.
     */
    protected function resolveStockLocationId($business_id)
    {
        return BusinessLocation::where('business_id', $business_id)
            ->orderBy('id')
            ->value('id');
    }
}
