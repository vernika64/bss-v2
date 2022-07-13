<template>
<div class="grid grid-rows-1 ml-2 mr-2">
    <h1 class="text-2xl mb-4">Mahasiswa</h1>
    <div class="flex flex-row gap-2">
        <button class="p-2 text-white bg-black w-auto text-sm" @click="openModalAdd = true">{{ btnTambahMahasiswa }}</button>
        <button class="p-2 text-white bg-black w-auto text-sm">{{ btnImportData }}</button>
    </div>
    <div>
        <table class="border-collapse mt-4 w-full">
            <thead>
                <tr>
                    <th class="p-4 bg-slate-500 text-slate-100 bold">No.#</th>
                    <th class="p-4 bg-slate-500 text-slate-100 bold">No. Identitas</th>
                    <th class="p-4 bg-slate-500 text-slate-100 bold">Nama Lengkap</th>
                    <th class="p-4 bg-slate-500 text-slate-100 bold">Grup Kelas</th>
                    <th class="p-4 bg-slate-500 text-slate-100 bold">Terdaftar di Bank</th>
                    <th class="p-4 bg-slate-500 text-slate-100 bold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(t, index) in isiTabelMahasiswa" :key="index">
                    <td class="text-center p-2">{{ index }}</td>
                    <td class="text-center p-2">{{ t.uid }}</td>
                    <td>{{ t.nama_lengkap }}</td>
                    <td class="text-center p-2">{{ t.nama_grup }}</td>
                    <td class="text-center p-2">Kosong</td>
                    <td class="text-center p-2"><button class="p-2 bg-blue-600 text-white">Primary</button></td>
                </tr>
            </tbody>
        </table>

    </div>

    <!-- Modal Section -->
    <div class="w-full h-full overflow-auto bg-slate-900 left-0 top-0 fixed bg-opacity-70" v-if="openModalAdd == true">
        <!-- Modal Content -->
        <div class="flex justify-center">
            <div class="bg-white w-[1000px] p-4 mt-[200px] rounded-lg">
                <div class="grid grid-rows-1">
                    <h1 class="text-2xl text-black mb-10">Tambah Mahasiswa</h1>
                    <div class="grid grid-rows-1 gap-2 mb-10">
                        <label class="font-bold text-black">Jenis Identitas</label>
                        <select class="border border-slate-500 bg-white p-1" v-model="formMahasiswa.kd_id">
                            <option value="0">-- Pilih data --</option>
                            <option v-for="ids in jenisKartu" :key="ids.kode" :value="ids.kode">{{ ids.nama }}</option>
                        </select>
                        <label class="font-bold text-black">Nomor Identitas</label>
                        <input type="number" class="border border-slate-500 bg-white p-1" v-model="formMahasiswa.uid" />
                        <label class="font-bold text-black">Nama Lengkap</label>
                        <input type="text" class="border border-slate-500 bg-white p-1" v-model="formMahasiswa.nama_lengkap" />
                        <label class="font-bold text-black">Grup / Kelas</label>
                        <select class="border border-slate-500 bg-white p-1" v-model="formMahasiswa.kd_grup">
                            <option value="0">-- Pilih data --</option>
                            <option v-for="idg in listGrup" :key="idg.id" :value="idg.id">{{ idg.nama_grup }}</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <button class="bg-slate-300 text-black p-2 rounded-md" @click="openModalAdd = false">Tutup</button>
                        <button class="bg-blue-600 text-white p-2 rounded-md" @click="simpanDataMahasiswa">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  -->

</div>



</template>

<script>
import axios from 'axios'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'

export default {
    components: {
        vSelect
    },
    mounted() {

        axios.get('/api/super/memberList').then(dat => {
            // console.log(dat.data)
            this.isiTabelMahasiswa =  dat.data.data
            axios.get('/api/super/groupList').then(dat2 => {
                this.listGrup = dat2.data.data
            })
        }).catch(err => {
            alert('Mohon maaf, server sedang mengalami gangguan, mohon untuk menghubungi Web Administrator')
        })
    },
    data() {
        return {
        
            btnTambahMahasiswa  : 'Tambah Data Mahasiswa',
            btnImportData       : 'Import Data Mahasiswa',
            isiTabelMahasiswa   : [],
            openModalAdd        : false,
    
            // Untuk form Tambah mahasiswa
    
            formMahasiswa: {
                kd_id           : 0,
                uid             : '',
                nama_lengkap    : '',
                kd_grup         : 0
            },
            jenisKartu: [
                { kode: 'KTP', nama: 'Kartu Tanda Penduduk'},
                { kode: 'KTM', nama: 'Kartu Tanda Mahasiswa'},
            ],
            listGrup: []
        }
    },
    methods: {
        simpanDataMahasiswa() {
            console.log(this.formMahasiswa)

            const dataTambahMahasiswa = {
                tipe_id : this.formMahasiswa.kd_id,
                no_id   : this.formMahasiswa.uid,
                nama_l  : this.formMahasiswa.nama_lengkap,
                grup    : this.formMahasiswa.kd_grup
            }

            axios.post('/api/super/addNewMember', dataTambahMahasiswa).then(hit => {
                console.log(hit.data.status)
                alert(hit.data.status)
            })
        }
    }
}

</script>