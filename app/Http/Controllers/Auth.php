<?php

namespace App\Http\Controllers;

use App\Models\SysToken;
use App\Models\SysUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Auth extends Controller
{
    public function login(Request $re)
    {
        try {

            $ModelUser = SysUser::where('uid', $re->username)->first();

            if(!$ModelUser)
            {
                return response()->json([
                    'status'    => 'Username atau Password salah'
                ]);
            }

            $kuki = cookie('tkn', Hash::make(rand()));

            return response()->json([
                'data'      => $ModelUser,
                'status'    => 'auth_success'
            ])->withCookie($kuki);

        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Username atau Password salah'
            ]);
        }
    }

    public function tokenCheck(Request $re)
    {
        try {
            $kuki = $re->cookie('tkn');

            $ModelToken = SysToken::where('token', $kuki)->first();

            if(!$ModelToken) {
                return response()->json([
                    'status'      => 'token_notfound'
                ]);
            }

            return response()->json([
                'token'     => $kuki
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'server_error'
            ]);
        }
    }
}
