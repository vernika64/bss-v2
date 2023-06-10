<?php

namespace App\Http\Middleware;

use App\Models\SysToken;
use App\Models\SysUser;
use Closure;
use DateTime;
use Illuminate\Http\Request;

class CekTokenLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = $request->cookie('tkn');

            if(empty($token)) {
                return response()->json([
                    'status'    => 403,
                    'message'   => 'Anda belum login, silahkan login terlebih dahulu'
                ]);
            }

            $ModelToken = SysToken::where(['token' => $token])->first();

            if(!empty($ModelToken)) {
                $ModelUser                      = SysUser::where('username', $ModelToken->kd_user)->first();
                
                if(!empty($ModelUser)) {
                    $token_dibuat               = $ModelToken->created_at;
                    $tanggal_token              = date('Y-m-d', strtotime($token_dibuat));
                    $tanggal_akses              = date('Y-m-d');
                    $waktu_token                = strtotime(date('H:i:s', strtotime($token_dibuat)));
                    $waktu_akses                = strtotime(date('H:i:s'));
    
                    $tgl_akses                  = new DateTime($tanggal_akses);
                    $tgl_token                  = new DateTime($tanggal_token);
    
                    $beda_tanggal               = $tgl_akses->diff($tgl_token);

                    $beda_waktu                 = $waktu_akses - $waktu_token;
    
                    $interval_hari              = $beda_tanggal->d;
                    $interval_bulan             = $beda_tanggal->m;
                    $interval_tahun             = $beda_tanggal->y;
    
                    if($interval_hari == 0 && $interval_bulan == 0 && $interval_tahun == 0 && $beda_waktu < 10800) {
                        return $next($request);
                    } else {
                        return response()->json([
                            'status'    => 403,
                            'message'   => 'Token login sudah expired, silahkan login lagi'
                        ]);
                    }
                } else {
                    return response()->json([
                        'status'    => 403,
                        'message'   => 'User di dalam token tidak terdaftar, silahkan login lagi'
                    ]);
                }
            } else {
                return response()->json([
                    'status'    => 403,
                    'message'   => 'Token tidak terdaftar, silahkan login terlebih dahulu'
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'data'          => $th->getMessage(),
                'status'        => 500,
                'message'       => 'Terjadi kesalahan di server, silahkan hubungi admin IT website'
            ]);
        }
    }
}
