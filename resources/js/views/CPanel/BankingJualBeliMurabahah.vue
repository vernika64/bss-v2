<template>

    <div>
        <div class="p-3 bg-white border-t border-b flex flex-row">
            <h1 class="text-2xl italic">{{ judulNavbar }}</h1>
            <button class="p-2 text-white bg-blue-600 w-auto text-sm ml-4" @click="openModalAddJualBeli = true">Tambah
                Transaksi Baru</button>
        </div>
        <div class="p-2">
            <div class="flex mb-2">
                <input class="w-full p-2 border" placeholder="Cari Transaksi berdasarkan Kode Transaksi"
                    v-model="inputPencarian" />
                <button class="bg-blue-500 p-2 text-white w-[100px] ml-2" @click="cariTransaksi">Cari</button>
            </div>
            <div>
                <table class="border border-white w-full">
                    <thead class="bg-slate-500 text-white">
                        <tr>
                            <th class="p-4 bold font-md text-left font-semibold w-[50px]">No.#</th>
                            <th class="p-4 bold font-md text-left font-semibold">Kode Transaksi</th>
                            <th class="p-4 bold font-md text-left font-semibold">Nama Nasabah</th>
                            <th class="p-4 bold font-md text-left font-semibold">Permintaan</th>
                            <th class="p-4 bold font-md text-left font-semibold">Status</th>
                            <th class="p-4 bold font-md text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <tr class="even:bg-slate-200 even:text-black" v-for="(jb, index) in tabelJualBeli" :key="index">
                            <td class="border border-white text-center p-3">{{ index + 1 }}</td>
                            <td class="border border-white p-3">{{ jb.kd_transaksi_murabahah }}</td>
                            <td class="border border-white p-3">{{ jb.nama_sesuai_identitas }}</td>
                            <td class="border border-white p-3">{{ jb.nama_permintaan }}</td>
                            <td class="border border-white p-3">{{ displayStatus(jb.status_transaksi) }}</td>
                            <td class="border border-white p-3 text-center">
                                <router-link class="p-2 text-white bg-blue-800 w-auto text-sm ml-4"
                                    v-if="jb.status_transaksi == 'pending'"
                                    :to="{ name: 'JualBeliMurabahahDetail', query: { id: jb.id } }">Verifikasi
                                </router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Modal Section -->
        <div class="w-full h-full overflow-auto bg-slate-900 left-0 top-0 fixed bg-opacity-70"
            v-if="openModalAddJualBeli == true">
            <!-- Modal Content -->
            <div class="flex h-screen">
                <div class="bg-white w-[1000px] m-auto p-4 rounded-lg">
                    <div class="grid grid-rows-1">
                        <h1 class="text-2xl text-black mb-10">Tambah Transaksi Murabahah Baru</h1>
                        <div class="grid grid-rows-1 gap-2 mb-10">
                            <label class="font-bold text-black">CIF Peminta</label>
                            <select class="border border-slate-500 bg-white p-1" v-model="formJualBeli.kd_nasabah">
                                <option :value="''">-- Pilih CIF --</option>
                                <option v-for="(cf, index) in listCustomer" :key="index" :value="cf.id">{{
                                        cf.kd_identitas
                                }} - {{ cf.nama_sesuai_identitas }}</option>
                            </select>
                            <label class="font-bold text-black">Judul Permintaan</label>
                            <input type="text" class="border border-slate-500 bg-white p-1"
                                v-model="formJualBeli.nama_permintaan" />
                            <label class="font-bold text-black">Deskripsi Permintaan</label>
                            <textarea class="border border-slate-500 bg-white p-1 h-[150px]"
                                v-model="formJualBeli.deskripsi_permintaan"></textarea>
                            <label class="font-bold text-black">Link Dokumen Pendukung</label>
                            <input type="text" class="border border-slate-500 bg-white p-1"
                                v-model="formJualBeli.link_pendukung" />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <button class="bg-slate-300 text-black p-2 rounded-md"
                                @click="openModalAddJualBeli = false">Tutup</button>
                            <button class="bg-blue-600 text-white p-2 rounded-md"
                                @click="tambahJualBeli">Simpan</button>
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
        axios.get('/api/bank/listCIFAll').then(res => {
            this.listCustomer = res.data.data
            console.log(this.listCustomer)
        }).catch(err => {
            console.log(err)
        })

        axios.get('/api/bank/listJualBeliMurabahah').then(res2 => {
            this.tabelJualBeli = res2.data.data
            console.log(this.tabelJualBeli)
        })

    },
    data() {
        return {
            judulNavbar: 'Jual Beli akad Murabahah',
            openModalAddJualBeli: false,
            listCustomer: [],
            formJualBeli: {
                kd_cif: '',
                nama_permintaan: '',
                deskripsi_permintaan: '',
                link_pendukung: ''
            },
            tabelJualBeli: [],
            inputPencarian: ''
        }
    },
    methods: {
        tambahJualBeli() {
            console.log(this.formJualBeli)

            axios.post('/api/bank/listJualBeliMurabahah/Add', this.formJualBeli).then(hsl => {
                console.log(hsl.data)
                alert(hsl.data.message)
                return location.reload()
            }).catch(hslerr => {
                console.log(hslerr)
            })
        },
        displayStatus(stats) {
            switch (stats) {
                case 'pending':
                    return 'Menunggu Verifikasi'
                    break;
                case 'active':
                    return 'Lolos Verifikasi'
                    break;
                case 'pass':
                    return 'Lunas'
                    break;
                case 'fail':
                    return 'Gagal Bayar'
                    break;
                case 'reject':
                    return 'Ditolak'
                    break;

                default:
                    return 'Error'
                    break;
            }
        },
        cariTransaksi() {
            console.log(this.inputPencarian)

            axios.get('/api/bank/cariJualBeliMurabahah/' + this.inputPencarian).then(pencarian => {
                console.log(pencarian.data)
                if (pencarian.data.status == false) {
                    return alert('Data tidak ditemukan')
                }
                this.tabelJualBeli = pencarian.data.data
            }).catch(error_pencarian => {
                return console.log(error_pencarian.data)
            })
        }
    }
}
</script>