<template>

<div>
    <div class="p-3 bg-white flex flex-row">
        <h1 class="text-2xl italic">List Bank</h1>
        <button class="p-2 text-white bg-blue-600 w-auto text-sm ml-4" @click="openModalAddBank = true">Tambah Bank Baru</button>
    </div>
    <div class="p-2">
        <div>
            <table class="border border-white w-full">
                <thead class="bg-slate-500 text-white">
                    <tr>
                        <th class="p-4 bold font-md text-left font-semibold w-[50px]">No.#</th>
                        <th class="p-4 bold font-md text-left font-semibold">Kode Bank</th>
                        <th class="p-4 bold font-md text-left font-semibold">Nama Bank</th>
                        <th class="p-4 bold font-md text-left font-semibold">Alamat Bank</th>
                        <th class="p-4 bold font-md text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr v-for="(bk, index) in tabelBank" :key="bk.kd_bank" class="even:bg-slate-200 even:text-black">
                        <td class="border border-white text-center p-3">{{ index + 1 }}</td> 
                        <td class="border border-white p-3">{{ bk.kd_bank }}</td> 
                        <td class="border border-white p-3">{{ bk.nama_bank }}</td> 
                        <td class="border border-white p-3">{{ bk.alamat_bank }}</td> 
                        <td class="border border-white p-3 text-center">
                            <router-link class="p-2 bg-blue-600 text-white rounded-md text-sm" :to="{ name: 'SuperBankDetail', params: { bankID: bk.kd_bank }}">
                                Details
                            </router-link>
                        </td> 
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    

</div>

<!-- Modal Section -->


    <!-- Modal Content -->
    <Transition name="slide-fade">

        <div class="flex flex-col w-full h-full bg-slate-900 left-0 top-0 fixed bg-opacity-70 justify-center align-middle" v-if="openModalAddBank == true">
            
                <div class="relative bg-white rounded-lg shadow p-4 m-auto w-[1000px]">
                    
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

    </Transition>
    <!-- End Modal Content -->
    
<!-- End Modal Selection -->

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

            let dataBank = {
                namabank        : this.formBankBaru.namabank,
                alamatbank      : this.formBankBaru.alamatbank
            }

            axios.post('/api/super/addNewBank', dataBank).then(res2 => {
                alert(res2.data.message)
                console.log(res2)
                location.reload()
            }).catch(err2 => {
                alert(err2.data.message)
            })
        }
    }
}
</script>