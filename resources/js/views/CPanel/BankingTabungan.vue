<template>
    <div>
        <div class="p-3 bg-white border-t flex flex-row">
            <h1 class="text-2xl italic">{{ judulNavbar }}</h1>
            <button class="p-2 text-white bg-blue-600 w-auto text-sm ml-4" @click="openModalAddTabungan = true">Tambah Tabungan baru</button>
        </div>
        <div class="p-2">
            <div>
                <table class="border border-white w-full">
                    <thead class="bg-slate-500 text-white">
                        <tr>
                            <th class="p-4 bold font-md text-left font-semibold w-[50px]">#</th>
                            <th class="p-4 bold font-md text-left font-semibold">Nomor Tabungan</th>
                            <th class="p-4 bold font-md text-left font-semibold">Produk Tabungan</th>
                            <th class="p-4 bold font-md text-left font-semibold">Nama Nasabah</th>
                            <th class="p-4 bold font-md text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <tr v-for="(tb, index) in tabelTabungan" :key="index" class="even:bg-slate-200 even:text-black">
                            <td class="border border-white text-center p-3">{{ index + 1 }}</td>
                            <td class="border border-white p-3">{{ tb.kd_buku_tabungan }}</td>
                            <td class="border border-white p-3">{{ tb.nama_produk }}</td>
                            <td class="border border-white p-3">{{ tb.nama_sesuai_identitas }}</td>
                            <td class="border border-white p-3 text-center"><router-link :to="''" class="bg-blue-500 text-white p-2">Details</router-link></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Section -->
    <div class="w-full h-full overflow-auto bg-slate-900 left-0 top-0 fixed bg-opacity-70" v-if="openModalAddTabungan == true">
        <!-- Modal Content -->
        <div class="flex justify-center">
            <div class="bg-white w-[1000px] p-4 mt-[200px] rounded-lg">
                <div class="grid grid-rows-1">
                    <h1 class="text-2xl text-black mb-10">Tambah Tabungan Baru</h1>
                    <div class="grid grid-rows-1 gap-2 mb-10">
                        <label class="font-bold text-black">Target Nasabah</label>
                            <select class="border bg-white p-2" v-model="formTabunganBaru.kd_cif">
                                <option :value="''">-- Pilih Data --</option>
                                <option v-for="(nsb, index) in listNasabah" :key="index" :value="nsb.id">{{ nsb.kd_identitas }} - {{ nsb.nama_sesuai_identitas }}</option>
                            </select>
                        <label class="font-bold text-black">Produk Tabungan</label>
                            <select class="border bg-white p-2" v-model="formTabunganBaru.kd_produk_tabungan">
                                <option :value="''">-- Pilih Data --</option>
                                <option v-for="(tab, index) in listProdukTabungan" :key="index" :value="tab.id">{{ tab.nama_produk }}</option>
                            </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <button class="bg-slate-300 text-black p-2 rounded-md" @click="openModalAddTabungan = false">Tutup</button>
                        <button class="bg-blue-600 text-white p-2 rounded-md" @click="tambahTabungan">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  -->

</template>

<script>
import axios from 'axios'

export default {
    mounted()
    {
        axios.get('/api/bank/listCIFAll').then(res => {
            this.listNasabah = res.data.data
            // console.log(this.listNasabah)
        }).catch(err1 => {
            console.log(err1)
        })

        axios.get('/api/bank/listTabunganTabel').then(res2 => {
            this.tabelTabungan = res2.data.data
            console.log(this.tabelTabungan)
        }).catch(err2 => {
            console.log(err2)
        })

        axios.get('/api/bank/listProdukTabungan').then(res3 => {
            this.listProdukTabungan = res3.data.data
            // console.log(this.listProdukTabungan)
        })
    },
    data() {
        return {
            openModalAddTabungan    : false,
            listProdukTabungan      : [],
            listNasabah             : [],
            judulNavbar             : 'Tabungan Wadiah',
            formTabunganBaru        : {
                kd_produk_tabungan  : '',
                kd_cif              : ''
            },
            tabelTabungan           : []
        }
    },
    methods: {
        tambahTabungan() {
            axios.post('/api/bank/listTabungan/Add', this.formTabunganBaru).then(nxt => {
                console.log(nxt.data)
                alert(nxt.data.message)
                return location.reload()
            }).catch(err_nxt => {
                console.log(err_nxt.data)
            })
        }
    }
}
</script>