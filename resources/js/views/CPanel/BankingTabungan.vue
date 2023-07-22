<template>
    <div>
        <div class="p-3 bg-white border-t flex flex-row">
            <h1 class="text-2xl italic">{{ judulNavbar }}</h1>
            <button class="p-2 text-white bg-blue-600 w-auto text-sm ml-4" @click="openModalAddTabungan = true">Tambah Tabungan baru</button>
        </div>
        <div class="p-2">
            <div>
                <table class="border border-white w-full">
                    <thead class="bg-slate-500 text-white">
                        <tr>
                            <th class="p-4 bold font-md text-left font-semibold w-[50px]">#</th>
                            <th class="p-4 bold font-md text-left font-semibold">Nomor Tabungan</th>
                            <th class="p-4 bold font-md text-left font-semibold">Produk Tabungan</th>
                            <th class="p-4 bold font-md text-left font-semibold">Nama Nasabah</th>
                            <th class="p-4 bold font-md text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <tr v-for="(tb, index) in tabelTabungan" :key="index" class="even:bg-slate-200 even:text-black">
                            <td class="border border-white text-center p-3">{{ index + 1 }}</td>
                            <td class="border border-white p-3">{{ tb.kd_buku_tabungan }}</td>
                            <td class="border border-white p-3">{{ tb.nama_produk }}</td>
                            <td class="border border-white p-3">{{ tb.nama_sesuai_identitas }}</td>
                            <td class="border border-white p-3 text-center"><button class="bg-blue-500 text-white p-2" @click="bukaModalDetailTabungan(tb.kd_buku_tabungan)">Details</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <Transition name="slide-fade">
        <div class="flex flex-col w-full h-full bg-slate-900 left-0 top-0 fixed bg-opacity-70 justify-center align-middle" v-if="modalDetailTabungan.status == true">
            <!-- Modal Content -->
            <div class="relative bg-white rounded-lg shadow p-4 m-auto md:w-1/2 2xl:w-1/4">
                <div class="grid grid-rows-1">
                <h1 class="text-2xl text-black mb-4">Detail Tabungan | {{ modalDetailTabungan.data.kd_buku_tabungan }}</h1>
                <div class="grid grid-cols-1 gap-4">
                    <div class="flex flex-col gap-2 mb-2">
                        <label>Kode Tabungan</label>
                        <input class="border border-slate-300 bg-white shadow-md rounded-md text-md p-2" readonly v-model="modalDetailTabungan.data.kd_buku_tabungan">
                    </div>
                    <div class="flex flex-col gap-2 mb-2">
                        <label>Nominal Tabungan</label>
                        <div class="flex flex-row gap-2">
                            <input class="flex-auto border border-slate-300 bg-white shadow-md rounded-md text-md p-2" readonly v-model="modalDetailTabungan.data.total_nilai">
                            <button class="flex-none bg-blue-700 hover:bg-blue-900 text-white p-2 rounded-md shadow-md" @click="lihatNominalTabungan">Lihat Nominal</button>
                        </div>
                    </div>
                    <div class="flex flex-col mb-4">
                        <router-link class="bg-blue-500 hover:bg-blue-900 text-white text-center p-2 rounded-md shadow-md" :to="{ path: '/api/bank/laporan/riwayatTransaksiTabungan/' + this.modalDetailTabungan.data.kd_buku_tabungan}" target="_blank">Cetak Riwayat Transaksi</router-link>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-2">
                        <button class="bg-slate-300 hover:bg-slate-400 text-black p-2 rounded-md" @click="tutupModalDetailTabungan">Tutup</button>
                        <button class="bg-blue-700 hover:bg-blue-900 text-white p-2 rounded-md" >Simpan</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </Transition>

    <Transition name="slide-fade">

        <!-- Modal Section -->
        <div class="flex flex-col w-full h-full bg-slate-900 left-0 top-0 fixed bg-opacity-70 justify-center align-middle" v-if="openModalAddTabungan == true">
            <!-- Modal Content -->
            <div class="relative bg-white rounded-lg shadow p-4 m-auto md:w-1/2 2xl:w-[60%]">
                <div class="grid grid-rows-1">
                    <h1 class="text-2xl text-black mb-4">Tambah Tabungan Baru</h1>
                    <div class="grid grid-cols-1 2xl:grid-cols-2 gap-4">
                        <!-- <div class="grid grid-rows-2 mb-2">
                            <label>Target Nasabah</label>
                            <select class="border bg-white p-2" v-model="formTabunganBaru.kd_cif">
                                <option :value="''">-- Pilih Data --</option>
                                <option v-for="(nsb, index) in listNasabah" :key="index" :value="nsb.id">{{ nsb.kd_identitas }} - {{ nsb.nama_sesuai_identitas }}</option>
                            </select>
                        </div> -->

                        <fieldset class="border border-slate-300 rounded-md p-4">
                            <legend>Step 1 - Cari data nasabah</legend>
                            <input type="hidden" v-model="csrf" />

                            <div class="flex flex-col gap-2 mb-2">
                                <label>Jenis Tanda Pengenal</label>
                                <select class="border border-slate-300 bg-white shadow-md rounded-md text-md p-2" v-model="formTabunganBaru.tipe_id">
                                    <option :value="''">-- Pilih Tipe Identitas --</option>
                                    <option :value="'ktp'">KTP</option>
                                    <option :value="'ktm'">KTM</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-2 mb-4">
                                <label>Nomor Identitas</label>
                                <input class="border border-slate-300 bg-white shadow-md rounded-md text-md p-2" placeholder="Nomor identitas sesuai kartu identitas" v-model="formTabunganBaru.kd_identitas" />
                            </div>
                            <div class="flex flex-col">
                                <button class="p-2 bg-blue-700 hover:bg-blue-900 text-white rounded-md shadow-md" @click="cekDataNasabah">Cari data nasabah</button>
                            </div>
                        </fieldset>

                        <fieldset class="border border-slate-300 rounded-md p-4">
                            <legend>Step 2 - Hasil Pencarian</legend>

                            <div class="flex flex-col gap-2 mb-2">
                                <label>Nama Nasabah</label>
                                <input class="border border-slate-300 bg-white shadow-md rounded-md text-md p-2" v-model="dummyFormHasilPencarian.nama_nasabah" readonly />
                            </div>
                            <div class="flex flex-col gap-2 mb-4">
                                <label>Alamat sesuai Identitas</label>
                                <input class="border border-slate-300 bg-white shadow-md rounded-md text-md p-2" v-model="dummyFormHasilPencarian.alamat_nasabah" readonly />
                            </div>
                            
                            <div :class="[status_cek_cif == false ? 'hidden' : 'flex flex-row gap-2']">
                                <button class="w-full bg-blue-700 text-white rounded-md shadow-md p-2">Cek Tabungan</button>
                                <router-link class="w-full bg-blue-700 text-white rounded-md shadow-md p-2 text-center" :to="{ path: '/api/bank/laporan/buatKontrakTabungan', query: { tipe_id: this.formTabunganBaru.tipe_id, kd_identitas: this.formTabunganBaru.kd_identitas}}" target="_blank">Cetak Surat Perjanjian</router-link>
                            </div>
                        </fieldset>

                        <fieldset class="border border-slate-300 rounded-md p-4 mb-2 2xl:col-span-2">
                            <legend>Step 3 - Pilih produk tabungan</legend>

                            <div class="flex flex-col mb-2">
                                <label>Produk Tabungan</label>
                                <select class="border bg-white p-2" v-model="formTabunganBaru.kd_produk_tabungan">
                                    <option :value="''">-- Pilih Data --</option>
                                    <option v-for="(tab, index) in listProdukTabungan" :key="index" :value="tab.id">{{ tab.nama_produk }}</option>
                                </select>
                            </div>
                        </fieldset>

                    </div>
                        
                    <div class="grid grid-cols-2 gap-4 mt-2">
                        <button class="bg-slate-300 hover:bg-slate-400 text-black p-2 rounded-md" @click="tutupDaftarTabungan">Tutup</button>
                        <button class="bg-blue-700 hover:bg-blue-900 text-white p-2 rounded-md" @click="tambahTabungan">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
        <!--  -->
        
    </Transition>


</template>

<script>
import axios from 'axios'

export default {
    mounted()
    {
        axios.get('/api/buatForm').then(hsll => {
            this.csrf   = hsll.data.csrf_token
            console.log(this.csrf)
        }).catch(errr => {
            console.log('Gagal mengambil token CSRF')
        })

        axios.get('/api/bank/listCIFAll').then(res => {
            this.listNasabah = res.data.data
            // console.log(this.listNasabah)
        }).catch(err1 => {
            console.log(err1)
        })

        axios.get('/api/bank/listTabunganTabel').then(res2 => {
            this.tabelTabungan = res2.data.data
            console.log(this.tabelTabungan)
        }).catch(err2 => {
            console.log(err2)
        })

        axios.get('/api/bank/listProdukTabungan').then(res3 => {
            this.listProdukTabungan = res3.data.data
            // console.log(this.listProdukTabungan)
        })
    },
    data() {
        return {
            openModalAddTabungan    : false,
            listProdukTabungan      : [],
            listNasabah             : [],
            judulNavbar             : 'Tabungan Wadiah',
            formTabunganBaru        : {
                kd_produk_tabungan  : '',
                kd_identitas        : '',
                tipe_id             : ''
            },
            dummyFormHasilPencarian : {
                nama_nasabah        : '',
                alamat_nasabah      : ''
            },
            modalDetailTabungan     : {
                status          : false,
                data            : {
                    kd_buku_tabungan    : '',
                    total_nilai         : ''
                }
            },
            tabelTabungan           : [],
            status_cek_cif          : false
        }
    },
    methods: {
        tambahTabungan() {
            console.log(this.formTabunganBaru)

            axios.post('/api/bank/tabungan/tambah', this.formTabunganBaru).then(nxt => {
                console.log('Error sukses')
                console.log(nxt.data)

                if(nxt.data.status == 200)
                {
                    alert(nxt.data.message)
                    return location.reload()
                } else if(nxt.data.status >= 400) {
                    alert(nxt.data.message)
                }
            }).catch(err_nxt => {
                console.log('Error catch')
                console.log(err_nxt)
            })
        },
        cekDataNasabah() {
            if(this.formTabunganBaru.kd_identitas == '' || this.formTabunganBaru.tipe_id == '') {
                return alert('Data pencarian harus diisi terlebih dahulu')    
            } else if (this.formTabunganBaru.kd_identitas != '' && this.formTabunganBaru.tipe_id != '') {
                let data = {
                    tipe_id         : this.formTabunganBaru.tipe_id,
                    kd_identitas    : this.formTabunganBaru.kd_identitas
                }

                this.status_cek_cif                                     = false
                this.dummyFormHasilPencarian.nama_nasabah               = ''
                this.dummyFormHasilPencarian.alamat_nasabah             = ''

                axios.post('/api/bank/cariDataCIF', data).then(hsl => {
                    console.log(hsl.data)
                    if(hsl.data.status == 200) {
                        console.log(hsl.data)

                        this.dummyFormHasilPencarian.nama_nasabah       = hsl.data.data.nama
                        this.dummyFormHasilPencarian.alamat_nasabah     = hsl.data.data.alamat

                        this.status_cek_cif                             = true

                        return alert(hsl.data.message)
                    } else if(hsl.data.status == 400) {
                        return alert(hsl.data.message)
                    }
                }).catch(err => {
                    console.log(err.data)
                })
            } else {
                return alert('Terdapat kesalahan di sisi client, mohon merestart halaman jika tombol tidak berfungsi')
            }
        },
        tutupDaftarTabungan() {
            this.formTabunganBaru.kd_identitas              = ''
            this.formTabunganBaru.tipe_id                   = ''
            this.formTabunganBaru.kd_produk_tabungan        = ''
            this.status_cek_cif                             = false
            this.dummyFormHasilPencarian.nama_nasabah       = ''
            this.dummyFormHasilPencarian.alamat_nasabah     = ''

            this.openModalAddTabungan                       = false
        },
        bukaModalDetailTabungan(uid) {
            let kd_buku_tabungan            = uid

            this.modalDetailTabungan.status                     = true
            this.modalDetailTabungan.data.kd_buku_tabungan      = kd_buku_tabungan
            this.modalDetailTabungan.data.total_nilai           = '<Hidden>'
        },
        tutupModalDetailTabungan() {
            this.modalDetailTabungan.status                     = false
            this.modalDetailTabungan.data.kd_buku_tabungan      = ''
            this.modalDetailTabungan.data.total_nilai           = ''
        },
        lihatNominalTabungan() {

            let kd_buku_tabungan                                = this.modalDetailTabungan.data.kd_buku_tabungan

            axios.get('/api/bank/listTabungan/kdTabungan/' + kd_buku_tabungan).then(hasil => {
                let nominal_tabungan                                = String(hasil.data.data.total_nilai)
    
                this.modalDetailTabungan.data.total_nilai           = 'Rp. ' + nominal_tabungan.split(/(?=(?:\d{3})+$)/).join(",")

                return alert('Data berhasil diambil')
            }).catch(error => {
                console.log(error.data)
                return alert('Terjadi kesalahan')
            })

        }
    }
}
</script>