<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // Untuk Role

        DB::table('sys_role')->insert([
            'kd_role'           => 'admin',
            'nama_role'         => 'Administrator',
        ]);

        DB::table('sys_role')->insert([
            'kd_role'           => 'office',
            'nama_role'         => 'Office Serbaguna'
        ]);

        // Untuk User SuperAdmin

        DB::table('sys_user')->insert([
            'username'          => 'admin',
            'password'          => Hash::make('admin'),
            'fname'             => 'Administrator',
            'role'              => 'admin',
            'kd_bank'           => 1
        ]);

        DB::table('sys_user')->insert([
            'username'          => 'arjuna',
            'password'          => Hash::make('arjuna'),
            'fname'             => 'Arjuna',
            'role'              => 'office',
            'kd_bank'           => '2022-06-13-2'
        ]);


        // Untuk Data Bank (Untuk keperluan Testing)

        DB::table('sys_bank')->insert([
            'kd_bank'           => '2022-06-13-1',
            'kd_unik_bank'      => '201',
            'nama_bank'         => 'Bank Amanah Sejahtera',
            'alamat_bank'       => 'Jl. Sentosa',
            'kd_admin'          => 1
        ]);

        DB::table('sys_bank')->insert([
            'kd_bank'           => '2022-06-13-2',
            'kd_unik_bank'      => '202',
            'nama_bank'         => 'Bank Pembangunan Lancar',
            'alamat_bank'       => 'Jl. Lurus',
            'kd_admin'          => 1
        ]);

        // Untuk Produk Tabungan

        DB::table('sys_produk_tabungan')->insert([
            'kd_produk'         => 'WADIAH',
            'nama_produk'       => 'Tabungan Wadiah',
            'keterangan'        => 'Tabungan berakad Wadiah',
            'kd_admin'          => 1
        ]);

        // Untuk CIF

        DB::table('bank_cif')->insert([
            'kd_identitas'              => '1642530023',
            'tipe_id'                   => 'ktm',
            'nama_sesuai_identitas'     => 'Mohammad Basori Wahyudi',
            'tempat_lahir'              => 'Kota Malang',
            'tgl_lahir'                 => '1997/09/01',
            'jenis_kelamin'             => 'laki',
            'status_kawin'              => 'belum',
            'kewarganegaraan'           => 'Indonesia',
            'alamat_sekarang'           => 'Jl. Teluk Grajakan',
            'rt_rw'                     => '04/014',
            'desa_kelurahan'            => 'Kelurahan Pandanwangi',
            'kecamatan'                 => 'Blimbing',
            'kabupaten_kota'            => 'Kota Malang',
            'provinsi'                  => 'Jawa Timur',
            'kode_pos'                  => '65124',
            'no_telp'                   => '083848261647',
            'email'                     => 'yui_veronica@outlook.com',
            'nama_ibu_kandung'          => 'Robiah Siarah',
            'status_pekerjaan'          => 'Mahasiswa',
            'kd_user'                   => 1,
            'kd_bank'                   => 1,
            'created_at'                => Carbon::now(),
            'updated_at'                => Carbon::now()
        ]);

        DB::table('bank_cif')->insert([
            'kd_identitas'              => '1742530023',
            'tipe_id'                   => 'ktm',
            'nama_sesuai_identitas'     => 'Junaedi bin Jotor',
            'tempat_lahir'              => 'Kota Malang',
            'tgl_lahir'                 => '2000/12/04',
            'jenis_kelamin'             => 'laki',
            'status_kawin'              => 'belum',
            'kewarganegaraan'           => 'Indonesia',
            'alamat_sekarang'           => 'Jl. Plaosan Timur',
            'rt_rw'                     => '04/014',
            'desa_kelurahan'            => 'Kelurahan Pandanwangi',
            'kecamatan'                 => 'Blimbing',
            'kabupaten_kota'            => 'Kota Malang',
            'provinsi'                  => 'Jawa Timur',
            'kode_pos'                  => '65124',
            'no_telp'                   => '0812121212',
            'email'                     => 'junaedi@gmail.com',
            'nama_ibu_kandung'          => 'Sutiyem',
            'status_pekerjaan'          => 'Swasta',
            'kd_user'                   => 1,
            'kd_bank'                   => 1,
            'created_at'                => Carbon::now(),
            'updated_at'                => Carbon::now()
        ]);

        // Untuk Tabungan
        DB::table('bank_buku_tabungan_wadiah')->insert([
            'kd_produk_tabungan'        => 1,
            'kd_buku_tabungan'          => '201-2022-07-06-1',
            'kd_cif'                    => 1,
            'kd_bank'                   => 1,
            'total_nilai'               => 0,
            'kd_admin'                  => 1
        ]);

        // Untuk Starter Buku Akuntansi Bank dengan Kode Admin 1 + Kode Bank 1

        DB::table('sys_buku_akuntansi')->insert([
            'kd_master_buku'        => 1,
            'kd_sub_master_buku'    => 11001,
            'kd_bank'               => 1,
            'nama_buku'             => 'Kas Operasional',
            'nominal'               => 0,
            'kd_admin'              => 1,
            'created_at'            => Carbon::now(),
            'updated_at'            => Carbon::now(),
        ]);

        DB::table('sys_buku_akuntansi')->insert([
            'kd_master_buku'        => 1,
            'kd_sub_master_buku'    => 11002,
            'kd_bank'               => 1,
            'nama_buku'             => 'Marjin Produk Murabahah',
            'nominal'               => 0,
            'kd_admin'              => 1,
            'created_at'            => Carbon::now(),
            'updated_at'            => Carbon::now(),
        ]);

        DB::table('sys_buku_akuntansi')->insert([
            'kd_master_buku'        => 1,
            'kd_sub_master_buku'    => 11003,
            'kd_bank'               => 1,
            'nama_buku'             => 'Uang Muka Produk Jual Beli Murabahah',
            'nominal'               => 0,
            'kd_admin'              => 1,
            'created_at'            => Carbon::now(),
            'updated_at'            => Carbon::now(),
        ]);

        DB::table('sys_buku_akuntansi')->insert([
            'kd_master_buku'        => 1,
            'kd_sub_master_buku'    => 13201,
            'kd_bank'               => 1,
            'nama_buku'             => 'Piutang Murabahah',
            'nominal'               => 0,
            'kd_admin'              => 1,
            'created_at'            => Carbon::now(),
            'updated_at'            => Carbon::now(),
        ]);

        DB::table('sys_buku_akuntansi')->insert([
            'kd_master_buku'        => 1,
            'kd_sub_master_buku'    => 13202,
            'kd_bank'               => 1,
            'nama_buku'             => 'Aset Fisik Akad Murabahah',
            'nominal'               => 0,
            'kd_admin'              => 1,
            'created_at'            => Carbon::now(),
            'updated_at'            => Carbon::now(),
        ]);

        DB::table('sys_buku_akuntansi')->insert([
            'kd_master_buku'        => 3,
            'kd_sub_master_buku'    => 31002,
            'kd_bank'               => 1,
            'nama_buku'             => 'Hutang Dari Bank Lain',
            'nominal'               => 0,
            'kd_admin'              => 1,
            'created_at'            => Carbon::now(),
            'updated_at'            => Carbon::now(),
        ]);

        DB::table('sys_buku_akuntansi')->insert([
            'kd_master_buku'        => 4,
            'kd_sub_master_buku'    => 41001,
            'kd_bank'               => 1,
            'nama_buku'             => 'Dari Pemilik',
            'nominal'               => 0,
            'kd_admin'              => 1,
            'created_at'            => Carbon::now(),
            'updated_at'            => Carbon::now(),
        ]);

        // DB::table('sys_superadmin')->insert([
        //     'username'          => 'admin',
        //     'password'          => Hash::make('admin'),
        //     'ign'               => 'Superadmin',
        //     'role'              => 1,
        //     'created_at'        => Carbon::now(),
        //     'updated_at'        => Carbon::now()
        // ]);

        // // Untuk Role

        // DB::table('sys_role')->insert([
        //     'nama_role'         => 'Administrator',
        //     'created_at'        => Carbon::now(),
        //     'updated_at'        => Carbon::now()
        // ]);

        // // Untuk Tipe ID

        // DB::table('sys_tipe_id')->insert([
        //     'kd_kartu'          => 'NIM-PLNM',
        //     'nama_kartu'        => 'Kartu Mahasiswa Polinema',
        //     'created_at'        => Carbon::now(),
        //     'updated_at'        => Carbon::now()
        // ]);

        // DB::table('sys_tipe_id')->insert([
        //     'kd_kartu'          => 'KTP-ID',
        //     'nama_kartu'        => 'Kartu Tanda Penduduk Indonesia',
        //     'created_at'        => Carbon::now(),
        //     'updated_at'        => Carbon::now()
        // ]);

        // // Untuk Grup

        // DB::table('sys_grup')->insert([
        //     'kd_grup'           => 'D4KEU2-2016',
        //     'nama_grup'         => 'D4 Keuangan 2 Angkatan 2016',
        //     'deskripsi_grup'    => 'D4 Keuangan 2 Angkatan 2016',
        //     'kd_admin'          => 1,
        //     'created_at'        => Carbon::now(),
        //     'updated_at'        => Carbon::now()
        // ]);

        // DB::table('sys_grup')->insert([
        //     'kd_grup'           => 'D4KEU2-2017',
        //     'nama_grup'         => 'D4 Keuangan 2 Angkatan 2017',
        //     'deskripsi_grup'    => 'D4 Keuangan 2 Angkatan 2017',
        //     'kd_admin'          => 1,
        //     'created_at'        => Carbon::now(),
        //     'updated_at'        => Carbon::now()
        // ]);

        // DB::table('sys_grup')->insert([
        //     'kd_grup'           => 'D4KEU2-2018',
        //     'nama_grup'         => 'D4 Keuangan 2 Angkatan 2018',
        //     'deskripsi_grup'    => 'D4 Keuangan 2 Angkatan 2018',
        //     'kd_admin'          => 1,
        //     'created_at'        => Carbon::now(),
        //     'updated_at'        => Carbon::now()
        // ]);

        // DB::table('sys_grup')->insert([
        //     'kd_grup'           => 'D4KEU2-2019',
        //     'nama_grup'         => 'D4 Keuangan 2 Angkatan 2019',
        //     'deskripsi_grup'    => 'D4 Keuangan 2 Angkatan 2019',
        //     'kd_admin'          => 1,
        //     'created_at'        => Carbon::now(),
        //     'updated_at'        => Carbon::now()
        // ]);


        // // Untuk Sys User

        // DB::table('sys_user')->insert([
        //     'uid'               => 'admin',
        //     'tipe_id'           => 'KTM',
        //     'nama_lengkap'      => 'Administrator',
        //     'role'              => 'admin',
        //     'password'          => Hash::make('admin'),
        //     'kd_grup'           => NULL,
        //     'kd_admin'          => NULL,
        //     'created_at'        => Carbon::now(),
        //     'updated_at'        => Carbon::now()
        // ]);

        // DB::table('sys_user')->insert([
        //     'uid'               => '1642530023',
        //     'tipe_id'           => 'KTM',
        //     'nama_lengkap'      => 'Mohammad Basori Wahyudi',
        //     'role'              => NULL,
        //     'password'          => NULL,
        //     'kd_grup'           => 1,
        //     'kd_bank'           => 1,
        //     'kd_admin'          => 1,
        //     'created_at'        => Carbon::now(),
        //     'updated_at'        => Carbon::now()
        // ]);

        // DB::table('sys_user')->insert([
        //     'uid'               => '174561230',
        //     'tipe_id'           => 'KTM',
        //     'nama_lengkap'      => 'Bagong Tunjung Kali',
        //     'role'              => NULL,
        //     'password'          => NULL,
        //     'kd_grup'           => 1,
        //     'kd_bank'           => 1,
        //     'kd_admin'          => 1,
        //     'created_at'        => Carbon::now(),
        //     'updated_at'        => Carbon::now()
        // ]);

        // DB::table('sys_user')->insert([
        //     'uid'               => '189654231',
        //     'tipe_id'           => 'KTM',
        //     'nama_lengkap'      => 'Junaedi bin Jotor',
        //     'role'              => NULL,
        //     'password'          => NULL,
        //     'kd_grup'           => 1,
        //     'kd_bank'           => 1,
        //     'kd_admin'          => 1,
        //     'created_at'        => Carbon::now(),
        //     'updated_at'        => Carbon::now()
        // ]);

    }
}
