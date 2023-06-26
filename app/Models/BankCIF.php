<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class BankCIF extends Model
{
    use HasFactory;

    protected $table        = 'bank_cif';
    protected $primaryKeys  = 'id';
    protected $fillable     = [
        'id',
        'kd_identitas',
        'tipe_id',
        'nama_sesuai_identitas',
        'tempat_lahir',
        'tgl_lahir',
        'jenis_kelamin',
        'status_kawin',
        'kewarganegaraan',
        'alamat_sekarang',
        'rt_rw',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
        'kode_pos',
        'no_telp',
        'email',
        'nama_ibu_kandung',
        'status_pekerjaan',
        'kd_user',
        'kd_bank'
    ];

    function getCountCIF($token){
        $ModelUser              = new SysUser();
        $DataUser               = $ModelUser->getInformasiUser($token);

        if($DataUser->status = true) {
            $ModelCIF           = BankCIF::where(['kd_bank' => $DataUser->kd_bank])->get();

            $terhitung          = count($ModelCIF);

            $output             = new stdClass;
            $output->status     = true;
            $output->count      = $terhitung;

            return $output;
        } else {
            $output             = new stdClass;
            $output->status     = false;

            return $output;
        }
    }

    // Output count dan status
    function cariStatusID($tipeID, $nomerID, $token){
        $ModelUser              = new SysUser();
        $DataUser               = $ModelUser->getInformasiUser($token);

        if($DataUser->status = true) {
            $QueryCari          = [
                'tipe_id' => $tipeID, 
                'kd_identitas' => $nomerID
            ];

            $ModelCIF           = BankCIF::where($QueryCari)->get();

            $terhitung          = count($ModelCIF);

            $output             = new stdClass;
            $output->status     = true;
            $output->count      = $terhitung;
            $output->data       = $DataUser;

            return $output;
        }
    }

    // Output Nama dan Alamat
    public function cariInfoCIFByIdDanBank($data) {
        try {

            $query                  = [
                'tipe_id'       => $data->tipe_id,
                'kd_identitas'  => $data->nomer_id,
                'kd_bank'       => $data->kd_bank
            ];
    
            $ModelCIF               = BankCIF::where($query)->first();
    
            if(!empty($ModelCIF)) {
                $output                     = new stdClass;
                $output->status             = true;
                $output->kd_identitas       = $ModelCIF->kd_identitas;
                $output->nama               = $ModelCIF->nama_sesuai_identitas;
                $output->alamat             = $ModelCIF->alamat_sekarang;
    
                return $output;
            } else {
                $output                     = new stdClass;
                $output->status             = false;
                $output->message            = 'Data CIF tidak ditemukan';

                return $output;
            }

            return $ModelCIF;
        } catch (\Throwable $th) {
            $output             = new stdClass;
            $output->status     = false;
            $output->message    = $th->getMessage();

            return $output;
        }
        
    }

}
