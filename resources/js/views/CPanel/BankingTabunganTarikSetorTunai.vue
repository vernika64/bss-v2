<template>
<div>
    <div class="p-3 bg-white border-t border-b flex flex-row">
        <h1 class="text-2xl italic">{{ judulNavbar }}</h1>
    </div>
    <!-- <div class="grid grid-cols-2 mt-4 gap-4">
        <div class="text-center p-4">
            <div class="bg-white p-4">
                <h1 class="text-2xl">Tarik Tunai</h1>
                <input class="p-2 border w-full mt-4" placeholder="Nomor Rekening Tabungan Nasabah" />
                <button class="bg-blue-500 text-white p-2 w-full mt-2">Cari Tabungan</button>
            </div>
        </div>
        <div class="text-center p-4">
            <div class="bg-white p-4">
                <h1 class="text-2xl">Setor Tunai</h1>
                <input class="p-2 border w-full mt-4" placeholder="Nomor Rekening Tabungan Nasabah" />
                <button class="bg-blue-500 text-white p-2 w-full mt-2">Cari Tabungan</button>
            </div>
        </div>
    </div> -->
    <div class="mt-4 p-4 flex flex-col gap-4">
        <div class="bg-white p-4">
            <h1 class="text-2xl">Form Transaksi Tabungan</h1>
            <div class="flex flex-wrap mt-4">
                <div class="flex-auto">
                    <!-- <label class="font-bold">Cari Nomor Rekening Nasabah</label> -->
                    <input class="bg-white w-full p-2 border" placeholder="Nomor rekening nasabah" v-model="inputCariTabungan" />
                </div>
                <div class="flex-initial w-32 ml-4">
                    <button class="bg-blue-500 text-white w-full p-2" @click="cariTabungan">Cari</button>
                </div>
            </div>
        </div>
        <div v-if="openFormTransaksi == true">
            <div class="bg-white p-4">
                <!-- <h1 class="text-2xl mb-4">Form</h1> -->
                <div class="grid grid-cols-2">
                    <div class="flex flex-col gap-2 pt-2 pl-2 pr-1">
                        <div>
                            <label class="font-bold">Nomor Rekening Nasabah</label>
                            <input class="bg-white w-full p-2 border" v-model="formTransaksi.kd_buku_tabungan" readonly />
                        </div>
                        <div>
                            <label class="font-bold">Nama Nasabah</label>
                            <input class="bg-white w-full p-2 border" v-model="labelTransaksi.nama_nasabah" readonly />
                        </div>
                        <div>
                            <label class="font-bold">Produk Tabungan</label>
                            <input class="bg-white w-full p-2 border" v-model="labelTransaksi.produk_tabungan" readonly />
                        </div>
                        <div>
                            <label class="font-bold">Nilai Tabungan</label>
                            <input class="bg-white w-full p-2 border" v-model="labelTransaksi.nilai_tabungan" readonly />
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 pt-2 pr-2 pl-1">
                        <div>
                            <label class="font-bold">Jenis Transaksi</label>
                            <select class="bg-white w-full p-2 border" v-model="formTransaksi.jenis_transaksi">
                                <option :value="''">-- Pilih Jenis Transaksi --</option>
                                <option :value="'tarik'">Tarik Tunai</option>
                                <option :value="'setor'">Setor Tunai</option>
                            </select>
                        </div>
                        <div>
                            <label class="font-bold">No. Nota Fisik</label>
                            <input class="bg-white w-full p-2 border" v-model="formTransaksi.no_nota_fisik" readonly />
                        </div>
                        <div>
                            <label class="font-bold">Nominal Transaksi</label>
                            <input class="bg-white w-full p-2 border" v-model="formTransaksi.nominal_transaksi" />
                        </div>
                        <div>
                            <button style="visibility: hidden;">A</button>
                            <button class="w-full bg-blue-500 text-white p-2" @click="simpanTransaksi">Simpan Transaksi</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import axios from 'axios'

export default {
    data() {
        return {
            judulNavbar         : 'Transaksi Tabungan Wadiah',
            inputCariTabungan   : '',
            openFormTransaksi   : false,
            labelTransaksi      : {
                nama_nasabah    : '',
                produk_tabungan : '',
                nilai_tabungan  : ''
            },
            formTransaksi       : {
                kd_buku_tabungan    : '',
                jenis_transaksi     : '',
                no_nota_fisik       : '',
                nominal_transaksi   : ''
            }
        }
    },
    methods: {
        cariTabungan() {
            axios.get('/api/bank/listTabungan/' + this.inputCariTabungan).then(tb => {
                console.log(tb.data)

                if(tb.data.status == false)
                {
                    alert(tb.data.message)
                } else if(tb.data.status == true)
                {
                    alert(tb.data.message)
                    console.log(tb.data)
                    this.openFormTransaksi = true

                    this.formTransaksi.kd_buku_tabungan = tb.data.data.kd_buku_tabungan
                    this.formTransaksi.no_nota_fisik    = tb.data.data.no_nota_fisik
                    this.labelTransaksi.nama_nasabah    = tb.data.data.nama_nasabah
                    this.labelTransaksi.nilai_tabungan  = 'Rp. ' + new Intl.NumberFormat(['ban', 'id']).format(tb.data.data.nilai_tabungan) + ',-'
                    this.labelTransaksi.produk_tabungan = tb.data.data.produk_tabungan
                } else {
                    alert(tb.data.status)
                }
            }).catch(tb_error => {
                console.log(tb_error)
            })
        },
        simpanTransaksi()
        {
            if(this.formTransaksi.jenis_transaksi == '')
            {
                return alert('Mohon diisi jenis transaksi')
            } else if(this.formTransaksi.jenis_transaksi == 'setor' || this.formTransaksi.jenis_transaksi == 'tarik')
            {
                let konfirmasi = confirm('Apakah anda yakin nominal transaksi sudah benar ?')

                if(konfirmasi == true)
                {
                    axios.post('/api/bank/tambahTransaksiTabungan', this.formTransaksi).then(transaksi => {
                        console.log(transaksi.data)
                        return alert(transaksi.data.message)
                    }).catch(transaksi_error => {
                        console.log(transaksi_error)
                        return alert('Server Error')
                    })
                } 
                else if(konfirmasi == false)
                {
                    return false
                }
                else {
                    return alert('Server error, silahkan hubungi web administrator')
                }
                
            } else {
                return alert('Browser Error, Please Reload the website')
            }
        }
    }
}
</script>