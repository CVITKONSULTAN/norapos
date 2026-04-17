<?php

namespace App\Http\Controllers;

use App\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    /**
     * Return all venues for current business (JSON for datatable / select refresh).
     */
    public function index()
    {
        if (!auth()->user()->can('venue_booking.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        $venues = Venue::where('business_id', $business_id)
            ->orderBy('name')
            ->get(['id', 'name', 'description', 'capacity', 'base_price', 'is_active']);

        return response()->json($venues);
    }

    /**
     * Store a new venue.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('venue_booking.create')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'capacity' => 'nullable|integer|min:0',
            'base_price' => 'nullable|numeric|min:0',
        ]);

        $business_id = request()->session()->get('user.business_id');

        $venue = Venue::create([
            'business_id' => $business_id,
            'name'        => $request->name,
            'description' => $request->description,
            'capacity'    => $request->capacity,
            'base_price'  => $request->base_price ?? 0,
            'is_active'   => $request->has('is_active') ? 1 : 0,
            'created_by'  => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'msg'     => 'Venue berhasil ditambahkan.',
            'venue'   => $venue,
        ]);
    }

    /**
     * Return single venue for edit form.
     */
    public function show($id)
    {
        if (!auth()->user()->can('venue_booking.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        $venue = Venue::where('business_id', $business_id)->findOrFail($id);

        return response()->json($venue);
    }

    /**
     * Update existing venue.
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('venue_booking.update')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'capacity' => 'nullable|integer|min:0',
            'base_price' => 'nullable|numeric|min:0',
        ]);

        $business_id = request()->session()->get('user.business_id');

        $venue = Venue::where('business_id', $business_id)->findOrFail($id);

        $venue->update([
            'name'        => $request->name,
            'description' => $request->description,
            'capacity'    => $request->capacity,
            'base_price'  => $request->base_price ?? 0,
            'is_active'   => $request->has('is_active') ? 1 : 0,
        ]);

        return response()->json([
            'success' => true,
            'msg'     => 'Venue berhasil diupdate.',
            'venue'   => $venue,
        ]);
    }

    /**
     * Delete a venue.
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('venue_booking.delete')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        $venue = Venue::where('business_id', $business_id)->findOrFail($id);
        $venue->delete();

        return response()->json([
            'success' => true,
            'msg'     => 'Venue berhasil dihapus.',
        ]);
    }
}
