<template>
<div>
    <div class="p-3 bg-white border-t flex flex-row border-b">
        <h1 class="text-2xl italic">{{ judulNavbar }} {{ formTransaksi.kd_transaksi_murabahah }}</h1>
    </div>
    <div class="mt-4 ml-2">
        <div class="grid grid-cols-2">
            <div class="bg-white border p-4 m-2 grid gap-4">
                <div class="grid grid-cols-2">
                    <p class="text-lg">Judul Permintaan</p>
                    <p class="text-lg">{{ formTransaksi.nama_permintaan }}</p>
                </div>
                <div class="grid grid-cols-2">
                    <p class="text-lg">Nama Nasabah</p>
                    <p class="text-lg">{{ formTransaksi.nama_sesuai_identitas }}</p>
                </div>
                <div>
                    <p class="text-lg mb-2">Deskripsi</p>
                    <textarea class="text-md text-justify overflow-auto w-full border p-2 bg-slate-200" v-model="formTransaksi.deskripsi_permintaan" readonly></textarea>
                </div>
                <div>
                    <p class="text-lg mb-2">Link Dokumen Pendukung</p>
                    <input class="text-md text-justify w-full border p-2 bg-slate-200" v-model="formTransaksi.link_lampiran" />
                </div>
                <div>
                    <label class="font-bold">Aksi</label>
                    <select class="w-full border p-2" v-model="keputusan">
                        <option :value="''">-- Pilih Opsi --</option>
                        <option :value="'terima'">Terima</option>
                        <option :value="'tolak'">Tolak</option>
                    </select>
                </div>
                <div v-if="keputusan == 'tolak'">
                    <p class="text-lg mb-2">Alasan Penolakan</p>
                    <textarea class="w-full h-[100px] border p-2" v-model="formReject.desc_penolakan" placeholder="Alasan ditolak"></textarea>
                    <button class="bg-red-700 text-white w-full p-2 mt-2"  @click="konfirmasi">Simpan untuk menolak permintaan</button>
                </div>
            </div>
            <div class="bg-white border p-4 m-2 row-span-2" v-if="keputusan == 'terima'">
                <label>Nama Barang</label>
                <input type="text" class="p-2 w-full border" v-model="formDummy.nama_barang" placeholder="Nama barang yang dipesan nasabah" />
                <label>Harga barang Satuan</label>
                <input type="text" class="w-full p-2 border" v-model="formDummy.harga_barang_satuan" placeholder="Harga satuan barang" />
                <label>Kuantitas barang</label>
                <div class="flex">
                    <input class="w-full p-2 border" v-model="formDummy.qty_barang" placeholder="Kuantitas Barang" @keyup="kalkulasiTotalHargaBarang" />
                    <select class="w-auto p-2 ml-2 flex-1 border" v-model="formDummy.qty_type">
                        <option :value="'qty'">qty</option>
                    </select>
                </div>
                <label>Total Harga Barang</label>
                <input class="p-2 w-full border bg-slate-200" v-model="formDummy.total_harga_barang" placeholder="Total Harga Barang (Terisi otomatis oleh sistem)" />
                <label>Margin untuk Bank</label>
                <input class="p-2 w-full border" v-model="formDummy.surplus_untuk_bank" @keyup="kalkulasiSurplusBank" />
                <label>Total Biaya Jual Beli Akad Murabahah tanpa Uang Muka</label>
                <input class="p-2 w-full border bg-slate-200" v-model="formDummy.total_biaya_akad_murabahah" placeholder="Total Biaya yang akan dibayarkan oleh nasabah sampai akhir akad" readonly />

                <label>Uang Muka</label>
                <input class="p-2 w-full border" v-model="formDummy.uang_muka" @keyup="kalkulasiBiayaSetelahDP" />

                <label>Total Biaya Jual Beli setelah dikurangi Uang Muka</label>
                <input class="p-2 w-full border bg-slate-200" v-model="formDummy.total_biaya_setelah_dp" readonly />

                <label>Frekuensi Angsuran</label>
                <select class="p-2 w-full border" v-model="formDummy.frekuensi_angsuran" @change="kalkulasiAngsuran">
                    <option :value="''">-- Pilih Frekuensi Angsuran --</option>
                    <option v-for="brg in frekuensiAngsuran" :key="brg.item" :value="brg.item">{{ brg.item }} Bulan</option>
                </select>

                <label>Angsuran Per Bulan</label>
                <input class="p-2 w-full border bg-slate-200" v-model="formDummy.angsuran_per_bulan" readonly />

                <button class="w-full bg-blue-700 text-white p-2 mt-4" @click="simpanTransaksi">Simpan untuk menerima permintaan</button>
                <button class="w-full bg-blue-900 text-white p-2 mt-4" @click="resetTransaksi">Reset</button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import axios from 'axios'

export default {
    mounted()
    {
        this.formReject.kd_transaksi_murabahah = this.$route.query.id
        this.formDummy.kd_transaksi_murabahah = this.$route.query.id

        axios.get('/api/bank/listJualBeliMurabahah/'+ this.$route.query.id).then(res => {
            // console.log(res.data)

            this.formTransaksi.kd_transaksi_murabahah   = res.data.data.kd_transaksi_murabahah
            this.formTransaksi.nama_permintaan          = res.data.data.nama_permintaan
            this.formTransaksi.status_admin_pembuat     = res.data.data.status_admin_pembuat
            this.formTransaksi.kd_cif                   = res.data.data.kd_cif,
            this.formTransaksi.deskripsi_permintaan     = res.data.data.deskripsi_permintaan
            this.formTransaksi.link_lampiran            = res.data.data.link_lampiran

            // console.log(this.formTransaksi)

            axios.get('/api/bank/listCIF/' + this.formTransaksi.kd_cif).then(res2 => {
                // console.log(res2.data)

                this.formTransaksi.nama_sesuai_identitas = res2.data.nama_sesuai_identitas
            })

        }).catch(err => {
            console.log(err)
        })
    },
    data() {
        return {
            frekuensiAngsuran : [
                { item: 2 },
                { item: 6 },
                { item: 12 }
            ],
            kdTransaksi     : '',
            formTransaksi   : {
                kd_transaksi_murabahah      : '',
                nama_permintaan             : '',
                status_admin_pembuat        : '',
                nama_sesuai_identitas       : '',
                deskripsi_permintaan        : '',
                link_lampiran               : ''
            },

            formReject      : {
                desc_penolakan              : '',
                kd_transaksi_murabahah      : ''
            },

            formDummy       : {
                kd_transaksi_murabahah      : '',
                nama_barang                 : '',
                harga_barang_satuan         : '',
                qty_barang                  : '',
                qty_type                    : 'qty',
                total_harga_barang          : '',
                frekuensi_angsuran          : '',
                surplus_untuk_bank          : '',
                total_biaya_akad_murabahah  : '',
                angsuran_per_bulan          : '',
                total_biaya_akad_margin     : '',
                total_biaya_setelah_dp      : ''
            },

            // formAccept      : {
            //     nama_barang                 : '',
            //     harga_barang_satuan         : '',
            //     qty_barang                  : '',
            //     qty_type                    : '',
            //     total_harga_barang          : '',
            //     frekuensi_angsuran          : '',
            //     surplus_untuk_bank          : '',
            //     total_biaya_akad_murabahah  : ''
            // },

            judulNavbar     : 'Verifikasi Transaksi',
            keputusan       : '',
        }
    },
    methods: {
        konfirmasi()
        {
            let konfirm = confirm("Apakah anda yakin untuk menolak permintaan ini ?")

            if(konfirm == true)
            {
                axios.put('/api/bank/tolakTransaksiMurabahah', this.formReject).then(konf => {
                    alert(konf.data.message)

                    return this.$router.push({name: 'JualBeliMurabahah'})
                })

                // console.log(this.formReject)
            } else if(konfirm == false)
            {
                // 
            }
        },
        kalkulasiTotalHargaBarang()
        {
            let hargabarang  = this.formDummy.harga_barang_satuan
            let satuanbarang = this.formDummy.qty_barang

            return this.formDummy.total_harga_barang = hargabarang * satuanbarang
        },
        kalkulasiSurplusBank()
        {
            let totalhargabarang    = parseInt(this.formDummy.total_harga_barang)
            let surplusbank         = parseInt(this.formDummy.surplus_untuk_bank)

            return this.formDummy.total_biaya_akad_murabahah = totalhargabarang + surplusbank
        },
        kalkulasiBiayaSetelahDP(){
            if(this.formDummy.total_biaya_akad_murabahah == 0 || this.formDummy.total_biaya_akad_murabahah == null)
            {
                return alert('Mohon diisi form sesuai urutan')
            }

            let totalbiayasblmdp          = parseInt(this.formDummy.total_biaya_akad_murabahah)
            let uangmuka                  = parseInt(this.formDummy.uang_muka)

            return this.formDummy.total_biaya_setelah_dp = totalbiayasblmdp - uangmuka

        },
        kalkulasiAngsuran()
        {
            let tbmurabahahsetelahdp = parseInt(this.formDummy.total_biaya_setelah_dp)
            let kuantitas            = parseInt(this.formDummy.frekuensi_angsuran)

            return this.formDummy.angsuran_per_bulan = tbmurabahahsetelahdp / kuantitas
        },
        resetTransaksi()
        {
            this.formDummy.nama_barang                 = ''
            this.formDummy.harga_barang_satuan         = ''
            this.formDummy.qty_barang                  = ''
            this.formDummy.qty_type                    = 'qty'
            this.formDummy.total_harga_barang          = ''
            this.formDummy.frekuensi_angsuran          = ''
            this.formDummy.surplus_untuk_bank          = ''
            this.formDummy.total_biaya_akad_murabahah  = ''
            this.formDummy.angsuran_per_bulan          = ''
            this.formDummy.uang_muka                   = ''
            this.formDummy.total_biaya_setelah_dp      = ''

            return true
        },
        simpanTransaksi()
        {
            let memastikan = confirm('Apakah anda yakin untuk menerima transaksi ini ?')

            if(memastikan == true)
            {
                axios.post('/api/bank/terimaTransaksiMurabahah', this.formDummy).then(hasilterima => {
                    console.log(hasilterima.data)

                    return alert(hasilterima.data.message)
                }).catch(hasilerror => {
                    console.log(hasilerror)
                    
                    alert('Server error')
                })
            } 
            else if(memastikan == false)
            {
                // 
            }
        }
    }
}
</script>
    