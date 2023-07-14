<template>
<div class="grid grid-rows-1">
    <div class="p-3 bg-white border-t border-b flex">
        <h1 class="text-2xl italic mr-2">{{ detailBank.nama_bank }}</h1>
        <div>
            <button class="bg-blue-800 text-white p-2" @click="cekDataBukuAkuntansi">
                Perbarui Buku Akuntansi
            </button>
        </div>
    </div>
    <div class="p-4 grid grid-cols-2 gap-3">
        <div class="flex flex-col gap-2 border-slate-500 bg-white rounded-lg p-4">
            <div>
                <p class="text-xl italic">Informasi Dasar Bank</p>
            </div>
            <div>
                <table class="w-full">
                    <tbody class="border border-slate-500">
                        <tr>
                            <td class="p-2 w-[200px] border border-slate-600 bg-slate-500 text-white">Nama Bank</td>
                            <td class="p-2 border border-slate-600">{{ detailBank.nama_bank }}</td>
                        </tr>
                        <tr>
                            <td class="p-2 border border-slate-600 bg-slate-500 text-white">Alamat Bank</td>
                            <td class="p-2 border border-slate-600">{{ detailBank.alamat_bank }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div>
                <p class="text-xl italic">Daftar karyawan</p>
            </div>
            <div>
                <table class="border-collapse w-full">
                    <thead class="bg-slate-500 text-white border border-slate-500">
                        <tr>
                            <th class="p-2 2xl:text-md">#</th>
                            <th class="p-2 2xl:text-md">Nama Karyawan</th>
                            <th class="p-2 2xl:text-md">Jabatan</th>
                        </tr>
                    </thead>
                    <tbody v-if="statusKaryawan == true" class="border border-slate-500">
                        <tr v-for="(kr, index) in karyawanBank" :key="index">
                            <td class="p-2 text-center">{{ index + 1 }}</td>
                            <td class="p-2 text-center">{{ kr.username }}</td>
                            <td class="p-2 text-center">{{ kr.nama_role }}</td>
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
        <div class="grid">
            <div class="flex flex-col gap-2 p-4">
                <div>
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

    <!-- Modal Update Buku Akuntansi -->

    <Transition name="slide-fade">
        <div class="flex flex-col w-full h-full bg-slate-900 left-0 top-0 fixed bg-opacity-70 justify-center align-middle" v-if="maintainDataBukuAkuntansi.modalUpdateBukuAkuntansi == true">
            <div class="relative bg-white rounded-lg shadow p-4 m-auto md:w-1/2 2xl:w-1/2">
                <div class="grid grid-rows-1">
                    <h1 class="text-xl text-black mb-5">Update Akun Buku Besar</h1>
                    <div class="grid grid-rows-1 gap-2 mb-10">
                        <p class="font-bold text-lg">Daftar Buku yang tidak tersedia di bank</p>
                        <table class="border-collapse w-full">
                            <thead class="bg-slate-500 text-white">
                                <tr>
                                    <th class="p-2 2xl:text-md">#</th>
                                    <th class="p-2 2xl:text-md">Kode Buku Akuntansi</th>
                                    <th class="p-2 2xl:text-md">Nama Buku Akuntansi</th>
                                </tr>
                            </thead>
                            <tbody class="border border-slate-500" v-for="(mda, index) in maintainDataBukuAkuntansi.dataBukuKosong" :key="index">
                                <tr>
                                    <td class="p-2 text-left text-md border border-slate-500">{{ index + 1 }}</td>
                                    <td class="p-2 text-left text-md border border-slate-500">{{ mda.kd_buku }}</td>
                                    <td class="p-2 text-left text-md border border-slate-500">{{ mda.nama_buku }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <button class="bg-slate-300 text-black p-2 rounded-md" @click="tutupModalUpdateBukuAkuntansi">Tutup</button>
                        <button class="bg-blue-600 text-white p-2 rounded-md" @click="updateBukuAkuntansi">Simpan</button>
                    </div>
                </div>  
            </div>
        </div>
    </Transition>

    <!--  -->

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
            // console.log(res2.data.status)
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
        },
        cekDataBukuAkuntansi() {
            let kode_bank   = this.$route.params.bankID

            axios.get('/api/super/cekDataJurnal/'+ kode_bank).then(hslcek => {
                console.log(hslcek.data)

                if(hslcek.data.status_isi_buku == true) {
                    return alert('Data Buku Akuntansi sudah lengkap')
                } else if(hslcek.data.status_isi_buku == false) {
                    alert('Data Buku Akuntansi tidak lengkap')

                    this.maintainDataBukuAkuntansi.dataBukuKosong   = hslcek.data.data_jurnal_kosong
                    this.maintainDataBukuAkuntansi.totalBukuKosong  = hslcek.data.count_jurnal_kosong

                    return this.maintainDataBukuAkuntansi.modalUpdateBukuAkuntansi = true

                }
            }).catch(cekerr => {
                console.log(cekerr)
            })
        },
        tutupModalUpdateBukuAkuntansi() {
            this.maintainDataBukuAkuntansi.dataBukuKosong       = []
            this.maintainDataBukuAkuntansi.totalBukuKosong      = 0
            
            this.maintainDataBukuAkuntansi.modalUpdateBukuAkuntansi = false

            return console.log(this.maintainDataBukuAkuntansi)
        },
        updateBukuAkuntansi() {

            let as = confirm('Apakah anda yakin untuk memperbarui buku akuntansi ?')

            if(as == false) {

            } else if(as == true) {
                let uploaddata = {
                    ids             : this.maintainDataBukuAkuntansi.dataBukuKosong,
                    kd_bank         : this.$route.params.bankID
                }
    
                axios.post('/api/super/updateDataJurnal',uploaddata).then(hslupd => {
                    console.log(hslupd.data)
                    alert(hslupd.data.message)
                    location.reload()
                }).catch(hslupderr => {
                    console.log(hslupderr)
                    return alert('Server Error!')
                })
            }
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
            statusKaryawan  : false,

            maintainDataBukuAkuntansi   : {
                dataBukuKosong              : [],
                totalBukuKosong             : 0,
                modalUpdateBukuAkuntansi    : false
            }
        }
    }
}
</script>