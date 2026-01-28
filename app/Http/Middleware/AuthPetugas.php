<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\CiptaKarya\PetugasLapangan;

class AuthPetugas
{
    /**
     * Handle an incoming request untuk autentikasi petugas lapangan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah petugas sudah login (ada session)
        if (!session()->has('petugas_id')) {
            return redirect()->route('petugas.login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        // Load data petugas dari database
        $petugas = PetugasLapangan::find(session('petugas_id'));

        // Validasi petugas masih ada dan belum dihapus
        if (!$petugas || $petugas->deleted_at) {
            session()->forget('petugas_id');
            return redirect()->route('petugas.login')
                ->with('error', 'Akun tidak ditemukan atau sudah dihapus');
        }

        // Inject data petugas ke request agar bisa diakses di controller
        $request->merge(['petugas' => $petugas]);
        view()->share('petugas', $petugas);

        return $next($request);
    }
}
