<template>

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
    <Transition name="slide-fade">
    <div class="flex flex-col w-full h-full bg-slate-900 left-0 top-0 fixed bg-opacity-70 justify-center align-middle" v-if="openModalAddJualBeli == true">
        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow p-4 m-auto md:w-3/4 2xl:w-[60%]">
            <div class="grid grid-rows-1">
                <h1 class="text-2xl text-black mb-4">Buat Permintaan Jual Beli Murabahah</h1>
                <div class="grid  md:grid-cols-1 2xl:grid-cols-2 gap-2 mb-4">
                    <fieldset class="border border-slate-300 rounded-md pl-4 pr-2 pb-4 pt-2">
                        <legend>Cari data CIF</legend>

                        <div class="flex flex-col mb-2">
                            <label>Cari Identitas</label>
                            <div class="flex flex-row gap-2">
                                <select class="flex-none border border-slate-300 bg-blue-600 text-white shadow-md rounded-md text-md p-2" v-model="formJualBeli.tipe_id">
                                    <option :value="'ktp'">KTP</option>
                                    <option :value="'ktm'">KTM</option>
                                </select>
                                <input type="text" class="flex-auto border border-slate-300 bg-white shadow-md rounded-md text-md p-2" placeholder="Nomor Identitas Nasabah" v-model="formJualBeli.kd_identitas">
                                <button class="flex-none bg-blue-700 hover:bg-blue-900 text-white pb-2 pt-2 pr-4 pl-4 rounded-md" @click="cariDataNasabah">Cari</button>
                            </div>
                        </div>

                        <div class="flex flex-col mb-2">
                            <label>Nama Nasabah</label>
                            <input class="border border-slate-300 bg-white shadow-md rounded-md text-md p-2" placeholder="Nama Nasabah (terisi otomatis)" readonly v-model="dummyFormJualBeli.nama_nasabah">
                        </div>

                        <div class="flex flex-col mb-2">
                            <label>Alamat Nasabah</label>
                            <textarea class="border border-slate-300 bg-white shadow-md rounded-md text-md p-2" placeholder="Nama Nasabah (terisi otomatis)" readonly v-model="dummyFormJualBeli.alamat_nasabah"></textarea>
                        </div>

                        <!-- <div class="flex flex-col">
                            <label>CIF</label>
                            <select class="border border-slate-300 bg-white shadow-md rounded-md text-md p-2" v-model="formJualBeli.kd_identitas">
                                <option :value="''">-- Pilih CIF --</option>
                                <option v-for="(cf, index) in listCustomer" :key="index" :value="cf.id">
                                    {{ cf.kd_identitas }} - {{ cf.nama_sesuai_identitas }}
                                </option>
                            </select>
                        </div> -->
                    </fieldset>

                    <fieldset class="border border-slate-300 rounded-md pl-4 pr-2 pb-4 pt-2">
                        <legend>Deskripsi Permintaan dan Lampiran</legend>

                            <div class="flex flex-col mb-2">
                                <label>Judul Permintaan</label>
                                <input type="text" class="border border-slate-300 bg-white shadow-md rounded-md text-md p-2" v-model="formJualBeli.nama_permintaan" />
                            </div>
        
                            <div class="flex flex-col mb-2">
                                <label>Deskripsi Permintaan</label>
                                <textarea class="border border-slate-300 bg-white shadow-md rounded-md text-md p-2" v-model="formJualBeli.deskripsi_permintaan"></textarea>
                            </div>
        
                            <div class="flex flex-col mb-2">
                                <label>Link Dokumen Pendukung</label>
                                <input type="text" class="border border-slate-300 bg-white shadow-md rounded-md text-md p-2" v-model="formJualBeli.link_pendukung" />
                            </div>
                    </fieldset>


                </div>
                <div class="grid grid-cols-2 gap-4">
                    <button class="bg-slate-300 hover:bg-slate-400 text-black p-2 rounded-md" @click="openModalAddJualBeli = false">Tutup</button>
                    <button class="bg-blue-700 hover:bg-blue-900 text-white p-2 rounded-md" @click="tambahJualBeli">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    </Transition>
    <!--  -->

</template>

<script>
import axios from 'axios'

export default {
    mounted() {
        axios.get('/api/bank/listJualBeliMurabahah').then(res2 => {
            console.log(res2.data)

            let data            = res2.data.data

            this.tabelJualBeli  = data
        })

    },
    data() {
        return {
            judulNavbar: 'Jual Beli akad Murabahah',
            openModalAddJualBeli: false,
            listCustomer: [],
            formJualBeli: {
                tipe_id                 : 'ktp',
                kd_identitas            : '',
                nama_permintaan         : '',
                deskripsi_permintaan    : '',
                link_pendukung          : ''
            },
            dummyFormJualBeli: {
                nama_nasabah            : '',
                alamat_nasabah          : ''
            },
            tabelJualBeli: [],
            inputPencarian: ''
        }
    },
    methods: {
        displayStatus(stats) {
            switch (stats) {
                case 'pending':
                    return 'Menunggu Verifikasi'
                case 'active':
                    return 'Lolos Verifikasi'
                case 'pass':
                    return 'Lunas'
                case 'fail':
                    return 'Gagal Bayar'
                case 'reject':
                    return 'Ditolak'

                default:
                    return 'Error'
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
        },
        cariDataNasabah() {
            console.log(this.formJualBeli)

            let data    = {
                'tipe_id'        : this.formJualBeli.tipe_id,
                'kd_identitas'   : this.formJualBeli.kd_identitas
            }

            axios.post('/api/bank/cariDataCIF', data).then(hasil => {
                console.log(hasil.data)

                let status  = hasil.data.qr_status

                if(status == false) {
                    alert('Data tidak ditemukan, coba lagi')
                } else if(status == true) {
                    alert(hasil.data.message)

                    let dat = hasil.data.data
    
                    this.dummyFormJualBeli.nama_nasabah     = dat.nama
                    this.dummyFormJualBeli.alamat_nasabah   = dat.alamat
                } else {
                    alert('Terjadi kesalahan pada halaman website, dimohon untuk merefresh halaman untuk mencoba lagi')
                }
            }).catch(error => {
                console.log(error.data)
            })
        },
        tambahJualBeli() {
            console.log(this.formJualBeli)

            axios.post('/api/bank/listJualBeliMurabahah/Add', this.formJualBeli).then(hsl => {
                console.log(hsl.data)
                alert(hsl.data.message)
                // return location.reload()
            }).catch(hslerr => {
                console.log(hslerr)
            })
        },
    }
}
</script>