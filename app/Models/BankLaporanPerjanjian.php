<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class BankLaporanPerjanjian extends Model
{
    use HasFactory;

    protected $table    = 'bank_laporan_perjanjian';

    protected $fillable = [
        'id',
        'kd_laporan',
        'judul_laporan',
        'deskripsi',
        'kd_karyawan',
        'kd_bank'
    ];

    public function buatLaporanPerjanjian($data) {
        try {
            $query                  = new BankLaporanPerjanjian();
            
            $query->kd_laporan      = $data->kd_laporan;
            $query->no_laporan      = $data->no_laporan;
            $query->judul_laporan   = $data->judul_laporan;
            $query->deskripsi       = $data->deskripsi;
            $query->kd_karyawan     = $data->kd_karyawan;
            $query->kd_bank         = $data->kd_bank;
            $query->save();
    
            $output                 = new stdClass;
            $output->status         = true;
            $output->message        = 'Data berhasil disimpan';

            return $output;
        } catch (\Throwable $th) {
            $output                 = new stdClass;
            $output->status         = false;
            $output->message        = 'Data gagal disimpan, ' . $th->getMessage();

            return $output;
        }
        
    }

    public function hitungJumlahLaporan($kd_bank) {
        try {

            $query                  = BankLaporanPerjanjian::where(['kd_bank' => $kd_bank])->get();

            $terhitung              = count($query);

            $output                 = new stdClass;
            $output->status         = true;
            $output->count          = $terhitung;

            return $output;
            
        } catch (\Throwable $th) {
            $output                 = new stdClass;
            $output->status         = false;
            $output->message        = 'Data gagal diambil, ' . $th->getMessage();

            return $output;
        }
    }

}
