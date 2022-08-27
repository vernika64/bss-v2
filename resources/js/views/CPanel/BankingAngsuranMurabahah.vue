<template>
<div>
    <div class="p-3 bg-white border-t flex flex-row">
        <h1 class="text-2xl italic">{{ judulNavbar }}</h1>
    </div>
    <div class="p-2">
        <div class="flex flex-col">
            <div class="p-2 flex">
                <input class="w-full p-2 border" placeholder="Kode Transaksi Murabahah" v-model="fieldCari" />
                <button class="w-[200px] bg-blue-500 text-white p-2 ml-2" @click="cariAngsuran(fieldCari)">Cari</button>
            </div>
            <div>
                <table class="border border-white w-full">
                    <thead class="bg-slate-500 text-white">
                        <tr>
                            <th class="p-4 bold font-md text-left font-semibold w-[50px]">No.#</th>
                            <th class="p-4 bold font-md text-left font-semibold">No. Kode Transaksi Murabahah</th>
                            <th class="p-4 bold font-md text-left font-semibold">Nama Barang</th>
                            <th class="p-4 bold font-md text-left font-semibold">Status Angsuran</th>
                            <!-- <th class="p-4 bold font-md text-left font-semibold">Frekuensi Pembayaran Angsuran</th> -->
                            <th class="p-4 bold font-md text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <tr class="even:bg-slate-200 even:text-black" v-for="(aa, index) in tabelAngsuran" :key="index">
                            <td class="border border-white text-center p-3">{{ index + 1 }}</td>
                            <td class="border border-white p-3">{{ aa.kd_transaksi_murabahah }}</td>
                            <td class="border border-white p-3">{{ aa.nama_barang }}</td>
                            <td class="border border-white p-3">{{ rubahStatus(aa.status_transaksi) }}</td>
                            <!-- <td class="border border-white p-3">{{ teksFrekuensi(aa.frekuensi_pembayaran_angsuran) }}</td> -->
                            <td class="border border-white p-3 text-center"><button class="p-2 bg-blue-500 text-white" @click="modalAngsuranLama = true">Bayar angsuran</button></td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center mt-4" v-if="btnTambahAngsuranBaru == true">
                    <button class="text-lg bg-blue-500 text-white p-3" @click="modalAngsuranBaru = true">Tambah Angsuran Pertama</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Section -->
    <div class="w-full h-full overflow-auto bg-slate-900 left-0 top-0 fixed bg-opacity-70" v-if="modalAngsuranBaru == true">
        <!-- Modal Content -->
        <div class="flex justify-center">
            <div class="bg-white w-[1000px] p-4 mt-[200px] rounded-lg">
                <div class="grid grid-rows-1">
                    <h1 class="text-2xl text-black mb-10">Bayar Angsuran Pertama</h1>
                    <div class="grid grid-rows-1 gap-2 mb-10">
                        <label class="font-bold text-black">Kode Transaksi Murabahah</label>
                        <input type="text" class="border border-slate-500 bg-white p-1" v-model="formAngsuranPertama.kd_transaksi_murabahah" readonly />
                        <label class="font-bold text-black">Nama Barang</label>
                        <input type="text" class="border border-slate-500 bg-white p-1" v-model="formAngsuranPertama.nama_barang" readonly />
                        <label class="font-bold text-black">Total Biaya Angsuran</label>
                        <input type="text" class="border border-slate-500 bg-white p-1" v-model="dummyFormAngsuranPertama.jumlah_angsuran" readonly />
                        <label class="font-bold text-black">Biaya Angsuran Pertama</label>
                        <input type="text" class="border border-slate-500 bg-white p-1" v-model="dummyFormAngsuranPertama.angsuran_perbulan" readonly />
                        <!-- <button class="bg-slate-200 text-black p-2 mt-4 border border-slate-700">Cetak Lembar Angsuran</button> -->
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <button class="bg-slate-300 text-black p-2 rounded-md" @click="modalAngsuranBaru = false">Batal</button>
                        <button class="bg-blue-600 text-white p-2 rounded-md" @click="simpanAngsuranPertama">Bayar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  -->

    <!-- Modal Section -->
    <div class="w-full h-full overflow-auto bg-slate-900 left-0 top-0 fixed bg-opacity-70" v-if="modalAngsuranLama == true">
        <!-- Modal Content -->
        <div class="flex justify-center">
            <div class="bg-white w-[1000px] p-4 mt-[200px] rounded-lg">
                <div class="grid grid-rows-1">
                    <h1 class="text-2xl text-black mb-10">Bayar Angsuran</h1>
                    <div class="grid grid-rows-1 gap-2 mb-10">
                        <label class="font-bold text-black">History Angsuran</label>
                        <div class="mb-4">
                            <table class="border border-white w-full">
                                <thead class="bg-slate-500 text-white">
                                    <tr>
                                        <th class="p-2 bold font-md text-left font-semibold w-[50px]">#</th>
                                        <th class="p-2 bold font-md text-left font-semibold">Tgl Transaksi</th>
                                        <th class="p-2 bold font-md text-left font-semibold">Nominal Bayar</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    <tr v-for="(bb, index) in tabelHistoriAngsuran" class="even:bg-slate-200 even:text-black" :key="index">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ bb.tgl_bayar_angsuran }}</td>
                                        <td>{{ konversiKeRp(bb.nominal_bayar) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <label class="font-bold text-black">Kode Transaksi Murabahah</label>
                        <input type="text" class="border border-slate-500 bg-white p-1" v-model="formAngsuranLama.kd_transaksi_murabahah" readonly />
                        <label class="font-bold text-black">Nama Barang</label>
                        <input type="text" class="border border-slate-500 bg-white p-1" v-model="formAngsuranLama.nama_barang" readonly />
                        <label class="font-bold text-black">Total Biaya Angsuran</label>
                        <input type="text" class="border border-slate-500 bg-white p-1" v-model="dummyFormAngsuranLama.jumlah_angsuran" readonly />
                        <label class="font-bold text-black">Biaya Angsuran</label>
                        <input type="text" class="border border-slate-500 bg-white p-1" v-model="dummyFormAngsuranLama.angsuran_perbulan" readonly />
                        <!-- <button class="bg-slate-200 text-black p-2 mt-4 border border-slate-700">Cetak Lembar Angsuran</button> -->
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <button class="bg-slate-300 text-black p-2 rounded-md" @click="modalAngsuranLama = false">Batal</button>
                        <button class="bg-blue-600 text-white p-2 rounded-md" @click="simpanAngsuranLama">Bayar</button>
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
    data() {
        return {
            judulNavbar         : 'Bayar Angsuran Jual Beli Murabahah',
            fieldCari           : '',
            tabelAngsuran       : [
                // {
                //     kd_transaksi_murabahah              : '2020',
                //     nama_barang                         : 'ASUS RTX 3060',
                //     status_transaksi                    : 'active',
                //     frekuensi_pembayaran_angsuran       : '1'
                // },
                // {
                //     kd_transaksi_murabahah              : '2021',
                //     nama_barang                         : 'GIGABYTE Z690 AORUS ELITE',
                //     status_transaksi                    : 'pass',
                //     frekuensi_pembayaran_angsuran       : '1'
                // },
            ],
            tabelHistoriAngsuran : [],
            formAngsuranPertama     : {
                kd_transaksi_murabahah          : '',
                nama_barang                     : '',
                jumlah_angsuran                 : '',
                frekuensi_angsuran              : '',
                angsuran_perbulan               : '',
                angsuran_pertama                : true
            },
            formAngsuranLama        : {
                kd_transaksi_murabahah          : '',
                nama_barang                     : '',
                jumlah_angsuran                 : '',
                frekuensi_angsuran              : '',
                angsuran_perbulan               : '',
                angsuran_pertama                : false
            },
            dummyFormAngsuranPertama    : {
                jumlah_angsuran     : '',
                angsuran_perbulan   : ''
            },
            dummyFormAngsuranLama       : {
                jumlah_angsuran     : '',
                angsuran_perbulan   : ''
            },
            btnTambahAngsuranBaru   : false,
            modalAngsuranBaru       : false,
            modalAngsuranLama       : false,

        }
    },
    methods: {
        teksFrekuensi(fre) {
            return fre + ' Kali'
        },
        cariAngsuran(kode) {
            if(this.fieldCari == '')
            {
                return alert('Mohon diisi field pencarian sebelum mencari data')
            }

            this.formAngsuranPertama.kd_transaksi_murabahah     = ''
            this.formAngsuranPertama.nama_barang                = ''
            this.formAngsuranPertama.jumlah_angsuran            = ''
            this.formAngsuranPertama.frekuensi_angsuran         = ''
            this.formAngsuranPertama.angsuran_perbulan          = ''

            this.formAngsuranLama.kd_transaksi_murabahah        = ''
            this.formAngsuranLama.nama_barang                   = ''
            this.formAngsuranLama.jumlah_angsuran               = ''
            this.formAngsuranLama.frekuensi_angsuran            = ''
            this.formAngsuranLama.angsuran_perbulan             = ''

            this.tabelAngsuran = []

            axios.get('/api/bank/cariAngsuranMurabahah/' + kode).then(ags => {
                // console.log(ags)

                if(ags.data.status == 'error')
                {
                    alert(ags.data.message)
                } else if(ags.data.status == 'true')
                {
                    alert('Transaksi sudah diverifikasi, silahkan membuat angsuran baru')
                    
                    this.formAngsuranPertama.kd_transaksi_murabahah = ags.data.data.kd_transaksi_murabahah
                    this.formAngsuranPertama.nama_barang            = ags.data.data.nama_barang
                    this.formAngsuranPertama.jumlah_angsuran        = parseInt(ags.data.data.jumlah_angsuran)
                    this.formAngsuranPertama.frekuensi_angsuran     = ags.data.data.frekuensi_angsuran
                    this.formAngsuranPertama.angsuran_perbulan      = parseInt(ags.data.data.angsuran_perbulan)

                    this.dummyFormAngsuranPertama.jumlah_angsuran   = 'Rp. ' + new Intl.NumberFormat(['ban', 'id']).format(ags.data.data.jumlah_angsuran) + ',-'
                    this.dummyFormAngsuranPertama.angsuran_perbulan = 'Rp. ' + new Intl.NumberFormat(['ban', 'id']).format(ags.data.data.angsuran_perbulan) + ',-'

                    this.btnTambahAngsuranBaru = true
                    console.log(this.btnTambahAngsuranBaru)
                } else if(ags.data.status == 'false')
                {
                    console.log(ags)

                    axios.get('/api/bank/historiDataAngsuran/' + kode).then(hst => {
                        // console.log(hst.data)
                        this.tabelHistoriAngsuran = hst.data.data
                    }).catch(hsterr => {
                        console.log(hsterr)
                    })
                    let untukForm = ags.data.data2

                    this.tabelAngsuran = ags.data.data1

                    this.formAngsuranLama.kd_transaksi_murabahah     = untukForm.kd_transaksi_murabahah
                    this.formAngsuranLama.nama_barang                = untukForm.nama_barang
                    this.formAngsuranLama.jumlah_angsuran            = untukForm.jumlah_angsuran
                    this.formAngsuranLama.frekuensi_angsuran         = untukForm.frekuensi_angsuran
                    this.formAngsuranLama.angsuran_perbulan          = untukForm.angsuran_perbulan

                    this.dummyFormAngsuranLama.jumlah_angsuran       = 'Rp. ' + new Intl.NumberFormat(['ban', 'id']).format(untukForm.jumlah_angsuran) + ',-'
                    this.dummyFormAngsuranLama.angsuran_perbulan     = 'Rp. ' + new Intl.NumberFormat(['ban', 'id']).format(untukForm.angsuran_perbulan) + ',-'

                    console.log(this.formAngsuranLama)

                } else {
                    alert('Server error')
                    console.log(ags)
                }
            }).catch(ags_error => {
                console.log(ags_error)
            })
        },
        konversiKeRp(number)
        {
            return 'Rp. ' + new Intl.NumberFormat(['ban', 'id']).format(number) + ',-'
        },
        simpanAngsuranPertama()
        {
            let konfirmasi = confirm('Apakah anda yakin ?')

            if(konfirmasi == true)
            {
                axios.post('/api/bank/tambahAngsuranMurabahah', this.formAngsuranPertama).then(proses1 => {
                    console.log(proses1)

                    let data = proses1.data
                    alert(data.message)
                }).catch(proses1_error => {
                    console.log(proses1_error)
                })
            } else if(konfirmasi == false) {
                // No Action
            }
        },
        simpanAngsuranLama()
        {
            let konfirmasi = confirm('Apakah anda yakin ?')

            if(konfirmasi == true)
            {
                axios.post('/api/bank/tambahAngsuranMurabahah', this.formAngsuranLama).then(proses2 => {
                    console.log(proses2)

                    let data = proses2.data
                    alert(data.message)
                    return location.reload()
                }).catch(proses2_error => {
                    console.log(proses2_error)
                })
            } else if(konfirmasi == false) {
                // No Action
            }
        },
        rubahStatus(stat)
        {
            switch (stat) {
                case 'active':
                    return 'Belum Lunas'
                    break;
                case 'pass':
                    return 'Sudah Lunas'
                    break;
                default:
                    break;
            }
        }
    }
}
</script>