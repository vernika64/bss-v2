<template>

<div>
    <div class="p-3 bg-white border-t flex flex-row border-b">
        <h1 class="text-2xl italic">{{ judulNavbar }}</h1>
    </div>
    <div class="pt-4 pr-6 pl-6 pb-4 bg-white overflow-auto h-full">
        <div class="grid gap-2">
            <p>Jenis Identitas</p>
            <select class="w-full border p-2" v-model="formCIF.kd_tipe">
                <option :value="''">-- Pilih Jenis Identitas --</option>
                <option :value="'ktp'">KTP</option>
                <option :value="'ktm'">KTM</option>
            </select>

            <p>Kode Identitas</p>
            <input type="text" class="w-full border p-2" v-model="formCIF.kd_identitas" />

            <p>Nama Sesuai Identitas</p>
            <input type="text" class="w-full border p-2" v-model="formCIF.nama" />

            <p>Tempat Lahir</p>
            <input type="text" class="w-full border p-2" v-model="formCIF.tempat_lahir" />

            <p>Tanggal Lahir</p>
            <input type="date" class="w-full border p-2" v-model="formCIF.tgl_lahir" />

            <p>Jenis Kelamin</p>
            <select class="w-full border p-2" v-model="formCIF.jenis_kelamin">
                <option :value="''">-- Pilih Jenis Kelamin --</option>
                <option :value="'laki'">Laki - Laki</option>
                <option :value="'perempuan'">Perempuan</option>
            </select>

            <p>Status Kawin</p>
            <select class="w-full border p-2" v-model="formCIF.status_kawin">
                <option :value="''">-- Pilih Status Kawin --</option>
                <option :value="'belum'">Belum Menikah</option>
                <option :value="'sudah'">Menikah</option>
                <option :value="'janda'">Janda</option>
                <option :value="'duda'">Duda</option>
            </select>

            <p>Kewarganegaraan</p>
            <input type="text" class="w-full border p-2" v-model="formCIF.negara" />

            <p>Alamat Domisil Sekarang</p>
            <input type="text" class="w-full border p-2" v-model="formCIF.alamat" />

            <p>RT / RW</p>
            <input type="text" class="w-full border p-2" v-model="formCIF.rt_rw" />

            <p>Desa / Kelurahan</p>
            <input type="text" class="w-full border p-2" v-model="formCIF.desa_kelurahan" />

            <p>Kecamatan</p>
            <input type="text" class="w-full border p-2" v-model="formCIF.kecamatan" />

            <p>Kabupaten / Kota</p>
            <input type="text" class="w-full border p-2" v-model="formCIF.kabupaten_kota" />

            <p>Provinsi</p>
            <input type="text" class="w-full border p-2" v-model="formCIF.provinsi" />

            <p>Kode Pos</p>
            <input type="text" class="w-full border p-2" v-model="formCIF.kode_pos" />

            <p>No. Telp</p>
            <input type="text" class="w-full border p-2" v-model="formCIF.no_telp" />

            <p>E-Mail</p>
            <input type="text" class="w-full border p-2" v-model="formCIF.email" />

            <p>Nama Ibu Kandung</p>
            <input type="text" class="w-full border p-2" v-model="formCIF.nama_ibu" />

            <p>Status Pekerjaan</p>
            <input type="text" class="w-full border p-2" v-model="formCIF.status_pekerjaan" />

            <button class="bg-blue-500 text-white p-3 mt-4" @click="simpanCIF">Simpan</button>
        </div>
    </div>
</div>

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
            }
        }
    },
    methods: {
        simpanCIF() {
            axios.post('/api/bank/tambahCIF', this.formCIF).then(insert => {
                alert('Data berhasil disimpan')
                console.log(insert.data)
            }).catch(error => {
                console.log(error)
            })
        }
    }
}
</script>