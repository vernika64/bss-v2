<?php

namespace App\Models;

use App\Http\Controllers\MetodeBerguna;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class BankBukuTabunganWadiah extends Model
{
    use HasFactory;

    protected $table        = 'bank_buku_tabungan_wadiah';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'id',
        'kd_produk_tabungan',
        'kd_buku_tabungan',
        'kd_cif',
        'kd_bank',
        'total_nilai',
        'kd_admin'
    ];

    public function cariDataTabunganNasabah($data) {
        try {
            $query                      = [
                'kd_cif'                => $data->kd_cif,
                'kd_produk_tabungan'    => $data->kd_produk_tabungan
            ];

            $ModelTabungan              = BankBukuTabunganWadiah::where($query)->first();

            if($ModelTabungan->count() >= 1) {
                $output                 = new stdClass;
                $output->status         = false;
                $output->message        = 'Nasabah telah terdaftar dengan produk tabungan ini';

                return $output;
            }

            $output                     = new stdClass;
            $output->status             = true;
            $output->message            = 'Nasabah belum terdaftar dengan produk tabungan ini';

            return $output;
        } catch (\Throwable $th) {

            $buat_log       = new SysLog();

            $buat_log->buatErrorLog($th->getMessage());

            $output                     = new stdClass;
            $output->status             = false;
            $output->message            = 'Terjadi kesalahan di server, mohon mencoba kembali';

            return $output;

        }

    }

    public function buatTabunganWadiah($data) {
        try {
            $kd_produk_tabungan          = $data->kd_produk_tabungan;
            $format_buku_tabungan        = $data->format_buku_tabungan;
            $kd_cif                      = $data->kd_cif;
            $kd_bank                     = $data->kd_bank;
            $kd_admin                    = $data->kd_admin;

            $ModelBankBukuTabunganWadiah                        = new BankBukuTabunganWadiah;
            $ModelBankBukuTabunganWadiah->kd_produk_tabungan    = $kd_produk_tabungan;
            $ModelBankBukuTabunganWadiah->kd_buku_tabungan      = $format_buku_tabungan;
            $ModelBankBukuTabunganWadiah->kd_cif                = $kd_cif;
            $ModelBankBukuTabunganWadiah->kd_bank               = $kd_bank;
            $ModelBankBukuTabunganWadiah->total_nilai           = 0;
            $ModelBankBukuTabunganWadiah->kd_admin              = $kd_admin;
            $ModelBankBukuTabunganWadiah->save();

            $output                 = new stdClass;
            $output->status         = true;
            $output->message        = 'Data berhasil disimpan';

            return $output;

        } catch (\Throwable $th) {
            $buat_log       = new SysLog();

            $buat_log->buatErrorLog($th->getMessage());

            $output                     = new stdClass;
            $output->status             = false;
            $output->message            = 'Terjadi kesalahan di server, mohon mencoba kembali';

            return $output;
        }
    }
}
