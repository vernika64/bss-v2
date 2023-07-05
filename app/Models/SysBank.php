<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class SysBank extends Model
{
    use HasFactory;

    protected $table        = 'sys_bank';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'kd_bank',
        'kd_unik_bank',
        'nama_bank',
        'alamat_bank',
        'kd_admin'
    ];
    
    // Cari berdasarkan kode bank (id)
    public function cariDataBankById($kdbank) {
        try {
            $query                  = SysBank::find($kdbank)->first();
            
            if($query != null) {
                $output                 = new stdClass;
                $output->status         = true;
                $output->nama_bank      = $query->nama_bank;
                $output->alamat_bank    = $query->alamat_bank;
    
                return $output;
            } else {
                $output                 = new stdClass;
                $output->status         = false;
            }
        } catch (\Throwable $th) {
            $output             = new stdClass();
            $output->status     = false;

            return $output;
        }
    }

}
