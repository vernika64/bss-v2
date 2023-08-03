<?php

namespace App\Http\Controllers;

use App\Models\BankBukuTabunganWadiah;
use App\Models\BankTransaksiTabunganWadiah;
use App\Models\SysLog;
use App\Models\SysUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MetodeBerguna extends Controller
{
    public function outErrCatch($desc)
    {
        $ModelLog   = new SysLog();

        $ModelLog->buatErrorLog($desc);

        $output     = [
            'status'    => 500,
            'qr_status' => false,
            'message'   => 'Terjadi kesalahan di server, silahkan menghubungi staff IT website'
        ];

        return $output;
    }

}
