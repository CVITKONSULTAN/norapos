<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\CiptaKarya\PetugasLapangan;

class CiptakaryaAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        $header = $request->header('Authorization');

        // Pastikan header Bearer ada
        if (!$header || !str_starts_with($header, 'Bearer ')) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized - Token tidak ditemukan'
            ], 401);
        }

        // Ambil token dari header
        $encryptedToken = trim(str_replace('Bearer ', '', $header));

        try {
            // dd($encryptedToken);
            // Dekripsi token
            $decrypted = Crypt::decrypt($encryptedToken);
            $tokenData = json_decode($decrypted, true);

            if (!isset($tokenData['auth_token'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token tidak valid (struktur salah)'
                ], 401);
            }

            // Cek token di database
            $petugas = PetugasLapangan::where('auth_token', $tokenData['auth_token'])->first();

            if (!$petugas) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token tidak valid atau sudah kadaluarsa'
                ], 401);
            }

            // Inject petugas ke request (opsional)
            $request->merge(['petugas' => $petugas]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Token tidak valid atau gagal didekripsi',
                'error' => $e->getMessage()
            ], 401);
        }

        // Jika lolos semua cek
        return $next($request);
    }
}
