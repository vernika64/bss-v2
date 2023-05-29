<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MetodeBerguna extends Controller
{
    public function outErrCatch($data)
    {
        $output = [
            'data'      => $data,
            'status'    => 500,
            'message'   => 'Terjadi kesalahan di server, silahkan menghubungi staff IT website'
        ];

        return $output;
    }
}
