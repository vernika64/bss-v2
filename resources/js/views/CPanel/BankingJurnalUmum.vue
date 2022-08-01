<template>
<div>
    <div class="p-3 bg-white border-t flex flex-row">
        <h1 class="text-2xl italic">{{ judulNavbar }}</h1>
        <!-- <button class="p-2 text-white bg-blue-600 w-auto text-sm ml-4" @click="openModalAddBank = true">Tambah Transaksi Baru</button> -->
    </div>
    <div class="p-2">
        <div>
            <table class="border border-white w-full">
                <thead class="bg-slate-500 text-white">
                    <tr>
                        <th class="p-4 bold font-md text-left font-semibold w-[50px]">No.#</th>
                        <th class="p-4 bold font-md text-left font-semibold">Kode Transaksi Jurnal</th>
                        <th class="p-4 bold font-md text-left font-semibold">Judul Transaksi</th>
                        <th class="p-4 bold font-md text-left font-semibold">Nominal Transaksi</th>
                        <th class="p-4 bold font-md text-left font-semibold">Tgl Transaksi</th>
                        <th class="p-4 bold font-md text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr v-for="(ju, index) in tabelJurnal" :key="index">
                        <td class="border border-white text-center p-3">{{ index + 1 }}</td>
                        <td class="border border-white p-3">{{ ju.kd_transaksi_akuntansi }}</td> 
                        <td class="border border-white p-3">{{ ju.nama_transaksi }}</td> 
                        <td class="border border-white p-3">{{ convertKeRupiah(ju.nominal_transaksi) }}</td> 
                        <td class="border border-white p-3">{{ ju.tgl_pencatatan_jurnal }}</td> 
                        <td class="border border-white p-3 text-center">
                            <router-link class="p-2 bg-blue-600 text-white rounded-md text-sm" :to="{ name: 'DaftarJurnalUmumDetail', query: { id: ju.kd_transaksi_akuntansi }}">
                                Details
                            </router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</template>

<script>
import axios from 'axios'
export default {
    mounted() {
        axios.get('/api/bank/ambilDataJurnalUmum').then(res => {
            console.log(res.data)

            this.tabelJurnal = res.data.data
        })
    },
    data() {
        return {
            judulNavbar         : 'Jurnal Umum',
            tabelJurnal         : []
        }
    },
    methods: {
        convertKeRupiah(id) {
            return 'Rp. ' + new Intl.NumberFormat(['ban', 'id']).format(id) + ',-'
        }
    }
}
</script>