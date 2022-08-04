<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Testing extends Controller
{
    public function tesCookie(Request $re)
    {
        try {
            if (empty($re->cookie('tkn'))) {
                return response()->json([
                    'status'    => 'Cookie Doesnt Exist'
                ]);
            }

            return response()->json([
                'status'    => 'Cookie Exist'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'Server error'
            ]);
        }
    }
}
