<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class BankTransaksiTabunganWadiah extends Model
{
    use HasFactory;

    protected $table        = 'bank_transaksi_tabungan_wadiah';
    protected $primaryKey   = 'id';
    protected $fillable = [
        'id',
        'kd_transaksi_tabungan',
        'kd_buku_tabungan',
        'jenis_transaksi',
        'no_nota_fisik',
        'nominal_transaksi',
        'kd_admin',
        'kd_bank'
    ];

    public function lihatRiwayatTransaksi($data) {
        try {
            $kd_buku_tabungan           = $data;

            $ModelTransaksi             = BankTransaksiTabunganWadiah::where(['kd_buku_tabungan' => $kd_buku_tabungan])->get();

            $output                     = new stdClass;
            $output->status             = true;
            $output->message            = 'Data berhasil diambil';
            $output->kd_buku_tabungan   = $kd_buku_tabungan;
            $output->nominal            = $ModelTransaksi->sum('nominal_transaksi');
            
            return $output;
        } catch (\Throwable $th) {
            $buat_log                   = new SysLog();

            $buat_log->buatErrorLog($th->getMessage());

            $output                     = new stdClass;
            $output->status             = false;
            $output->message            = 'Terjadi kesalahan di server, mohon mencoba kembali';

            return $output;
        }
        
    }

    public function totalNominalTabunganByBank($kd_bank) {
        try {
            $query                      = ['kd_bank' => $kd_bank];

            $ModelTrTabungan            = BankTransaksiTabunganWadiah::where($query)->get();

            $output                     = new stdClass;
            $output->status             = true;
            $output->message            = 'Total Nominal Tabungan di Bank berhasil diambil';
            $output->nominal            = $ModelTrTabungan->sum('nominal_transaksi');

            return $output;
        } catch (\Throwable $th) {
            $buat_log                   = new SysLog();

            $buat_log->buatErrorLog($th->getMessage());

            $output                     = new stdClass;
            $output->status             = false;
            $output->message            = 'Terjadi kesalahan di server, mohon mencoba kembali';

            return $output;
        }
    }
}
