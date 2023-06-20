<template>

<div>
    <div class="p-3 mb-3 bg-white border-t flex flex-row border-b">
        <h1 class="text-2xl italic">{{ judulNavbar }}</h1>
    </div>
    <div class="pt-4 pr-6 pl-6 pb-4 bg-white overflow-auto">
        <div class="grid gap-4">

            <p>Jenis Identitas</p>
            <select class="border border-slate-300 bg-white pt-1 pb-1 pl-2 rounded-md h-[50px]" v-model="formCIF.kd_tipe">
                <option :value="''">-- Pilih Jenis Identitas --</option>
                <option :value="'ktp'">KTP</option>
                <option :value="'ktm'">KTM</option>
            </select>

            <p>Kode Identitas</p>
            <input type="text" class="border border-slate-300 bg-white pt-1 pb-1 pl-2 rounded-md h-[50px]" v-model="formCIF.kd_identitas" placeholder="Kode Identitas sesuai dengan Kartu Identitas" />
    
            <p>Nama Sesuai Identitas</p>
            <input type="text" class="border border-slate-300 bg-white pt-1 pb-1 pl-2 rounded-md h-[50px]" v-model="formCIF.nama" placeholder="Nama Lengkap sesuai Kartu Identitas" />
    
            <p>Tempat Lahir</p>
            <input type="text" class="border border-slate-300 bg-white pt-1 pb-1 pl-2 rounded-md h-[50px]" v-model="formCIF.tempat_lahir" placeholder="Tempat Lahir sesuai Kartu Identitas" />
    
            <p>Tanggal Lahir</p>
            <input type="date" class="border border-slate-300 bg-white pt-1 pb-1 pl-2 rounded-md h-[50px]" v-model="formCIF.tgl_lahir" placeholder="Tanggal Lahir sesuai Kartu Identitas" />
    
            <p>Jenis Kelamin</p>
            <select class="border border-slate-300 bg-white pt-1 pb-1 pl-2 rounded-md h-[50px]" v-model="formCIF.jenis_kelamin">
                <option :value="''">-- Pilih Jenis Kelamin --</option>
                <option :value="'laki'">Laki - Laki</option>
                <option :value="'perempuan'">Perempuan</option>
            </select>
    
            <p>Status Kawin</p>
            <select class="border border-slate-300 bg-white pt-1 pb-1 pl-2 rounded-md h-[50px]" v-model="formCIF.status_kawin">
                <option :value="''">-- Pilih Status Kawin --</option>
                <option :value="'belum'">Belum Menikah</option>
                <option :value="'sudah'">Menikah</option>
                <option :value="'janda'">Janda</option>
                <option :value="'duda'">Duda</option>
            </select>

            <p>Kewarganegaraan</p>
            <input type="text" class="border border-slate-300 bg-white pt-1 pb-1 pl-2 rounded-md h-[50px]" v-model="formCIF.negara" placeholder="Kewarganegaraan sekarang. Contoh : WNI" />
    
            <p>Alamat Domisil Sekarang</p>
            <input type="text" class="border border-slate-300 bg-white pt-1 pb-1 pl-2 rounded-md h-[50px]" v-model="formCIF.alamat" placeholder="Alamat tempat tinggal sekarang" />
    
            <p>RT / RW</p>
            <input type="text" class="border border-slate-300 bg-white pt-1 pb-1 pl-2 rounded-md h-[50px]" v-model="formCIF.rt_rw" placeholder="RT / RW" />
    
            <p>Desa / Kelurahan</p>
            <input type="text" class="border border-slate-300 bg-white pt-1 pb-1 pl-2 rounded-md h-[50px]" v-model="formCIF.desa_kelurahan" placeholder="Contoh : Kelurahan Pandanwangi" />
    
            <p>Kecamatan</p>
            <input type="text" class="border border-slate-300 bg-white pt-1 pb-1 pl-2 rounded-md h-[50px]" v-model="formCIF.kecamatan" placeholder="Contoh : Kecamatan Blimbing" />
    
            <p>Kabupaten / Kota</p>
            <input type="text" class="border border-slate-300 bg-white pt-1 pb-1 pl-2 rounded-md h-[50px]" v-model="formCIF.kabupaten_kota" placeholder="Contoh : Kota Malang" />
    
            <p>Provinsi</p>
            <input type="text" class="border border-slate-300 bg-white pt-1 pb-1 pl-2 rounded-md h-[50px]" v-model="formCIF.provinsi" placeholder="Contoh : Jawa Timur" />
    
            <p>Kode Pos</p>
            <input type="text" class="border border-slate-300 bg-white pt-1 pb-1 pl-2 rounded-md h-[50px]" v-model="formCIF.kode_pos" placeholder="Contoh : 65124" />
    
            <p>No. Telp</p>
            <input type="text" class="border border-slate-300 bg-white pt-1 pb-1 pl-2 rounded-md h-[50px]" v-model="formCIF.no_telp" placeholder="Contoh : 083848261647" />
    
            <p>E-Mail</p>
            <input type="text" class="border border-slate-300 bg-white pt-1 pb-1 pl-2 rounded-md h-[50px]" v-model="formCIF.email" placeholder="Contoh : kucingterbang@gmail.com" />
    
            <p>Nama Ibu Kandung</p>
            <input type="text" class="border border-slate-300 bg-white pt-1 pb-1 pl-2 rounded-md h-[50px]" v-model="formCIF.nama_ibu" placeholder="Nama Ibu Kandung Pelanggan" />
    
            <p>Status Pekerjaan</p>
            <input type="text" class="border border-slate-300 bg-white pt-1 pb-1 pl-2 rounded-md h-[50px]" v-model="formCIF.status_pekerjaan" placeholder="Pekerjaan sekarang" />

            <button class="bg-blue-500 text-white p-3 mt-4" @click="modalKonfirmasiStatus = true">Simpan</button>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Tambah CIF -->

<Transition name="slide-fade">
    <div class="flex flex-col w-full h-full bg-slate-900 left-0 top-0 fixed bg-opacity-70 justify-center align-middle" v-if="modalKonfirmasiStatus == true">
        <div class="relative bg-white rounded-lg shadow p-4 m-auto md:w-1/3 2xl:w-1/4">
            <div class="grid grid-rows-1">
                <h1 class="text-xl text-black mb-5">Konfirmasi CIF Baru</h1>
                <div class="grid grid-rows-1 mb-5">

                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <button class="bg-slate-300 text-black p-2 rounded-md shadow-md" @click="modalKonfirmasiStatus = false">Batal</button>
                <button class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-md shadow-md">Simpan</button>
            </div>
        </div>
    </div>
</Transition>

</template>


<script>
import axios from 'axios'

export default {
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
            modalKonfirmasiStatus   : false,
        }
    },
    methods: {
        simpanCIF() {
            axios.post('/api/bank/tambahCIF', this.formCIF).then(insert => {
                alert(insert.data.message)
                console.log(insert.data)
            }).catch(error => {
                console.log(error)
            })
        }
    }
}
</script>