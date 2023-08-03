<template>
<div>
    <div class="p-3 bg-white border-b flex flex-row shadow-md mb-2">
        <h1 class="text-2xl italic">{{ judulNavbar }}</h1>
    </div>
    <div class="p-2">
        <div>
            <table class="border border-white w-full shadow-md">
                <thead class="bg-slate-500 text-white">
                    <tr>
                        <th class="p-4 bold font-md text-left font-semibold w-[50px]">No.#</th>
                        <th class="p-4 bold font-md text-left font-semibold">No. Kode Transaksi Murabahah</th>
                        <th class="p-4 bold font-md text-left font-semibold">Nama Barang</th>
                        <th class="p-4 bold font-md text-left font-semibold">Status Barang di Gudang</th>
                        <th class="p-4 bold font-md text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr class="even:bg-slate-200 even:text-black" v-for="(tp, index) in tabelPermintaan" :key="index">
                        <td class="border border-white text-center p-3">{{ index + 1 }}</td>
                        <td class="border border-white p-3">{{ tp.kd_transaksi_murabahah }}</td>
                        <td class="border border-white p-3">{{ tp.nama_barang }}</td>
                        <td class="border border-white p-3">{{ displayStatusBarang(tp.status_barang) }}</td>
                        <td class="border border-white p-3 text-center">
                            <button v-if="tp.status_barang == 'pending'" class="p-2 bg-blue-500 text-white" @click="openModalRetrive(tp.id, tp.kd_transaksi_murabahah, tp.nama_barang)">Terima Barang</button>
                            <button v-else-if="tp.status_barang == 'receive'" class="p-2 bg-red-500 text-white" @click="keluarkanBarang(tp.id)">Barang Keluar</button>
                            <button v-else class="p-2 bg-green-500 text-white">Barang Diterima Nasabah</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Section -->
    <div class="w-full h-full overflow-auto bg-slate-900 left-0 top-0 fixed bg-opacity-70" v-if="openModalRetriveItems == true">
        <!-- Modal Content -->
        <div class="flex justify-center">
            <div class="bg-white w-[1000px] p-4 mt-[200px] rounded-lg">
                <div class="grid grid-rows-1">
                    <h1 class="text-2xl text-black mb-10">Terima Barang</h1>
                    <div class="grid grid-rows-1 gap-2 mb-10">
                        <label class="font-bold text-black">Kode Transaksi Murabahah</label>
                        <input class="border border-slate-500 bg-white p-1" v-model="formPermintaanBarang.kd_transaksi_murabahah" readonly />
                        <label class="font-bold text-black">Nama Barang</label>
                        <input class="border border-slate-500 bg-white p-1" v-model="formLabelBarang.nama_barang" readonly />
                        <label class="font-bold text-black">Kode Invoice barang yang dibeli</label>
                        <input type="text" class="border border-slate-500 bg-white p-1" v-model="formPermintaanBarang.kd_invoice_barang" />
                        <label class="font-bold text-black">Keterangan</label>
                        <textarea type="text" class="border border-slate-500 bg-white p-1 overflow-auto" v-model="formPermintaanBarang.keterangan"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <button class="bg-slate-300 text-black p-2 rounded-md" @click="closeModalRetrive">Tutup</button>
                        <button class="bg-blue-600 text-white p-2 rounded-md" @click="savePermintaan">Simpan</button>
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
        axios.get('/api/bank/listPermintaanBarang').then(hsl => {
            console.log(hsl.data)

            this.tabelPermintaan = hsl.data.data
        }).catch(err => {
            console.log(err)
        })
    },
    data() {
        return {
            judulNavbar             : 'Permintaan Barang untuk Jual Beli akad Murabahah',
            tabelPermintaan         : [],
            openModalRetriveItems   : false,

            formPermintaanBarang    : {
                kd_permintaan_barang    : '',
                kd_transaksi_murabahah  : '',
                kd_invoice_barang       : '',
                keterangan              : ''
            },

            formLabelBarang         : {
                nama_barang             : ''
            }
        }
    },
    methods: {
        displayStatusBarang(stats) {
            switch (stats) {
                case 'pending':
                    return 'Dalam Proses Pembelian ke Supplier'
                    break;
                case 'receive':
                    return 'Barang sudah ada di Gudang'
                    break;
                case 'out':
                    return 'Barang sudah diterima oleh nasabah'
                    break;
                case 'fail':
                    return 'Gagal Bayar'
                    break;

                default:
                    return 'Error'
                    break;
            }
        },
        openModalRetrive($uid, $kdtransaksi, $namabarang) {
            this.openModalRetriveItems = true

            this.formPermintaanBarang.kd_transaksi_murabahah    = $kdtransaksi
            this.formPermintaanBarang.kd_permintaan_barang      = $uid
            this.formLabelBarang.nama_barang                    = $namabarang
        },

        closeModalRetrive() {
            this.formPermintaanBarang.kd_transaksi_murabahah    = ''
            this.formPermintaanBarang.kd_permintaan_barang      = ''
            this.formPermintaanBarang.kd_invoice_barang         = ''
            this.formPermintaanBarang.keterangan                = ''

            this.formLabelBarang.nama_barang                    = ''

            this.openModalRetriveItems = false
        },

        savePermintaan() {
            if(this.formPermintaanBarang.kd_invoice_barang == '')
            {
                return alert('Harap isi nomor invoice terlebih dahulu')
            }

            let konfirmasi = confirm('Apakah anda yakin nomor invoice sudah benar dengan nota pembelian ?')

            if(konfirmasi == true)
            {
                console.log(this.formPermintaanBarang)

                axios.put('/api/bank/terimaBarangPermintaan', this.formPermintaanBarang).then(terima => {
                    alert(terima.data.message)
                    return location.reload()
                }).catch(terima_error => {
                    alert('Server Error')
                })
            } else {
                // No Action
            }
        },

        keluarkanBarang(uid) {
            let pernyataan = confirm('Apakah anda yakin ?')

            if(pernyataan == true)
            {
                axios.put('/api/bank/keluarBarangPermintaan', { kd_permintaan_barang : uid}).then(keluar => {
                    alert(keluar.data.message)
                    return location.reload()
                }).catch(keluarerror => {
                    console.log(keluarerror)
                    alert('Server Error')
                })
            } else {
                // No Action
            }
        }
    }
}
</script>