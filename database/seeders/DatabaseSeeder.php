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

        // Untuk User SuperAdmin

        DB::table('sys_user')->insert([
            'username'          => 'admin',
            'password'          => Hash::make('admin'),
            'role'              => 'admin',
            'kd_bank'           => 0
        ]);

        DB::table('sys_user')->insert([
            'username'          => 'arjuna',
            'password'          => Hash::make('arjuna'),
            'role'              => 'office',
            'kd_bank'           => 1
        ]);


        // // Untuk Data Bank (Untuk keperluan Testing)

        DB::table('sys_bank')->insert([
            'kd_bank'           => '2022-06-13-1',
            'nama_bank'         => 'Bank Amanah Sejahtera',
            'alamat_bank'       => 'Jl. Sentosa',
            'kd_admin'          => 1
        ]);

        DB::table('sys_bank')->insert([
            'kd_bank'           => '2022-06-13-1',
            'nama_bank'         => 'Bank Pembangunan Lancar',
            'alamat_bank'       => 'Jl. Lurus',
            'kd_admin'          => 1
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
