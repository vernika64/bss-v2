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
                        <th class="p-4 bold font-md text-left font-semibold">Kode Buku Akuntansi Jurnal</th>
                        <th class="p-4 bold font-md text-left font-semibold">Judul Transaksi</th>
                        <th class="p-4 bold font-md text-left font-semibold">Nominal Debit</th>
                        <th class="p-4 bold font-md text-left font-semibold">Nominal Kredit</th>
                        <th class="p-4 bold font-md text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr v-for="(ju, index) in tabelJurnal" :key="index">
                        <td class="border border-white text-center p-3">{{ index + 1 }}</td>
                        <td class="border border-white p-3">{{ ju.kd_buku_akuntansi }}</td> 
                        <td class="border border-white p-3">{{ ju.deskripsi }}</td> 
                        <td class="border border-white p-3">{{ convertKeRupiah(ju.nominal_debit) }}</td> 
                        <td class="border border-white p-3">{{ convertKeRupiah(ju.nominal_kredit) }}</td> 
                        <td class="border border-white p-3 text-center">
                            <router-link class="p-2 bg-blue-600 text-white rounded-md text-sm" :to="''">
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

        this.kdJurnalUmum = this.$route.query.id

        axios.get('/api/bank/ambilDataJurnalUmum/' + this.$route.query.id).then(res => {
            console.log(res.data)

            this.tabelJurnal = res.data.data
        })
    },
    data() {
        return {
            judulNavbar         : 'Detail Transaksi',
            tabelJurnal         : [],
            kdJurnalUmum        : ''
        }
    },
    methods: {
        convertKeRupiah(id) {
            return 'Rp. ' + new Intl.NumberFormat(['ban', 'id']).format(id) + ',-'
        }
    }
}
</script>