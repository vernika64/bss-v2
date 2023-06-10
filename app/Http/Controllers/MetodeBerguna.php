<?php

namespace App\Http\Controllers;

use App\Models\SysLog;

class MetodeBerguna extends Controller
{
    public function outErrCatch($desc)
    {
        $ModelLog   = new SysLog();

        $ModelLog->buatErrorLog($desc);

        $output     = [
            'status'    => 500,
            'message'   => 'Terjadi kesalahan di server, silahkan menghubungi staff IT website'
        ];

        return $output;
    }
}
