<template>
<div class="flex flex-row m-4 p-4 bg-slate-700 h-1/4 text-white items-center">
    <h1 class="text-2xl">Selamat Datang di Simulasi Bank Syariah</h1>
</div>
<div class="ml-4 pl-4">
    <h1 class="text-2xl">Statistik Resource Bank</h1>
</div>
<div class="m-4 p-4 grid lg:grid-cols-4 gap-2">
    <div class="border border-slate-200 bg-blue-600 text-white shadow-lg text-center p-4 rounded-lg">
        <h2>Total Nasabah terdaftar</h2>
        <p class="text-3xl p-4">{{ totalNasabah }}</p>
    </div>
    <div class="border border-slate-200 bg-blue-700 text-white shadow-lg text-center p-4 rounded-lg">
        <h2>Total Saldo Tabungan Wadiah</h2>
        <p class="text-2xl p-4">{{ konversiKeRp(totalTabungan) }}</p>
    </div>
    <div class="border border-slate-200 bg-blue-800 text-white shadow-lg text-center p-4 rounded-lg">
        <h2>Jumlah transaksi Jual Beli Murabahah</h2>
        <p class="text-2xl p-4">{{ konversiKeRp(totalTabungan) }}</p>
    </div>
</div>
</template>

<script>
import axios from 'axios'

export default {
    mounted() {
        // Ambil data banyak cif
        axios.get('/api/banyakCIF').then(out => {
            console.log(out.data)
            this.totalNasabah = out.data.count
        }).catch(err => {
            console.log(err)
        })

        axios.get('/api/bank/totalTabunganBank').then(hsl => {
            // console.log(hsl.data)
            let nominal         = hsl.data.nominal

            // this.totalTabungan = new Intl.NumberFormat(['ban', 'id']).format(nominal) + ',='
            this.totalTabungan = hsl.data.nominal
        })
    },
    data() {
        return {
            totalNasabah        : 0,
            totalTabungan       : 20000000
        }
    },
    methods: {
        konversiKeRp(number)
        {
            return 'Rp. ' + new Intl.NumberFormat(['ban', 'id']).format(number) + ',-'
        }
    }
}
</script>