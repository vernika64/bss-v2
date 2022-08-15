<template>
<div class="grid grid-rows-1">
    <div class="p-3 bg-white border-t border-b">
        <h1 class="text-2xl italic">{{ detailBank.nama_bank }}</h1>
    </div>
    <div class="p-4 grid grid-cols-2 gap-3">
        <div class="grid gap-2 border-slate-500 bg-white rounded-lg p-4">
            <div class="mb-4">
                <p class="text-xl italic">Informasi Dasar Bank</p>
            </div>
            <div>
                <label class="text-lg font-bold">Nama Bank</label>
                <p class="text-md">{{ detailBank.nama_bank }}</p>
            </div>
            <div>
                <label class="text-lg font-bold">Alamat Bank</label>
                <p class="text-md">{{ detailBank.alamat_bank }}</p>
            </div>
            <div>
                <label class="text-lg font-bold">Jumlah Aset</label>
                <p class="text-md">{{ convertKeRupiah(keuanganBank.aset) }}</p>
            </div>
            <div>
                <label class="text-lg font-bold">Jumlah Kewajiban</label>
                <p class="text-md">{{ convertKeRupiah(keuanganBank.kewajiban) }}</p>
            </div>
            <div>
                <label class="text-lg font-bold">Jumlah Ekuitas</label>
                <p class="text-md">{{ convertKeRupiah(keuanganBank.ekuitas) }}</p>
            </div>
        </div>
        <div class="flex flex-col gap-4 bg-white rounded-lg p-4">
            <div class="mb-4">
                <p class="text-xl italic">Daftar karyawan</p>
            </div>
            <div>
                <table class="border-collapse w-full">
                    <thead class="bg-slate-500 text-white">
                        <tr>
                            <th class="p-2 2xl:text-md">#</th>
                            <th class="p-2 2xl:text-md">Nama Karyawan</th>
                            <th class="p-2 2xl:text-md">Jabatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(kr, index) in karyawanBank" :key="index">
                            <td class="p-2 text-center 2xl:text-lg">{{ index + 1 }}</td>
                            <td class="p-2 text-center 2xl:text-lg">{{ kr.username }}</td>
                            <td class="p-2 text-center 2xl:text-lg">{{ kr.nama_role }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import axios from 'axios'

export default {
    mounted() {
        const bankingId = this.$route.params.bankID

        axios.get('/api/super/bankList/'+ bankingId).then(res => {
            this.detailBank = res.data.data
            console.log(this.detailBank)
        }).catch(err => {
            console.log(err)
        })

        axios.get('/api/super/memberListFilterBank/'+ bankingId).then(res2 => {
            this.karyawanBank = res2.data.data
            console.log(this.karyawanBank)
        }).catch(err2 => {
            console.log(err2)
        })
    },
    methods: {
        convertKeRupiah(no) {
            return 'Rp. ' + new Intl.NumberFormat(['ban', 'id']).format(no) + ',-'
        }
    },
    data(){
        return {
            // judulDetail     : 'User',
            detailBank      : [],
            karyawanBank    : [],
            keuanganBank    : {
                aset            : 0,
                kewajiban       : 0,
                ekuitas         : 0,
                jumlahTransaksi : 0
            }
        }
    }
}
</script>