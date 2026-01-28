<?php

namespace App\Http\Controllers\CiptaKarya;

use App\Http\Controllers\Controller;
use App\Models\CiptaKarya\PetugasLapangan;
use App\Models\CiptaKarya\PengajuanPBG;
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

        // Update data verifikasi (sesuaikan dengan field yang ada)
        $updateData = [];
        
        if ($request->has('answers')) {
            $updateData['answers'] = $request->answers;
        }
        
        if ($request->has('list_foto')) {
            $updateData['list_foto'] = $request->list_foto;
        }

        if ($request->has('photoMaps')) {
            $updateData['photoMaps'] = $request->photoMaps;
        }

        $pengajuan->update($updateData);

        return response()->json([
            'status' => true,
            'message' => 'Verifikasi berhasil disimpan'
        ]);
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
     * Logout petugas
     */
    public function logout(Request $request)
    {
        session()->forget('petugas_id');
        
        return redirect()->route('petugas.login')
            ->with('success', 'Anda berhasil logout');
    }
}
