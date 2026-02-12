<?php

namespace App\Http\Controllers\CiptaKarya;

use App\Http\Controllers\Controller;
use App\Models\CiptaKarya\PetugasLapangan;
use App\Models\CiptaKarya\PengajuanPBG;
use App\Models\CiptaKarya\PbgTracking;
use App\Mail\MagicLinkMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PetugasController extends Controller
{
    /**
     * Tampilkan halaman login petugas
     */
    public function showLogin()
    {
        // Redirect jika sudah login
        if (session()->has('petugas_id')) {
            return redirect()->route('petugas.dashboard');
        }

        return view('petugas.login');
    }

    /**
     * Kirim magic link ke email petugas
     */
    public function sendMagicLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid'
        ]);

        // Cari petugas berdasarkan email
        $petugas = PetugasLapangan::where('email', $request->email)->first();

        if (!$petugas || $petugas->deleted_at) {
            return back()->with('error', 'Email tidak terdaftar sebagai petugas lapangan');
        }

        // Generate token unik
        $token = Str::random(64);
        
        // Simpan token dan expiry time (15 menit)
        $petugas->magic_link_token = $token;
        $petugas->magic_link_expires_at = Carbon::now()->addMinutes(15);
        $petugas->save();

        // Generate URL login
        $loginUrl = route('petugas.login.verify', ['token' => $token]);

        try {
            // Kirim email
            Mail::to($petugas->email)->send(new MagicLinkMail($petugas, $loginUrl));
            
            return back()->with('success', 'Link login telah dikirim ke email Anda. Silakan cek inbox atau spam folder.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email. Silakan coba lagi.');
        }
    }

    /**
     * Verifikasi magic link dan login petugas
     */
    public function verifyMagicLink($token)
    {
        $petugas = PetugasLapangan::where('magic_link_token', $token)
            ->where('magic_link_expires_at', '>', Carbon::now())
            ->first();

        if (!$petugas) {
            return redirect()->route('petugas.login')
                ->with('error', 'Link login tidak valid atau sudah kadaluarsa. Silakan request link baru.');
        }

        // Set session
        session(['petugas_id' => $petugas->id]);

        // Clear token (one-time use)
        $petugas->magic_link_token = null;
        $petugas->magic_link_expires_at = null;
        $petugas->save();

        return redirect()->route('petugas.dashboard')
            ->with('success', 'Selamat datang, ' . $petugas->nama);
    }

    /**
     * Dashboard petugas - mirip React Native
     */
    public function dashboard(Request $request)
    {
        $petugas = $request->petugas;

        // Hitung statistik tugas petugas ini
        $proses = PengajuanPBG::where('petugas_id', $petugas->id)
            ->where('status', 'proses')
            ->count();
            
        $izin_terbit = PengajuanPBG::where('petugas_id', $petugas->id)
            ->where('status', 'terbit')
            ->count();
            
        $gagal = PengajuanPBG::where('petugas_id', $petugas->id)
            ->where('status', 'gagal')
            ->count();

        $stat = [
            'proses' => $proses,
            'izin_terbit' => $izin_terbit,
            'gagal' => $gagal
        ];

        return view('petugas.dashboard', compact('petugas', 'stat'));
    }

    /**
     * API untuk load list tugas (AJAX)
     */
    public function apiListTugas(Request $request)
    {
        $petugas = $request->petugas;
        $status = $request->status;
        $search = $request->search;

        $query = PengajuanPBG::where('petugas_id', $petugas->id);

        // Filter status
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        // Search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_pemohon', 'like', "%{$search}%")
                  ->orWhere('no_permohonan', 'like', "%{$search}%")
                  ->orWhere('nama_bangunan', 'like', "%{$search}%");
            });
        }

        $pengajuan = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'status' => true,
            'data' => $pengajuan
        ]);
    }

    /**
     * Detail tugas untuk verifikasi
     */
    public function detailTugas(Request $request, $id)
    {
        $petugas = $request->petugas;
        
        $pengajuan = PengajuanPBG::where('id', $id)
            ->where('petugas_id', $petugas->id)
            ->first();

        if (!$pengajuan) {
            return redirect()->route('petugas.dashboard')
                ->with('error', 'Tugas tidak ditemukan atau bukan tugas Anda');
        }

        return view('petugas.detail_tugas', compact('petugas', 'pengajuan'));
    }

    /**
     * Submit hasil verifikasi
     */
    public function submitVerifikasi(Request $request, $id)
    {
        $petugas = $request->petugas;
        
        $pengajuan = PengajuanPBG::where('id', $id)
            ->where('petugas_id', $petugas->id)
            ->first();

        if (!$pengajuan) {
            return response()->json([
                'status' => false,
                'message' => 'Tugas tidak ditemukan'
            ], 404);
        }

        // Update data verifikasi - status tetap 'proses', diteruskan ke Pemeriksa
        $updateData = [
            'status' => 'proses',
            'verified_at' => now(),
            'verified_by' => $petugas->id,
        ];
        
        if ($request->has('list_foto')) {
            $updateData['list_foto'] = $request->list_foto;
        }

        if ($request->has('notes')) {
            $updateData['notes'] = $request->notes;
        }

        $pengajuan->update($updateData);

        // $business_id = 15; //local
        $business_id = 18; //server
        
        // Catat tracking petugas lapangan
        $role = 'Petugas Lapangan#' . $business_id;
        
        PbgTracking::updateOrCreate(
            [
                'pengajuan_id' => $pengajuan->id,
                'role' => $role
            ],
            [
                'user_id' => null, // petugas bukan user sistem
                'catatan' => "Petugas {$petugas->nama} menyelesaikan verifikasi lapangan",
                'status' => "proses",
                'verified_at' => now()
            ]
        );

        // Cari user Pemeriksa untuk notifikasi email
        $admin = \App\User::role("Pemeriksa#$business_id")->get();

        if ($admin->count() > 0) {
            $emailList = $admin->pluck('email')->toArray();

            // Kirim email ke Pemeriksa
            \Mail::to($emailList)->send(new \App\Mail\NotifVerifikasiRetribusi(
                $pengajuan,
                PbgTracking::where('pengajuan_id', $pengajuan->id)->where('role', $role)->first()
            ));
        }

        return response()->json([
            'status' => true,
            'message' => 'Verifikasi berhasil dikirim ke Pemeriksa'
        ]);
    }

    /**
     * Halaman foto lapangan
     */
    public function fotoLapangan(Request $request, $id)
    {
        $petugas = $request->petugas;
        
        $pengajuan = PengajuanPBG::where('id', $id)
            ->where('petugas_id', $petugas->id)
            ->first();

        if (!$pengajuan) {
            return redirect()->route('petugas.dashboard')
                ->with('error', 'Tugas tidak ditemukan');
        }

        return view('petugas.foto_lapangan', compact('petugas', 'pengajuan'));
    }

    /**
     * Simpan foto lapangan
     */
    public function savePhotos(Request $request, $id)
    {
        $petugas = $request->petugas;
        
        $pengajuan = PengajuanPBG::where('id', $id)
            ->where('petugas_id', $petugas->id)
            ->first();

        if (!$pengajuan) {
            return response()->json([
                'status' => false,
                'message' => 'Tugas tidak ditemukan'
            ], 404);
        }

        $photoMaps = $request->photoMaps;
        
        // Sync list_foto with photoMaps (same data)
        $pengajuan->update([
            'photoMaps' => $photoMaps,
            'list_foto' => $photoMaps
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Foto berhasil disimpan'
        ]);
    }

    /**
     * Halaman kuesioner
     */
    public function kuesioner(Request $request, $id)
    {
        $petugas = $request->petugas;
        
        $pengajuan = PengajuanPBG::where('id', $id)
            ->where('petugas_id', $petugas->id)
            ->first();

        if (!$pengajuan) {
            return redirect()->route('petugas.dashboard')
                ->with('error', 'Tugas tidak ditemukan');
        }

        return view('petugas.kuesioner', compact('petugas', 'pengajuan'));
    }

    /**
     * Simpan jawaban kuesioner
     */
    public function saveAnswers(Request $request, $id)
    {
        $petugas = $request->petugas;
        
        $pengajuan = PengajuanPBG::where('id', $id)
            ->where('petugas_id', $petugas->id)
            ->first();

        if (!$pengajuan) {
            return response()->json([
                'status' => false,
                'message' => 'Tugas tidak ditemukan'
            ], 404);
        }

        // Get answers from request - handle both json and form data
        $answersData = $request->input('answers');
        $questionsData = $request->input('questions');
        
        // If input is null, try to get from raw JSON
        if ($answersData === null) {
            $content = $request->getContent();
            $decoded = json_decode($content, true);
            $answersData = $decoded['answers'] ?? [];
            $questionsData = $decoded['questions'] ?? null;
        }
        
        // Log for debugging
        \Log::info('Saving answers for pengajuan ' . $id, [
            'answers_count' => is_array($answersData) ? count($answersData) : 'not_array',
            'answers_type' => gettype($answersData),
            'has_questions' => $questionsData ? 'yes' : 'no'
        ]);

        if (empty($answersData)) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada jawaban yang dikirim'
            ], 400);
        }

        $updateData = [
            'answers' => $answersData
        ];
        
        // Also save questions if provided
        if ($questionsData) {
            $updateData['questions'] = $questionsData;
        }

        $pengajuan->update($updateData);

        return response()->json([
            'status' => true,
            'message' => 'Jawaban berhasil disimpan'
        ]);
    }

    /**
     * Halaman submit verifikasi
     */
    public function showSubmitVerifikasi(Request $request, $id)
    {
        $petugas = $request->petugas;
        
        $pengajuan = PengajuanPBG::where('id', $id)
            ->where('petugas_id', $petugas->id)
            ->first();

        if (!$pengajuan) {
            return redirect()->route('petugas.dashboard')
                ->with('error', 'Tugas tidak ditemukan');
        }

        return view('petugas.submit_verifikasi', compact('petugas', 'pengajuan'));
    }

    /**
     * Upload foto
     */
    public function uploadPhoto(Request $request)
    {
        try {
            if (!$request->hasFile('file_data')) {
                return response()->json([
                    'status' => false,
                    'message' => 'No file uploaded'
                ], 400);
            }

            $file = $request->file('file_data');
            $filename = 'verifikasi_' . time() . '_' . uniqid() . '.jpg';
            
            // Store in public storage
            $path = $file->storeAs('uploads/verifikasi', $filename, 'public');
            
            // Generate URL
            $url = asset('storage/' . $path);

            return response()->json([
                'status' => true,
                'url' => $url,
                'path' => $path
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Halaman profil petugas
     */
    public function profil(Request $request)
    {
        $petugas = $request->petugas;
        return view('petugas.profil', compact('petugas'));
    }

    /**
     * Cetak laporan verifikasi untuk petugas lapangan
     */
    public function cetakLaporan(Request $request, $id)
    {
        $petugas = $request->petugas;
        
        // Pastikan pengajuan milik petugas yang login
        $pengajuan = PengajuanPBG::where('id', $id)
            ->where('petugas_id', $petugas->id)
            ->first();

        if (!$pengajuan) {
            abort(404, 'Data tidak ditemukan atau Anda tidak memiliki akses');
        }

        $pengajuan = $pengajuan->toArray();

        // Handle answers - bisa array (dari cast) atau string JSON
        $answers = $pengajuan['answers'] ?? [];
        if (is_string($answers)) {
            $answers = json_decode($answers, true) ?? [];
        }
        if (!is_array($answers)) {
            $answers = [];
        }
        
        // Handle questions - bisa array (dari cast) atau string JSON
        $sections = $pengajuan['questions'] ?? [];
        if (is_string($sections)) {
            $sections = json_decode($sections, true) ?? [];
        }
        if (!is_array($sections)) {
            $sections = [];
        }

        $results = [];

        // Helper untuk memisahkan answer & visual
        $parseAnswer = function($val) {
            if (!is_numeric($val)) {
                return [
                    'answer' => null,   // tidak dianggap Ya/Tidak
                    'visual' => $val    // ini teks visual
                ];
            }
            return [
                'answer' => \App\Helpers\Helper::answerLabel($val),
                'visual' => null
            ];
        };

        foreach ($sections as $section) {

            $sec = [
                'caption' => $section['caption'],
                'rows' => [],
                'child' => [],
            ];

            /* ======================================================
            * LEVEL 1  (section -> questioner)
            ====================================================== */
            if (isset($section['questioner'])) {

                foreach ($section['questioner'] as $i => $q) {

                    $key = $section['caption'] . '__' . $i;

                    $val = $answers[$key]['value'] ?? null;
                    $parsed = $parseAnswer($val);

                    $sec['rows'][] = [
                        'question' => $q['question'],
                        'answer'   => $parsed['answer'],
                        'visual'   => $parsed['visual'],
                    ];
                }
            }


            /* ======================================================
            * LEVEL 2  (section -> child)
            ====================================================== */
            if (isset($section['child'])) {

                foreach ($section['child'] as $child1) {

                    $sub = [
                        'caption' => $child1['caption'],
                        'rows' => [],
                        'child' => []
                    ];

                    // child1 langsung punya questioner
                    if (isset($child1['questioner'])) {

                        foreach ($child1['questioner'] as $i => $q) {

                            $key = $section['caption']
                                . ' > ' . $child1['caption']
                                . '__' . $i;

                            $val = $answers[$key]['value'] ?? null;
                            $parsed = $parseAnswer($val);

                            $sub['rows'][] = [
                                'question' => $q['question'],
                                'answer'   => $parsed['answer'],
                                'visual'   => $parsed['visual'],
                            ];
                        }
                    }


                    /* ======================================================
                    * LEVEL 3  (section -> child -> subchild)
                    ====================================================== */
                    if (isset($child1['child'])) {

                        foreach ($child1['child'] as $child2) {

                            $sub2 = [
                                'caption' => $child2['caption'],
                                'rows' => []
                            ];

                            foreach ($child2['questioner'] as $i => $q) {

                                $key = $section['caption']
                                    . ' > ' . $child1['caption']
                                    . ' > ' . $child2['caption']
                                    . '__' . $i;

                                $val = $answers[$key]['value'] ?? null;
                                $parsed = $parseAnswer($val);

                                $sub2['rows'][] = [
                                    'question' => $q['question'],
                                    'answer'   => $parsed['answer'],
                                    'visual'   => $parsed['visual'],
                                ];
                            }

                            $sub['child'][] = $sub2;
                        }
                    }

                    $sec['child'][] = $sub;
                }
            }

            $results[] = $sec;
        }


        /* ======================================================
        * FOTO MAPPING
        ====================================================== */
        // Handle photoMaps - bisa array (dari cast) atau string JSON
        $photos = $pengajuan['photoMaps'] ?? [];
        if (is_string($photos)) {
            $photos = json_decode($photos, true) ?? [];
        }
        if (!is_array($photos)) {
            $photos = [];
        }

        $sectionPhotos = [];

        foreach ($photos as $p) {

            preg_match('/^(\d+)-/', $p['caption'] ?? '', $match);

            if (!isset($match[1])) continue;

            $sectionNum = $match[1];

            $sectionPhotos[$sectionNum][] = [
                'caption' => $p['caption'],
                'url' => $p['url']
            ];
        }

        return view('ciptakarya.cetak_petugas_lapangan', [
            'pengajuan'        => $pengajuan,
            'petugas'          => $petugas,
            'inspectionResults'=> $results,
            'sectionPhotos'    => $sectionPhotos,
        ]);
    }

    /**
     * Logout petugas
     */
    public function logout(Request $request)
    {
        session()->forget('petugas_id');
        
        return redirect()->route('petugas.login')
            ->with('success', 'Anda berhasil logout');
    }
}
