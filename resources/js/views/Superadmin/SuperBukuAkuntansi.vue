<template>
<div>
    <div class="p-3 bg-white flex flex-row">
        <h1 class="text-2xl italic">{{ judulHalaman }}</h1>
        <button class="p-2 text-white bg-blue-600 w-auto text-sm ml-4" @click="modalTambahBuku = true">Tambah Buku Baru</button>
    </div>
    <div class="p-2">
        <div>
            <table class="border border-white w-full">
                <thead class="bg-slate-500 text-white">
                    <tr>
                        <th class="p-4 bold font-md text-left font-semibold w-[50px]">No.#</th>
                        <th class="p-4 bold font-md text-left font-semibold">Kelompok Akun</th>
                        <th class="p-4 bold font-md text-left font-semibold">Kode Sub Akun</th>
                        <th class="p-4 bold font-md text-left font-semibold">Nama Akun</th>
                        <th class="p-4 bold font-md text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr class="even:bg-slate-200 even:text-black" v-for="(itm, index) in tabelBukuAkuntansi" :key="index">
                        <td class="border border-white text-center p-3">{{ index + 1 }}</td> 
                        <td class="border border-white p-3">{{ deskripsiMasterAkuntansi(itm.kd_master_buku) }}</td> 
                        <td class="border border-white p-3">{{ itm.kd_sub_master_buku }}</td> 
                        <td class="border border-white p-3">{{ itm.nama_buku }}</td> 
                        <td class="border border-white p-3 text-center">
                            <button class="p-2 bg-blue-500 text-white rounded-md text-sm" @click="openModalEditBuku(itm.id)">
                                Edit Nama
                            </button>
                        </td>
                        <!-- <td class="border border-white p-3 text-center">
                            <router-link class="p-2 bg-blue-600 text-white rounded-md text-sm" :to="{ name: 'SuperBankDetail', params: { bankID: bk.kd_bank }}">
                                Details
                            </router-link>
                            5
                        </td>  -->
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    

    <!-- Modal Tambah Buku Akuntansi -->
    <div class="flex flex-col w-full h-full bg-slate-900 left-0 top-0 fixed bg-opacity-70 justify-center align-middle" v-if="modalTambahBuku == true">
        <div class="relative bg-white rounded-lg shadow p-4 m-auto md:w-1/2 2xl:w-1/2">
            <div class="grid grid-rows-1">
                <h1 class="text-2xl text-black mb-10">Tambah Buku Akuntansi Baru</h1>
                <div class="grid gap-2 mb-10">
                    <div class="flex flex-col">
                        <label class="text-black mb-2">Kelompok Akun</label>
                        <select class="border bg-slate-200 pt-1 pb-1 pl-2 rounded-md h-[50px] mb-3" v-model="formInputBukuBaru.kd_master_buku">
                            <option :value="''">-- Pilih Kelompok Akun --</option>
                            <option :value="1">1 - Aktiva Lancar</option>
                            <option :value="2">2 - Aktiva Tetap</option>
                            <option :value="3">3 - Hutang</option>
                            <option :value="4">4 - Ekuitas</option>
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-black mb-2">Nomor Akun</label>
                        <div class="flex">
                            <input type="text" class="border bg-slate-200 pt-1 pb-1 pl-2 rounded-md h-[50px] mb-3 w-full" v-model="formInputBukuBaru.kd_sub_master_buku" maxlength="5" placeholder="Contoh : 31000" />
                            <button class="bg-blue-500 hover:bg-blue-700 transition ease-in-out duration-300 text-white p-1 ml-2 w-1/4 h-[50px] rounded-lg" @click="cekBukuAkuntansi">Cek</button>
                        </div>
                        <label class="bg-green-500 mt-2 p-2" v-if="formInputBukuBaru.statusInputBuku == true">Nomor akun dapat dipakai</label>
                        <label class="bg-red-700 mt-2 p-2 text-white" v-else-if="formInputBukuBaru.statusInputBuku == false">Nomor akun sudah dipakai</label>
                        <label v-else-if="formInputBukuBaru.statusInputBuku == null"></label>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-black mb-2">Nama Akun</label>
                        <input type="text" class="border bg-slate-200 pt-1 pb-1 pl-2 rounded-md h-[50px] mb-3" v-model="formInputBukuBaru.nama_buku" placeholder="Contoh : Hutang Jangka Panjang" />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <button class="bg-slate-300 hover:bg-slate-500 transition ease-in-out duration-300 text-black hover:text-white p-2 rounded-md" @click="clearFormBuatBukuAkuntansi">Tutup</button>
                    <button class="bg-blue-600 hover:bg-blue-900 transition ease-in-out duration-300 text-white p-2 rounded-md" @click="simpanBukuAkuntansi">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <!--  -->

    <!-- Modal Edit Nama Buku Akuntansi -->

    <Transition name="slide-fade">

        <div class="flex flex-col w-full h-full bg-slate-900 left-0 top-0 fixed bg-opacity-70 justify-center align-middle" v-if="modalEditBuku == true">
            <div class="relative bg-white rounded-lg shadow p-4 m-auto w-1/4">
                <div class="grid grid-rows-1">
                    <h1 class="text-2xl text-black mb-5">Rubah Nama Buku</h1>
                    <div class="grid grid-rows-1 mb-5">
                        <div class="flex flex-col">
                            <label class="text-black mb-2">Nomor Akun</label>
                            <input type="text" class="border bg-slate-300 pt-1 pb-1 pl-2 rounded-md h-[50px] mb-3 cursor-not-allowed" v-model="formEditBuku.kd_sub_master_buku" readonly />
                        </div>
                        <div class="flex flex-col">
                            <label class="text-black mb-2">Nama Akun Lama</label>
                            <input type="text" class="border bg-slate-300 pt-1 pb-1 pl-2 rounded-md h-[50px] mb-3 cursor-not-allowed" v-model="formEditBuku.nama_buku_lama" readonly />
                        </div>
                        <div class="flex flex-col">
                            <label class="text-black mb-2">Nama Akun Baru</label>
                            <input type="text" class="border bg-slate-200 pt-1 pb-1 pl-2 rounded-md h-[50px] mb-3" v-model="formEditBuku.nama_buku_baru" placeholder="Isi nama akun baru" />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <button class="bg-slate-300 hover:bg-slate-500 transition ease-in-out duration-300 text-black hover:text-white p-2 rounded-md" @click="modalEditBuku = false">Tutup</button>
                        <button class="bg-blue-600 hover:bg-blue-900 transition ease-in-out duration-300 text-white p-2 rounded-md" @click="simpanEditBukuAkuntansi">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

    </Transition>
    <!--  -->



</div>
</template>

<script>
import axios from 'axios';

export default {
    mounted() {
        axios.get('/api/super/bukuakuntansi').then(hsl => {
            console.log(hsl.data)
            
            let statusweb = hsl.data.status

            if(statusweb == false)
            {
                alert('Server Error')
            }

            this.tabelBukuAkuntansi = hsl.data.data
        });
    },
    data() {
        return {
            judulHalaman                    : 'List Buku Akuntansi',
            tabelBukuAkuntansi              : [],
            inputPencarianBukuAkuntansi     : '',
            modalTambahBuku                 : false,
            modalEditBuku                   : false,
            formInputBukuBaru               : {
                kd_master_buku          : '',
                kd_sub_master_buku      : '',
                nama_buku               : '',
                statusInputBuku         : null,
            },
            formEditBuku                    : {
                kd_buku                 : '',
                kd_sub_master_buku      : '',
                nama_buku_lama          : '',
                nama_buku_baru          : ''
            }
        }
    },
    methods: {
        deskripsiMasterAkuntansi(isi) {
            switch (isi) {
                case 1:
                    return 'Aktiva Lancar';
                    break;
                case 2:
                    return 'Aktiva Tetap';
                    break;
                case 3:
                    return 'Hutang';
                    break;
                case 4:
                    return 'Ekuitas';
                    break;
            }
        },
        cekBukuAkuntansi() {

            let nomorBukuAkuntansi  = this.formInputBukuBaru.kd_sub_master_buku

            // let kodeBukuAkuntansi   = this.formInputBukuBaru.kd_master_buku

            this.formInputBukuBaru.statusInputBuku  = null

            // if(nomorBukuAkuntansi == "" || kodeBukuAkuntansi == "")
            // {
            //     return alert('Mohon pilih kelompok akun dan isi nomor akun sebelum klik Cek')
            // }

            axios.get('/api/super/cekbukuakuntansi/' + nomorBukuAkuntansi).then(hslbuku => {
                console.log(hslbuku.data)
                let kondisi                             = hslbuku.data.status

                if(kondisi == false) {
                    this.formInputBukuBaru.statusInputBuku = false
                } else if(kondisi == true) {
                    this.formInputBukuBaru.statusInputBuku = true
                }
            })
        },
        simpanBukuAkuntansi() {
            let cekNomorBuku    = this.formInputBukuBaru.statusInputBuku
            let isiForm         = this.formInputBukuBaru

            if(cekNomorBuku == false || cekNomorBuku == null)
            {
                return alert('Nomor Akun belum lolos pengecekan duplikasi, silahkan mengecek nomor akun terlebih dahulu sebelum menyimpan data')
            }

            axios.post('/api/super/addbukuakuntansi', isiForm).then(hslinput => {
                // console.log(hslinput.data)

                alert('Data berhasil disimpan')

                return location.reload()

            }).catch(hslinputerr => {
                console.log(hslinputerr)

                alert('Server Error')
                return location.reload()
            })

        },
        openModalEditBuku(ids) {
            console.log(ids)

            this.formEditBuku.kd_buku                   = ''
            this.formEditBuku.kd_sub_master_buku        = ''
            this.formEditBuku.nama_buku_lama            = ''
            this.formEditBuku.nama_buku_baru            = ''

            axios.get('/api/super/tabelcekbukuakuntansi/'+ ids).then(hsltbl => {
                console.log(hsltbl.data)

                this.formEditBuku.kd_buku                   = hsltbl.data.data.id
                this.formEditBuku.kd_sub_master_buku        = hsltbl.data.data.kd_sub_master_buku
                this.formEditBuku.nama_buku_lama            = hsltbl.data.data.nama_buku

                this.modalEditBuku                          = true

            }).catch(hsltblerr => {
                console.log(hsltblerr)
            })
        },
        simpanEditBukuAkuntansi() {
            console.log(this.formEditBuku)

            let isiFormEdit = this.formEditBuku

            axios.put('/api/super/editbukuakuntansi', isiFormEdit).then(hsledt => {
                if(hsledt.data.status == true)
                {
                    alert('Data berhasil diedit')
                    return location.reload()
                } else if(hsledt.data.status == false)
                {
                    alert('Server Error')
                    return location.reload()
                }
            }).catch(hsledterr => {
                console.log(hsledterr)
            })
        },
        clearFormBuatBukuAkuntansi() {
            this.formInputBukuBaru.kd_master_buku          = ''
            this.formInputBukuBaru.kd_sub_master_buku      = ''
            this.formInputBukuBaru.nama_buku               = ''
            this.formInputBukuBaru.statusInputBuku         = null

            this.modalTambahBuku                           = false
        }
    }
}
</script>