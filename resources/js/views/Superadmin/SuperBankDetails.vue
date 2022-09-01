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
        <div class="grid">
            <div class="flex flex-col gap-4 p-4">
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
                        <tbody v-if="statusKaryawan == true">
                            <tr v-for="(kr, index) in karyawanBank" :key="index">
                                <td class="p-2 text-center 2xl:text-lg">{{ index + 1 }}</td>
                                <td class="p-2 text-center 2xl:text-lg">{{ kr.username }}</td>
                                <td class="p-2 text-center 2xl:text-lg">{{ kr.nama_role }}</td>
                            </tr>
                        </tbody>
                        <tbody v-else-if="statusKaryawan == false" class="border border-slate-500">
                            <tr>
                                <td class="p-2 text-center 2xl:text-lg" colspan="3">Bank tidak mempunyai karyawan</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex flex-col gap-4 p-4">
                <div class="mb-4">
                    <p class="text-xl italic">Status Neraca</p>
                </div>
                <div>
                    <table class="border-collapse w-full">
                        <thead class="bg-slate-500 text-white">
                            <tr>
                                <th class="p-2 2xl:text-md">Aktiva</th>
                                <th class="p-2 2xl:text-md">Pasiva</th>
                            </tr>
                        </thead>
                        <tbody class="border border-slate-500">
                            <tr>
                                <td class="p-2 text-left text-md border border-slate-500">
                                    <div v-for="(aktv, index) in tabelAktiva" :key="index">
                                        <label class="font-semibold">{{ aktv.kode_sub_buku_akuntansi }} - {{ aktv.nama_akun }}</label>
                                        <p class="p-2 mb-1">{{ convertKeRupiah(aktv.nominal_akun) }}</p>
                                    </div>
                                </td>
                                <td class="p-2 text-left text-md border border-slate-500">
                                    <div v-for="(pasv, index) in tabelPasiva" :key="index">
                                        <label class="font-semibold">{{ pasv.kode_sub_buku_akuntansi }} - {{ pasv.nama_akun }}</label>
                                        <p class="p-2 mb-1">{{ convertKeRupiah(pasv.nominal_akun) }}</p>
                                    </div>
                                </td>
                            </tr>
                            <tr class="bg-slate-500 text-white border-b border-white">
                                <td class="font-bold p-2">Total Aktiva</td>
                                <td class="font-bold p-2">Total Pasiva</td>
                            </tr>
                            <tr class="bg-slate-500 text-white">
                                <td class="font-bold p-2">{{ convertKeRupiah(totalAktiva) }}</td>
                                <td class="font-bold p-2">{{ convertKeRupiah(totalPasiva) }}</td>
                            </tr>
                            <tr class="bg-slate-500 text-white">
                                <td class="p-2 font-bold italic" colspan="2"> 
                                    Status Keseimbangan Neraca : {{ statusNeraca }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
            // console.log(this.detailBank)
        }).catch(err => {
            console.log(err)
        })

        axios.get('/api/super/memberListFilterBank/'+ bankingId).then(res2 => {
            console.log(res2.data.status)
            if(res2.data.status == true)
            {
                this.karyawanBank       = res2.data.data
                this.statusKaryawan     = res2.data.status
            }
            // console.log(this.karyawanBank)
        }).catch(err2 => {
            console.log(err2)
        })

        axios.get('/api/super/neraca/'+ bankingId).then(res3 => {
            // console.log(res3)

            this.tabelAktiva    = res3.data.aktiva
            this.tabelPasiva    = res3.data.pasiva

            this.totalAktiva    = res3.data.total_aktiva
            this.totalPasiva    = res3.data.total_pasiva

            this.statusNeraca   = res3.data.status_neraca

            // console.log(this.totalAktiva)
            // console.log(this.totalPasiva)
            // console.log(this.tabelPasiva)
        }).catch(err3 => {
            console.log(err3)
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
            },
            tabelAktiva     : [],
            tabelPasiva     : [],
            totalAktiva     : 0,
            totalPasiva     : 0,
            statusNeraca    : '',
            statusKaryawan  : false
        }
    }
}
</script>