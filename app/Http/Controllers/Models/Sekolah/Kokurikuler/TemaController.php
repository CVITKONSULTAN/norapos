<?php

namespace App\Http\Controllers\Models\Sekolah\Kokurikuler;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sekolah\TemaKokurikuler;
use App\Models\Sekolah\Kelas;
use DataTables;
use Illuminate\Support\Facades\DB;

class TemaController extends Controller
{
    public $level_kelas = [
        "1",
        "2",
        "3",
        "4",
        "5",
        "6",
        "1 CI",
        "2 CI",
        "3 CI",
        "4 CI",
        "5 CI",
        "6 CI"
    ];

    /**
     * Menampilkan halaman utama Tema Kokurikuler.
     */
    public function index()
    {
        $data['tahun_ajaran'] = Kelas::orderByDesc('id')->groupBy('tahun_ajaran')->select('tahun_ajaran')->get()->pluck('tahun_ajaran');
        $data['level_kelas'] = $this->level_kelas;
        $data['semester'] = [1,2];
        return view('sekolah_sd.tema_kokurikuler', $data);
    }

    /**
     * Mengambil data untuk DataTables.
     */
    public function data(Request $request)
    {
        $data = TemaKokurikuler::orderByDesc('id')->get();
        return DataTables::of($data)->make(true);
    }

    /**
     * Simpan atau update data tema kokurikuler.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tema'          => 'required|string|max:255',
            'aspek_nilai'   => 'nullable|string',
            'dimensi_list'  => 'nullable',
            'kelas'         => 'required|string|max:20',
            'tahun_ajaran'  => 'required|string|max:20',
            'semester'      => 'required|string|max:20',
        ]);

        // Pastikan dimensi_list tersimpan sebagai JSON
        $dimensi_list = $request->dimensi_list;
        if (is_string($dimensi_list)) {
            // Jika frontend mengirim string JSON, decode dulu
            $decoded = json_decode($dimensi_list, true);
            $dimensi_list = is_array($decoded) ? $decoded : [$dimensi_list];
        }

        $tema = TemaKokurikuler::updateOrCreate(
            ['id' => $request->id],
            [
                'tema'          => $request->tema,
                'aspek_nilai'   => $request->aspek_nilai,
                'dimensi_list'  => json_encode($dimensi_list),
                'kelas'         => $request->kelas,
                'tahun_ajaran'  => $request->tahun_ajaran,
                'semester'      => $request->semester,
            ]
        );

        return response()->json([
            'status'  => true,
            'message' => $request->id ? 'Tema berhasil diperbarui' : 'Tema berhasil ditambahkan',
            'data'    => $tema
        ]);
    }

    /**
     * Menampilkan detail data tema berdasarkan ID.
     */
    public function show($id)
    {
        $data = TemaKokurikuler::find($id);

        if (!$data) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
        }

        return response()->json(['status' => true, 'data' => $data]);
    }

    /**
     * Update data tema (opsional karena store() sudah handle updateOrCreate).
     */
    public function update(Request $request, $id)
    {
        $data = TemaKokurikuler::find($id);
        if (!$data) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
        }

        $request->validate([
            'tema'          => 'required|string|max:255',
            'aspek_nilai'   => 'nullable|string',
            'kelas'         => 'required|string|max:20',
            'tahun_ajaran'  => 'required|string|max:20',
            'semester'      => 'required|string|max:20',
        ]);

        $dimensi_list = $request->dimensi_list;
        if (is_string($dimensi_list)) {
            $decoded = json_decode($dimensi_list, true);
            $dimensi_list = is_array($decoded) ? $decoded : [$dimensi_list];
        }

        $data->update([
            'tema'          => $request->tema,
            'aspek_nilai'   => $request->aspek_nilai,
            'dimensi_list'  => $dimensi_list,
            'kelas'         => $request->kelas,
            'tahun_ajaran'  => $request->tahun_ajaran
        ]);

        return response()->json(['status' => true, 'message' => 'Data berhasil diperbarui']);
    }

    /**
     * Hapus data tema kokurikuler.
     */
    public function destroy($id)
    {
        $data = TemaKokurikuler::find($id);
        if (!$data) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
        }

        $data->delete();
        return response()->json(['status' => true, 'message' => 'Tema berhasil dihapus']);
    }


    public function apply(Request $request, $id)
    {
        $tema = TemaKokurikuler::find($id);
        if (!$tema) {
            return response()->json(['status' => false, 'message' => 'Tema tidak ditemukan.']);
        }

        $kelasList = Kelas::where([
            'tahun_ajaran' => $tema->tahun_ajaran,
            'kelas' => $tema->kelas,
            'semester' => $tema->semester,
        ])->get();

        if ($kelasList->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ditemukan kelas yang cocok untuk tema ini.'
            ]);
        }

        $user = auth()->user();
        $newHistory = [
            'user_id'   => $user->id ?? 0,
            'nama_user' => $user->first_name.' '.$user->last_name ?? 'System',
            'datetime'  => now()->format('Y-m-d H:i:s'),
        ];

        DB::beginTransaction();
        try {
            foreach ($kelasList as $kelas) {
                $kelas->tema_kokurikuler = $tema->toArray();
                $kelas->save();
            }

            $tema->history_apply = array_merge($tema->history_apply ?? [], [$newHistory]);
            $tema->save();

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Tema berhasil dikaitkan ke kelas.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Gagal mengaitkan tema.', 'error' => $e->getMessage()]);
        }
    }

}
