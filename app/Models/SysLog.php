<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysLog extends Model
{
    use HasFactory;

    protected $table = 'sys_log';

    function buatErrorLog($desc) {
        $model = new SysLog();
        $model->metode       = $_SERVER['REQUEST_METHOD'];
        $model->url          = $_SERVER['REQUEST_URI'];
        $model->status       = 500;
        $model->desc         = $desc;
        $model->ip_address   = $_SERVER['REMOTE_ADDR'];
        $model->save();

        return true;
    }
}
