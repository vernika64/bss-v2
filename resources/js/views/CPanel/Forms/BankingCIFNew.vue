<template>

<div>
    <div class="p-3 mb-3 bg-white border-t flex flex-row border-b">
        <h1 class="text-2xl italic">{{ judulNavbar }}</h1>
    </div>
    <div class="pr-6 pl-6 bg-white">
        <div class="grid lg:grid-cols-2 grid-cols-1 gap-4">
            <!-- Box Pertama -->
            <div class="pr-2 pl-2">
                <p class="pb-2">{{ labelFormCIF.kd_tipe }}</p>
                <select class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.kd_tipe">
                    <option :value="''">-- Pilih Jenis Identitas --</option>
                    <option :value="'ktp'">KTP</option>
                    <option :value="'ktm'">KTM</option>
                </select>
    
                <p class="pb-2">{{ labelFormCIF.kd_identitas }}</p>
                <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.kd_identitas" placeholder="Kode Identitas sesuai dengan Kartu Identitas" />
        
                <p class="pb-2">{{ labelFormCIF.nama }}</p>
                <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.nama" placeholder="Nama Lengkap sesuai Kartu Identitas" />
        
                <p class="pb-2">{{ labelFormCIF.tempat_lahir }}</p>
                <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.tempat_lahir" placeholder="Tempat Lahir sesuai Kartu Identitas" />
        
                <p class="pb-2">{{ labelFormCIF.tgl_lahir }}</p>
                <input type="date" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.tgl_lahir" placeholder="Tanggal Lahir sesuai Kartu Identitas" />
        
                <p class="pb-2">{{ labelFormCIF.jenis_kelamin }}</p>
                <select class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.jenis_kelamin">
                    <option :value="''">-- Pilih Jenis Kelamin --</option>
                    <option :value="'laki'">Laki - Laki</option>
                    <option :value="'perempuan'">Perempuan</option>
                </select>
        
                <p class="pb-2">{{ labelFormCIF.status_kawin }}</p>
                <select class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.status_kawin">
                    <option :value="''">-- Pilih Status Kawin --</option>
                    <option :value="'belum'">Belum Menikah</option>
                    <option :value="'sudah'">Menikah</option>
                    <option :value="'janda'">Janda</option>
                    <option :value="'duda'">Duda</option>
                </select>

                <p class="pb-2">{{ labelFormCIF.negara }}</p>
                <input type="text" class="border border-slate-300 mb-2 bg-white pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.negara" placeholder="Kewarganegaraan sekarang. Contoh : WNI" />
                
                <button class="bg-blue-500 text-white p-3 mt-4" @click="modalKonfirmasiStatus = true">Simpan</button>

            </div>

            <!-- Box Kedua -->
            <div class="pr-2 pl-2">
    
                <p class="pb-2">{{ labelFormCIF.alamat }}</p>
                <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.alamat" placeholder="Alamat tempat tinggal sekarang" />
    
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <p class="pb-2">{{ labelFormCIF.rt_rw }}</p>
                        <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 w-full rounded-md h-[50px]" v-model="formCIF.rt_rw" placeholder="RT / RW" />
                    </div>
                    <div>
                        <p class="pb-2">{{ labelFormCIF.desa_kelurahan }}</p>
                        <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 w-full rounded-md h-[50px]" v-model="formCIF.desa_kelurahan" placeholder="Contoh : Kelurahan Pandanwangi" />
                    </div>
                </div>
    
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <p class="pb-2">{{ labelFormCIF.kecamatan }}</p>
                        <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.kecamatan" placeholder="Contoh : Kecamatan Blimbing" />
                    </div>
                    <div>
                        <p class="pb-2">{{ labelFormCIF.kabupaten_kota }}</p>
                        <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.kabupaten_kota" placeholder="Contoh : Kota Malang" />
                    </div>    
                </div>
    
                <p class="pb-2">{{ labelFormCIF.provinsi }}</p>
                <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.provinsi" placeholder="Contoh : Jawa Timur" />
    
                <p class="pb-2">{{ labelFormCIF.kode_pos }}</p>
                <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.kode_pos" placeholder="Contoh : 65124" />
    
                <p class="pb-2">{{ labelFormCIF.no_telp }}</p>
                <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.no_telp" placeholder="Contoh : 083848261647" />
    
                <p class="pb-2">{{ labelFormCIF.email }}</p>
                <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.email" placeholder="Contoh : kucingterbang@gmail.com" />
    
                <p class="pb-2">{{ labelFormCIF.nama_ibu }}</p>
                <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.nama_ibu" placeholder="Nama Ibu Kandung Pelanggan" />
    
                <p class="pb-2">{{ labelFormCIF.status_pekerjaan }}</p>
                <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.status_pekerjaan" placeholder="Pekerjaan sekarang" />

            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Tambah CIF -->

<Transition name="slide-fade">
    <div class="flex flex-col w-full h-full bg-slate-900 left-0 top-0 fixed bg-opacity-70 justify-center align-middle" v-if="modalKonfirmasiStatus == true">
        <div class="relative bg-white rounded-lg shadow p-4 m-auto md:w-1/3 2xl:w-1/2">
            <div class="grid grid-rows-1">
                <h1 class="text-xl text-black mb-5">Konfirmasi CIF Baru</h1>
                <div class="grid grid-cols-3 gap-3 mb-4">
                    
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2 flex">
                            <div class="flex-auto" @click="verifikasiFormCIF.kd_tipe = true">
                                <p class="text-md">{{ labelFormCIF.kd_tipe }}</p>
                                <p class="text-lg">Kartu Tanda Penjahat</p>
                            </div>
                            <div class="flex-none m-auto" v-if="verifikasiFormCIF.kd_tipe == true">
                                <check-circle-icon class="h-7 w-7 mr-3 fill-blue-700"></check-circle-icon>
                            </div>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">{{ labelFormCIF.kd_identitas }}</p>
                            <p class="text-lg">121214</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">{{ labelFormCIF.nama }}</p>
                            <p class="text-lg">Suparno</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">{{ labelFormCIF.tempat_lahir }}</p>
                            <p class="text-lg">Malang</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">{{ labelFormCIF.tgl_lahir }}</p>
                            <p class="text-lg">20 Juli 2022</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">{{ labelFormCIF.jenis_kelamin }}</p>
                            <p class="text-lg">Lakik</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">Status Kawin</p>
                            <p class="text-lg">Jones</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">Kewarganegaraan</p>
                            <p class="text-lg">WNI</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">Alamat Domisil Sekarang</p>
                            <p class="text-lg">Jl. Teluk Bayur</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">RT / RW</p>
                            <p class="text-lg">001/001</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">Desa / Kelurahan</p>
                            <p class="text-lg">Kelurahan Joni</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">Kecamatan</p>
                            <p class="text-lg">Kecamatan Asrikraton</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">Kabupaten / Kota</p>
                            <p class="text-lg">Kabupaten Malang</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">Provinsi</p>
                            <p class="text-lg">Jawa Timur</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">Kode Pos</p>
                            <p class="text-lg">65121</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">No. Telp</p>
                            <p class="text-lg">0341212114</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">E-Mail</p>
                            <p class="text-lg">suparno@gmail.com</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">Nama Ibu Kandung</p>
                            <p class="text-lg">Suparni</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">Status Pekerjaan</p>
                            <p class="text-lg">Pejabat</p>
                        </div>
                    
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <button class="bg-slate-300 text-black p-2 rounded-md shadow-md" @click="modalKonfirmasiStatus = false">Batal</button>
                <button class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-md shadow-md" @click="simpanCIF()">Simpan</button>
            </div>
        </div>
    </div>
</Transition>

</template>


<script>
import axios from 'axios'

import { CheckCircleIcon } from '@heroicons/vue/solid'

export default {
    components: {
        CheckCircleIcon
    },
    data() {
        return {
            judulNavbar         : 'Tambah Data CIF Baru',
            formCIF             : {
                kd_identitas        : '',
                kd_tipe             : '',
                nama                : '',
                tempat_lahir        : '',
                tgl_lahir           : '',
                jenis_kelamin       : '',
                status_kawin        : '',
                negara              : '',
                alamat              : '',
                rt_rw               : '',
                desa_kelurahan      : '',
                kecamatan           : '',
                kabupaten_kota      : '',
                provinsi            : '',
                kode_pos            : '',
                no_telp             : '',
                email               : '',
                nama_ibu            : '',
                status_pekerjaan    : ''
            },
            labelFormCIF            : {
                kd_identitas        : 'Kode Identitas',
                kd_tipe             : 'Tipe Identitas',
                nama                : 'Nama sesuai Identitas',
                tempat_lahir        : 'Tempat Lahir',
                tgl_lahir           : 'Tanggal Lahir',
                jenis_kelamin       : 'Jenis Kelamin',
                status_kawin        : 'Status Kawin',
                negara              : 'Kewarganegaraan',
                alamat              : 'Alamat domisil sekarang',
                rt_rw               : 'RT / RW',
                desa_kelurahan      : 'Desa / Kelurahan',
                kecamatan           : 'Kecamatan',
                kabupaten_kota      : 'Kabupaten / Kota',
                provinsi            : 'Provinsi',
                kode_pos            : 'Kode Pos',
                no_telp             : 'No. Telp',
                email               : 'E-Mail',
                nama_ibu            : 'Nama Ibu Kandung',
                status_pekerjaan    : 'Status Pekerjaan'
            },
            verifikasiFormCIF       : {
                kd_tipe             : false
            },
            modalKonfirmasiStatus   : false,
        }
    },
    methods: {
        simpanCIF() {

            // Posting
            // axios.post('/api/bank/tambahCIF', this.formCIF).then(insert => {
            //     alert(insert.data.message)
            //     console.log(insert.data)
            // }).catch(error => {
            //     console.log(error)
            // })

            // Testing
            console.log(this.formCIF)
        }
    }
}
</script>