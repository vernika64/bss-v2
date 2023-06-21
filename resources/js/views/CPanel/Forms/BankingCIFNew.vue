<template>

<div>
    <div class="p-3 mb-3 bg-white border-t flex flex-row border-b">
        <h1 class="text-2xl italic">{{ judulNavbar }}</h1>
    </div>
    <div class="pr-6 pl-6 bg-white">
        <div class="grid lg:grid-cols-2 grid-cols-1 gap-4">
            <!-- Box Pertama -->
            <div class="pr-2 pl-2">
                <p class="pb-2">{{ propertyFormCIF.kd_tipe.label }}</p>
                <select class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.kd_tipe">
                    <option :value="''">-- Pilih Jenis Identitas --</option>
                    <option :value="'ktp'">KTP</option>
                    <option :value="'ktm'">KTM</option>
                </select>
    
                <p class="pb-2">{{ propertyFormCIF.kd_identitas.label }}</p>
                <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.kd_identitas" placeholder="Kode Identitas sesuai dengan Kartu Identitas" />
        
                <p class="pb-2">{{ propertyFormCIF.nama.label }}</p>
                <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.nama" placeholder="Nama Lengkap sesuai Kartu Identitas" />
        
                <p class="pb-2">{{ propertyFormCIF.tempat_lahir.label }}</p>
                <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.tempat_lahir" placeholder="Tempat Lahir sesuai Kartu Identitas" />
        
                <p class="pb-2">{{ propertyFormCIF.tgl_lahir.label }}</p>
                <input type="date" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.tgl_lahir" placeholder="Tanggal Lahir sesuai Kartu Identitas" />
        
                <p class="pb-2">{{ propertyFormCIF.jenis_kelamin.label }}</p>
                <select class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.jenis_kelamin">
                    <option :value="''">-- Pilih Jenis Kelamin --</option>
                    <option :value="'laki'">Laki - Laki</option>
                    <option :value="'perempuan'">Perempuan</option>
                </select>
        
                <p class="pb-2">{{ propertyFormCIF.status_kawin.label }}</p>
                <select class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.status_kawin">
                    <option :value="''">-- Pilih Status Kawin --</option>
                    <option :value="'belum'">Belum Menikah</option>
                    <option :value="'sudah'">Menikah</option>
                    <option :value="'janda'">Janda</option>
                    <option :value="'duda'">Duda</option>
                </select>

                <p class="pb-2">{{ propertyFormCIF.negara.label }}</p>
                <input type="text" class="border border-slate-300 mb-2 bg-white pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.negara" placeholder="Kewarganegaraan sekarang. Contoh : WNI" />
                
                <button class="bg-blue-500 text-white p-3 mt-4" @click="modalKonfirmasiStatus = true">Simpan</button>

            </div>

            <!-- Box Kedua -->
            <div class="pr-2 pl-2">
    
                <p class="pb-2">{{ propertyFormCIF.alamat.label }}</p>
                <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.alamat" placeholder="Alamat tempat tinggal sekarang" />
    
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <p class="pb-2">{{ propertyFormCIF.rt_rw.label }}</p>
                        <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 w-full rounded-md h-[50px]" v-model="formCIF.rt_rw" placeholder="RT / RW" />
                    </div>
                    <div>
                        <p class="pb-2">{{ propertyFormCIF.desa_kelurahan.label }}</p>
                        <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 w-full rounded-md h-[50px]" v-model="formCIF.desa_kelurahan" placeholder="Contoh : Kelurahan Pandanwangi" />
                    </div>
                </div>
    
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <p class="pb-2">{{ propertyFormCIF.kecamatan.label }}</p>
                        <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.kecamatan" placeholder="Contoh : Kecamatan Blimbing" />
                    </div>
                    <div>
                        <p class="pb-2">{{ propertyFormCIF.kabupaten_kota.label }}</p>
                        <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.kabupaten_kota" placeholder="Contoh : Kota Malang" />
                    </div>    
                </div>
    
                <p class="pb-2">{{ propertyFormCIF.provinsi.label }}</p>
                <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.provinsi" placeholder="Contoh : Jawa Timur" />
    
                <p class="pb-2">{{ propertyFormCIF.kode_pos.label }}</p>
                <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.kode_pos" placeholder="Contoh : 65124" />
    
                <p class="pb-2">{{ propertyFormCIF.no_telp.label }}</p>
                <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.no_telp" placeholder="Contoh : 083848261647" />
    
                <p class="pb-2">{{ propertyFormCIF.email.label }}</p>
                <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.email" placeholder="Contoh : kucingterbang@gmail.com" />
    
                <p class="pb-2">{{ propertyFormCIF.nama_ibu.label }}</p>
                <input type="text" class="border border-slate-300 bg-white mb-2 pt-1 pb-1 pl-2 rounded-md w-full h-[50px]" v-model="formCIF.nama_ibu" placeholder="Nama Ibu Kandung Pelanggan" />
    
                <p class="pb-2">{{ propertyFormCIF.status_pekerjaan.label }}</p>
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
                <div class="grid grid-cols-2 gap-3 mb-4">
                    
                        <div class="flex bg-white shadow-lg rounded-lg border border-slate-300 p-2" :class="['' == formCIF.kd_tipe ? 'bg-red-600 text-white' : 'bg-white text-black']">
                            <div class="flex-auto">
                                <p class="text-md">{{ propertyFormCIF.kd_tipe.label }}</p>
                                <p class="text-lg">{{ '' != formCIF.kd_tipe ? translateTipeID(formCIF.kd_tipe) : 'Data kosong' }}</p>
                            </div>
                            <div class="flex-none m-auto">
                                <check-circle-icon class="h-7 w-7 fill-blue-700" v-if="'' != formCIF.kd_tipe"></check-circle-icon>
                                <x-circle-icon class="h-7 w-7 fill-white" v-else-if="'' == formCIF.kd_tipe"></x-circle-icon>
                            </div>
                        </div>
                        <div class="flex bg-white shadow-lg rounded-lg border border-slate-300 p-2" :class="['' == formCIF.kd_identitas ? 'bg-red-600 text-white' : 'bg-white text-black']">
                            <div class="flex-auto">
                                <p class="text-md">{{ propertyFormCIF.kd_identitas.label }}</p>
                                <p class="text-lg">{{ '' != formCIF.kd_identitas ? formCIF.kd_identitas : 'Data kosong' }}</p>
                            </div>
                            <div class="flex-none m-auto">
                                <check-circle-icon class="h-7 w-7 fill-blue-700" v-if="'' != formCIF.kd_identitas"></check-circle-icon>
                                <x-circle-icon class="h-7 w-7 fill-white" v-else-if="'' == formCIF.kd_identitas"></x-circle-icon>
                            </div>
                        </div>
                        <div class="flex bg-white shadow-lg rounded-lg border border-slate-300 p-2" :class="['' == formCIF.nama ? 'bg-red-600 text-white' : 'bg-white text-black']">
                            <div class="flex-auto">
                                <p class="text-md">{{ propertyFormCIF.nama.label }}</p>
                                <p class="text-lg">{{ '' != formCIF.nama ? formCIF.nama : 'Data kosong' }}</p>
                            </div>
                            <div class="flex-none m-auto">
                                <check-circle-icon class="h-7 w-7 fill-blue-700" v-if="'' != formCIF.nama"></check-circle-icon>
                                <x-circle-icon class="h-7 w-7 fill-white" v-else-if="'' == formCIF.nama"></x-circle-icon>
                            </div>
                        </div>
                        <div class="flex bg-white shadow-lg rounded-lg border border-slate-300 p-2" :class="['' == formCIF.tempat_lahir ? 'bg-red-600 text-white' : 'bg-white text-black']">
                            <div class="flex-auto">
                                <p class="text-md">{{ propertyFormCIF.tempat_lahir.label }}</p>
                                <p class="text-lg">{{ '' != formCIF.tempat_lahir ? formCIF.tempat_lahir : 'Data kosong' }}</p>
                            </div>
                            <div class="flex-none m-auto">
                                <check-circle-icon class="h-7 w-7 fill-blue-700" v-if="'' != formCIF.tempat_lahir"></check-circle-icon>
                                <x-circle-icon class="h-7 w-7 fill-white" v-else-if="'' == formCIF.tempat_lahir"></x-circle-icon>
                            </div>
                        </div>
                        <div class="flex bg-white shadow-lg rounded-lg border border-slate-300 p-2" :class="['' == formCIF.tgl_lahir ? 'bg-red-600 text-white' : 'bg-white text-black']">
                            <div class="flex-auto">
                                <p class="text-md">{{ propertyFormCIF.tgl_lahir.label }}</p>
                                <p class="text-lg">{{ '' != formCIF.tgl_lahir ? formCIF.tgl_lahir : 'Data kosong' }}</p>
                            </div>
                            <div class="flex-none m-auto">
                                <check-circle-icon class="h-7 w-7 fill-blue-700" v-if="'' != formCIF.tgl_lahir"></check-circle-icon>
                                <x-circle-icon class="h-7 w-7 fill-white" v-else-if="'' == formCIF.tgl_lahir"></x-circle-icon>
                            </div>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">{{ propertyFormCIF.jenis_kelamin.label }}</p>
                            <p class="text-lg">Lakik</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">{{ propertyFormCIF.jenis_kelamin.label }}</p>
                            <p class="text-lg">Jones</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">{{ propertyFormCIF.negara.label }}</p>
                            <p class="text-lg">WNI</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">{{ propertyFormCIF.alamat.label }}</p>
                            <p class="text-lg">Jl. Teluk Bayur</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">{{ propertyFormCIF.rt_rw.label }}</p>
                            <p class="text-lg">001/001</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">{{ propertyFormCIF.desa_kelurahan.label }}</p>
                            <p class="text-lg">Kelurahan Joni</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">{{ propertyFormCIF.kecamatan.label }}</p>
                            <p class="text-lg">Kecamatan Asrikraton</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">{{ propertyFormCIF.kabupaten_kota.label }}</p>
                            <p class="text-lg">Kabupaten Malang</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">{{ propertyFormCIF.provinsi.label }}</p>
                            <p class="text-lg">Jawa Timur</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">{{ propertyFormCIF.kode_pos.label }}</p>
                            <p class="text-lg">65121</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">{{ propertyFormCIF.no_telp.label }}</p>
                            <p class="text-lg">0341212114</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">{{ propertyFormCIF.email.label }}</p>
                            <p class="text-lg">suparno@gmail.com</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">{{ propertyFormCIF.nama_ibu.label }}</p>
                            <p class="text-lg">Suparni</p>
                        </div>
                        <div class="bg-white shadow-lg rounded-lg border border-slate-300 p-2">
                            <p class="text-md">{{ propertyFormCIF.status_pekerjaan.label }}</p>
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

import { CheckCircleIcon, XCircleIcon } from '@heroicons/vue/solid'

export default {
    components: {
        CheckCircleIcon, XCircleIcon
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
            dummyFormCIF        : {
                tgl_lahir           : '',
            },
            propertyFormCIF            : {
                kd_identitas        : {
                    label           : 'Kode Identitas',
                    status          : ''
                },
                kd_tipe             : {
                    label           : 'Tipe Identitas',
                    status          : ''
                },
                nama                : {
                    label           : 'Nama sesuai Identitas',
                    status          : ''
                },
                tempat_lahir        : {
                    label           : 'Tempat Lahir',
                    status          : ''
                },
                tgl_lahir           : {
                    label           : 'Tanggal Lahir',
                    status          : '',
                },
                jenis_kelamin       : {
                    label           : 'Jenis Kelamin',
                    status          : ''
                },
                status_kawin        : {
                    label           : 'Status Kawin',
                    status          : ''
                },
                negara              : {
                    label           : 'Kewarganegaraan',
                    status          : ''
                },
                alamat              : {
                    label           : 'Alamat domisil sekarang',
                    status          : ''
                },
                rt_rw               : {
                    label           : 'RT / RW',
                    status          : ''
                },
                desa_kelurahan      : {
                    label           : 'Desa / Kelurahan',
                    status          : ''
                },
                kecamatan           : {
                    label           : 'Kecamatan',
                    status          : ''
                },
                kabupaten_kota      : {
                    label           : 'Kabupaten / Kota',
                    status          : ''
                },
                provinsi            : {
                    label           : 'Provinsi',
                    status          : ''
                },
                kode_pos            : {
                    label           : 'Kode Pos',
                    status          : ''
                },
                no_telp             : {
                    label           : 'No. Telp',
                    status          : ''
                },
                email               : {
                    label           : 'E-Mail',
                    status          : ''
                },
                nama_ibu            : {
                    label           : 'Nama Ibu Kandung',
                    status          : ''
                },
                status_pekerjaan    : {
                    label           : 'Status Pekerjaan',
                    status          : ''
                }
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
            const pesan = "Apakah anda sudah yakin data CIF sudah benar ?"

            if(confirm(pesan) == true) {
                console.log(this.formCIF)
            } else if(confirm(pesan) == false) {
                console.log('batal')
            } else {
                console.log('error')
            }
        },
        translateTipeID(data) {
            
            switch (data) {
                case 'ktp':
                    return 'Kartu Tanda Penjahat'
                case 'ktm':
                    return 'Kartu Tanda Mahasiwa'
                default:
                    return 'Data Kosong'
            }
        },
    }
}
</script>