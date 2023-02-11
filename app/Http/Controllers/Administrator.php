<?php

namespace App\Http\Controllers;

use App\Models\BankBukuAkuntansi;
use App\Models\SysBank;
use App\Models\SysBukuAkuntansi;
use App\Models\SysMasterBukuAkuntansi;
use App\Models\SysRole;
use App\Models\SysToken;
use App\Models\SysUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Administrator extends Controller
{
    protected $admin_test = 1;

    public function getMemberDataAll(Request $re)
    {
        try {


            $ModelUser = SysUser::whereNotIn('sys_user.id', [1])
                ->join('sys_bank', 'sys_user.kd_bank', '=', 'sys_bank.id')
                ->join('sys_role', 'sys_user.role', '=', 'sys_role.kd_role')
                ->get(['fname', 'nama_bank', 'nama_role']);

            if (empty($ModelUser)) {
                // Jika nilainya 0 atau NULL
                return "datanya gada";
            }

            return response()->json([
                'data'      => $ModelUser,
                'status'    => 'getdata_success'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'server_error'
            ]);
        }
    }

    public function getMemberDataByBankId($bankKeys)
    {
        try {
            $ModelBank = SysBank::where('kd_bank', $bankKeys)->first();

            if(empty($ModelBank))
            {
                return response()->json([
                    'message'   => 'Bank tidak ditemukan',
                    'status'    => false
                ]);
            }

            $ModelUser = SysUser::where('kd_bank', $ModelBank->id)
                         ->join('sys_role', 'sys_user.role', '=', 'sys_role.kd_role')
                         ->get(['username', 'nama_role']);

            if($ModelUser->count() == 0) {
                return response()->json([
                    'message'       => 'Bank tidak mempunyai karyawan',
                    'status'        => false
                ]);
            }

            return response()->json([
                'data'      => $ModelUser,
                'status'    => true,
                'message'   => 'Data karyawan tersedia'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'server_error'
            ]);
        }
    }

    public function addNewMember(Request $re)
    {
        try {
            $ModelUser = new SysUser;

            $username = strtolower($re->username);

            $ModelUser->username       = $username;
            $ModelUser->password       = Hash::make($username);
            $ModelUser->fname          = $re->username;
            $ModelUser->role           = $re->pekerjaan;
            $ModelUser->kd_bank        = $re->bankTujuan;
            $ModelUser->save();

            $ModelBank = SysBank::find($re->bankTujuan);
            
            return response()->json([
                'status'      => true,
                'message'     => $username . ' berhasil ditambahkan dan terdaftar di ' . $ModelBank->nama_bank
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => false,
                'message'   => 'Server Error!'
            ]);
        }
    }

    public function getBankList()
    {
        try {
            $ModelBank = SysBank::get(['id', 'kd_bank', 'nama_bank', 'alamat_bank']);

            return response()->json([
                'data'          => $ModelBank,
                'status'        => 'getdata_success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'server_error'
            ]);
        }
    }

    public function getBankListById($keys)
    {
        try {

            $ModelBank = SysBank::where('kd_bank', $keys)->firstOrFail();

            if (!$ModelBank) {
                return response()->json([
                    'status'        => 'data_notfound'
                ]);
            }

            return response()->json([
                'data'              => $ModelBank
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'server_error'
            ]);
        }
    }

    public function addBankNew(Request $re)
    {
        try {
            $getUserCookie = $re->cookie('tkn');

            $ModelToken = SysToken::where('token', $getUserCookie)->first();

            if(empty($ModelToken))
            {
                return response('Error 403 - Forbidden', 403);
            }

            $ModelUser = SysUser::where('username', $ModelToken->kd_user)->first();

            if(empty($ModelUser))
            {
                return response('Error 404 - User not found', 403);
            }

            $ModelBank = new SysBank;

            $kalkulasiJumlahBank    = SysBank::count() + 1;
            // $kalkulasiJumlahBank    = SysBank::increment();
            $formatKodeBank         = Carbon::now()->format('Y-m-d') . '-' . $kalkulasiJumlahBank; // Format : Tahun - Bulan - Hari - Jumlah Bank yang terdaftar di database

            $ModelBank->kd_bank         = $formatKodeBank;
            $ModelBank->nama_bank       = $re->namabank;
            $ModelBank->kd_unik_bank    = 200 + $kalkulasiJumlahBank;
            $ModelBank->alamat_bank     = $re->alamatbank;
            $ModelBank->kd_admin        = $ModelUser->id;
            $ModelBank->save();

            $CheckBank = SysBank::where('kd_bank', $formatKodeBank)->first();

            if(empty($CheckBank))
            {
                return response()->json([
                    'status'        => false,
                    'message'       => 'Bank berhasil disimpan namun buku akuntansi gagal dibuat'
                ]);
            }

            $ModelMasterBukuAkuntansi   = SysMasterBukuAkuntansi::get();

            foreach ($ModelMasterBukuAkuntansi as $mmba) { 
                $ModelAkunBank                      = new BankBukuAkuntansi;
                $ModelAkunBank->kd_akun_akuntansi   = $mmba->id;
                $ModelAkunBank->kd_bank             = $CheckBank->id;
                $ModelAkunBank->nominal_akun        = 0;
                $ModelAkunBank->kd_pembuat          = $ModelUser->id;
                $ModelAkunBank->kd_terakhir_update  = $ModelUser->id;
                $ModelAkunBank->save();
            }

            return response()->json([
                'status'        => true,
                'message'       => $re->namabank . ' berhasil ditambahkan'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => false,
                'message'   => 'Server Error!'
            ]);
        }
    }

    public function getRoleList()
    {
        try {
            $ModelRole = SysRole::whereNotIn('kd_role', ['admin'])->get(['kd_role', 'nama_role']);

            return response()->json([
                'data'      => $ModelRole,
                'status'    => 'getdata_success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => 'server_error'
            ]);
        }
    }

    public function getSysMasterBukuAkuntansiAll(Request $re)
    {
        try {
            $getUserCookie = $re->cookie('tkn');

            $ModelToken = SysToken::where('token', $getUserCookie)->first();

            if(empty($ModelToken))
            {
                return response('Error 403 - Forbidden', 403);
            }

            $ModelUser = SysUser::where('username', $ModelToken->kd_user)->first();

            if(empty($ModelUser))
            {
                return response('Error 404 - User not found', 403);
            }

            $ModelMasterBukuAkuntansi = SysMasterBukuAkuntansi::all();

            return response()->json([
                'data'      => $ModelMasterBukuAkuntansi,
                'status'    => true
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => false
            ]);
        }
    }

    public function cekSubMasterBukuAkuntansi($id, Request $re)
    {
        try {
            $getUserCookie = $re->cookie('tkn');

            $ModelToken = SysToken::where('token', $getUserCookie)->first();

            if(empty($ModelToken))
            {
                return response('Error 403 - Forbidden', 403);
            }

            $ModelUser = SysUser::where('username', $ModelToken->kd_user)->first();

            if(empty($ModelUser))
            {
                return response('Error 404 - User not found', 403);
            }

            $ModelMasterBukuAkuntansi = SysMasterBukuAkuntansi::where('kd_sub_master_buku', $id)->first();

            if(!empty($ModelMasterBukuAkuntansi))
            {
                return response()->json([
                    'message'       => 'Nomor akun sudah dipakai, coba isikan nomor lain',
                    'status'        => false
                ]);
            }

            return response()->json([
                'message'           => 'Nomor akun dapat dipakai',
                'status'            => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => false
            ]);
        }
    }

    public function cekSubMasterBukuAkuntansiById($id, Request $re)
    {
        try {
            $getUserCookie = $re->cookie('tkn');

            $ModelToken = SysToken::where('token', $getUserCookie)->first();

            if(empty($ModelToken))
            {
                return response('Error 403 - Forbidden', 403);
            }

            $ModelUser = SysUser::where('username', $ModelToken->kd_user)->first();

            if(empty($ModelUser))
            {
                return response('Error 404 - User not found', 403);
            }

            $ModelMasterBukuAkuntansi = SysMasterBukuAkuntansi::find($id);

            if(empty($ModelMasterBukuAkuntansi)){
                return response()->json([
                    'status'        => false,
                    'message'       => 'Data tidak ditemukan'
                ]);
            }

            return response()->json([
                'status'            => true,
                'data'              => $ModelMasterBukuAkuntansi,
                'message'           => 'Data ditemukan'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => false
            ]);
        }
    }

    public function insertSubMasterBukuAkuntansi(Request $re)
    {
        try {
            $getUserCookie = $re->cookie('tkn');

            $ModelToken = SysToken::where('token', $getUserCookie)->first();

            if(empty($ModelToken))
            {
                return response('Error 403 - Forbidden', 403);
            }

            $ModelUser = SysUser::where('username', $ModelToken->kd_user)->first();

            if(empty($ModelUser))
            {
                return response('Error 404 - User not found', 403);
            }

            $ModelMasterBukuAkuntansi = new SysMasterBukuAkuntansi;
            $ModelMasterBukuAkuntansi->kd_master_buku           = $re->kd_master_buku;
            $ModelMasterBukuAkuntansi->kd_sub_master_buku       = $re->kd_sub_master_buku;
            $ModelMasterBukuAkuntansi->nama_buku                = $re->nama_buku;
            $ModelMasterBukuAkuntansi->kd_admin                 = $ModelUser->id;
            $ModelMasterBukuAkuntansi->save();

            return response()->json([
                'status'        => true,
                'message'       => 'Data berhasil disimpan'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => false
            ]);
        }
    }
    
    public function getBallanceSheet($id, Request $re)
    {
        try {

            $getUserCookie = $re->cookie('tkn');

            $ModelToken = SysToken::where('token', $getUserCookie)->first();

            if(empty($ModelToken))
            {
                return response('Error 403 - Forbidden', 403);
            }

            $ModelUser = SysUser::where('username', $ModelToken->kd_user)->first();

            if(empty($ModelUser))
            {
                return response('Error 404 - User not found', 403);
            }

            $ModelBank = SysBank::where('kd_bank', $id)->first();

            if(empty($ModelBank)) {
                return response()->json([
                    'status'        => false,
                    'message'       => 'Bank tidak ditemukan'
                ]);
            }

            $ModelBukuAkuntansiBank     = BankBukuAkuntansi::where('kd_bank', $ModelBank->id)->get(['kd_akun_akuntansi', 'nominal_akun']);

            $akun_aktiva       = [];
            $akun_kewajiban    = [];
            $total_aktiva      = 0;
            $total_pasiva      = 0;

            foreach ($ModelBukuAkuntansiBank as $mb) {
                $CariBuku = SysMasterBukuAkuntansi::find($mb->kd_akun_akuntansi);
                $data = [
                    'kode_master_buku_akuntansi'    => $CariBuku->kd_master_buku,
                    'kode_sub_buku_akuntansi'       => $CariBuku->kd_sub_master_buku,
                    'nama_akun'                     => $CariBuku->nama_buku,
                    'nominal_akun'                  => $mb->nominal_akun
                ];

                if($CariBuku->kd_master_buku == 1 || $CariBuku->kd_master_buku == 2)
                {
                    array_push($akun_aktiva, $data);
                    $total_aktiva = $total_aktiva + $mb->nominal_akun;

                } else if($CariBuku->kd_master_buku == 3 || $CariBuku->kd_master_buku == 4)
                {
                    array_push($akun_kewajiban, $data);
                    $total_pasiva = $total_pasiva + $mb->nominal_akun;
                }
            }

            if($total_aktiva == $total_pasiva) {
                $status_neraca      = "Seimbang";
            } else {
                $status_neraca      = "Tidak Seimbang";
            }

            return response()->json([
                'aktiva'            => $akun_aktiva,
                'pasiva'            => $akun_kewajiban,
                'total_aktiva'      => $total_aktiva,
                'total_pasiva'      => $total_pasiva,
                'status_neraca'     => $status_neraca
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => false
            ]);
        }
    }

    public function editSubMasterBukuAkuntansi(Request $re)
    {
        try {
            $getUserCookie = $re->cookie('tkn');

            $ModelToken = SysToken::where('token', $getUserCookie)->first();

            if(empty($ModelToken))
            {
                return response('Error 403 - Forbidden', 403);
            }

            $ModelUser = SysUser::where('username', $ModelToken->kd_user)->first();

            if(empty($ModelUser))
            {
                return response('Error 404 - User not found', 403);
            }

            $ModelMasterBukuAkuntansi = SysMasterBukuAkuntansi::find($re->kd_buku);

            $ModelMasterBukuAkuntansi->nama_buku        = $re->nama_buku_baru;
            $ModelMasterBukuAkuntansi->save();

            return response()->json([
                'status'        => true,
                'message'       => 'Data berhasil disimpan'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => false
            ]);
        }
    }

    public function cekKelengkapanJurnal($id, Request $re)
    {
        try {
            $getUserCookie = $re->cookie('tkn');

            $ModelToken = SysToken::where('token', $getUserCookie)->first();

            if(empty($ModelToken))
            {
                return response('Error 403 - Forbidden', 403);
            }

            $ModelUser = SysUser::where('username', $ModelToken->kd_user)->first();
        
            if(empty($ModelUser))
            {
                return response('Error 404 - User not found', 403);
            }

            // $kodeadmin  = $ModelUser->id;
            // $kodebank   = $ModelUser->kd_bank;

            $ModelBank              = SysBank::where('kd_bank', $id)->first();

            if(empty($ModelBank)) {
                return response()->json([
                    'status'        => false,
                    'message'       => 'Bank tidak terdaftar'
                ]);
            }

            $BukuAkuntansiSistem        = SysMasterBukuAkuntansi::get('id');
            $JumlahBukuAkuntansiSistem  = SysMasterBukuAkuntansi::count();
            $DataBukuTersedia           = [];
            $JumlahBukuTersedia         = 0;
            $DataBukuKosong           = [];
            $JumlahBukuKosong         = 0;

            for ($i=0; $i < $JumlahBukuAkuntansiSistem; $i++) { 
                $CekKetersediaanJurnal  = BankBukuAkuntansi::where([
                    'kd_akun_akuntansi' => $BukuAkuntansiSistem[$i]['id'],
                    'kd_bank'           => $ModelBank->id
                ])->get();
                 
                $a  = $BukuAkuntansiSistem[$i];

                if($CekKetersediaanJurnal->count() == 0)
                {
                    // array_push($DataBukuKosong, $a);
                    $JumlahBukuKosong++;

                    $ModelMasterBkAkuntansi = SysMasterBukuAkuntansi::find($BukuAkuntansiSistem[$i]['id']);
                    $DataBukuKosong[] = [
                        'indeks'        => $ModelMasterBkAkuntansi->id,
                        'kd_buku'       => $ModelMasterBkAkuntansi->kd_sub_master_buku, 
                        'nama_buku'     => $ModelMasterBkAkuntansi->nama_buku,
                    ];

                } else if($CekKetersediaanJurnal->count() == 1){
                    // array_push($DataBukuTersedia, $a);
                    $DataBukuTersedia[] = $a;
                    $JumlahBukuTersedia++;
                }
            }

            if($JumlahBukuKosong > 0) {
                $StatusBukuAkuntansi    = false;
            } else if($JumlahBukuKosong == 0) {
                $StatusBukuAkuntansi    = true;
            }

            return response()->json([
                'data_jurnal_tersedia'      => $DataBukuTersedia,
                'count_jurnal_tersedia'     => $JumlahBukuTersedia,
                'data_jurnal_kosong'        => $DataBukuKosong,
                'count_jurnal_kosong'       => $JumlahBukuKosong,
                'message'                   => 'Data jurnal bank berhasil diambil',
                'status'                    => true,
                'status_isi_buku'           => $StatusBukuAkuntansi
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => false
            ]);
        }
    }

    public function updateKelengkapanBukuAkuntansi(Request $re)
    {
        try {
            $getUserCookie = $re->cookie('tkn');

            $ModelToken = SysToken::where('token', $getUserCookie)->first();

            if(empty($ModelToken))
            {
                return response('Error 403 - Forbidden', 403);
            }

            $ModelUser = SysUser::where('username', $ModelToken->kd_user)->first();
        
            if(empty($ModelUser))
            {
                return response('Error 404 - User not found', 403);
            }

            $kodeadmin  = $ModelUser->id;
            // $kodebank   = $ModelUser->kd_bank;

            $CariIdBank = SysBank::where('kd_bank', $re->kd_bank)->first();

            if(empty($CariIdBank))
            {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Bank tidak terdaftar di sistem'
                ]);
            }

            $totalData                  = $re->ids;
            $kdBank                     = $CariIdBank->id;
            $CountBukuDitambahkan       = 0;

            foreach($totalData as $td) {
                $ModelBukuAkuntansiBank                     = new BankBukuAkuntansi;
                $ModelBukuAkuntansiBank->kd_akun_akuntansi  = $td['indeks'];
                $ModelBukuAkuntansiBank->kd_bank            = $kdBank;
                $ModelBukuAkuntansiBank->nominal_akun       = 0;
                $ModelBukuAkuntansiBank->kd_pembuat         = $kodeadmin;
                $ModelBukuAkuntansiBank->kd_terakhir_update = $kodeadmin;
                $ModelBukuAkuntansiBank->save();

                $CountBukuDitambahkan++;
            }

            return response()->json([
                'status'            => true,
                'message'           => 'Buku akuntansi berhasil diperbarui',
                'count_insert'      => $CountBukuDitambahkan
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'status'    => false
            ]);
        }
    }

}
