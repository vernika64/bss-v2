<template>

<div class="grid grid-rows-1 ml-2 mr-2">
    <h1 class="text-2xl mb-4">List Bank</h1>
    <div class="flex flex-row gap-2">
        <button class="p-2 text-white bg-black w-auto text-sm" @click="openModalAddBank = true">Tambah Bank Baru</button>
    </div>
    <div>
        <table class="border-collapse mt-4 w-full">
            <thead>
                <tr>
                    <th class="p-4 bg-slate-500 text-slate-100 bold text-left">No.#</th>
                    <th class="p-4 bg-slate-500 text-slate-100 bold text-left">Kode Bank</th>
                    <th class="p-4 bg-slate-500 text-slate-100 bold text-left">Nama Bank</th>
                    <th class="p-4 bg-slate-500 text-slate-100 bold text-left">Alamat Bank</th>
                    <th class="p-4 bg-slate-500 text-slate-100 bold text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(bk, index) in tabelBank" :key="bk.kd_bank">
                   <td class="text-center">{{ index }}</td> 
                   <td>{{ bk.kd_bank }}</td> 
                   <td>{{ bk.nama_bank }}</td> 
                   <td>{{ bk.alamat_bank }}</td> 
                   <td><button class="p-2 bg-blue-600 text-white">Aksi</button></td> 
                </tr>
            </tbody>
        </table>

    </div>

    <!-- Modal Section -->
    <div class="w-full h-full overflow-auto bg-slate-900 left-0 top-0 fixed bg-opacity-70" v-if="openModalAddBank == true">
        <!-- Modal Content -->
        <div class="flex justify-center">
            <div class="bg-white w-[1000px] p-4 mt-[200px] rounded-lg">
                <div class="grid grid-rows-1">
                    <h1 class="text-2xl text-black mb-10">Tambah Bank Baru</h1>
                    <div class="grid grid-rows-1 gap-2 mb-10">
                        <label class="font-bold text-black">Nama Bank</label>
                        <input type="text" class="border border-slate-500 bg-white p-1" v-model="formBankBaru.namabank" />
                        <label class="font-bold text-black">Alamat Bank</label>
                        <input type="text" class="border border-slate-500 bg-white p-1" v-model="formBankBaru.alamatbank" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <button class="bg-slate-300 text-black p-2 rounded-md" @click="openModalAddBank = false">Tutup</button>
                        <button class="bg-blue-600 text-white p-2 rounded-md" @click="tambahBankBaru">Simpan</button>
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

export default {
    mounted() {
        axios.get('/api/super/bankList').then(res => {
            this.tabelBank = res.data.data
            console.log(this.tabelBank)
        }).catch(err => {
            alert('Mohon maaf, server sedang mengalami gangguan, mohon untuk menghubungi Web Administrator')
        })
    },
    data() {
        return {
            openModalAddBank: false,
            tabelBank: [],
            formBankBaru: {
                namabank        : '',
                alamatbank      : ''
            }
        }
    },
    methods: {
        tambahBankBaru() {

            const dataBank = {
                namabank        : this.formBankBaru.namabank,
                alamatbank      : this.formBankBaru.alamatbank
            }
            axios.post('/api/super/addNewBank', dataBank).then(res2 => {
                alert(res2.data.status)
            }).catch(err2 => {
                alert('Mohon maaf, server sedang mengalami gangguan, mohon untuk menghubungi Web Administrator')
            })
        }
    }
}
</script>