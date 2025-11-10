<?php

namespace App\Http\Controllers\Sekolah;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Visitor;
use DataTables;
use Carbon;

class VisitorController extends Controller
{
    public function index()
    {
        return view('sekolah_sd.statistik_visitor');
    }

    public function data(Request $request)
    {
        $query = Visitor::orderByDesc('id');

        // 🔹 Filter berdasarkan rentang tanggal (opsional)
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('visited_date', [
                Carbon::parse($request->start_date),
                Carbon::parse($request->end_date)
            ]);
        }

        // 🔹 Filter berdasarkan halaman (opsional)
        if ($request->page_name) {
            $query->where('page', 'like', "%{$request->page_name}%");
        }

         // 🔹 Filter berdasarkan domain[]
        if ($request->has('domain') && is_array($request->domain)) {
            $query->whereIn('domain', $request->domain);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('visited_date', fn($row) => Carbon::parse($row->visited_date)->format('d/m/Y'))
            ->editColumn('created_at', fn($row) => Carbon::parse($row->created_at)->format('d/m/Y H:i'))
            ->make(true);
    }
}
