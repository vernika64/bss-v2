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
                    <p class="text-md text-justify overflow-auto">{{ formTransaksi.deskripsi_permintaan }}</p>
                </div>
                <div>
                    <label class="font-bold">Aksi</label>
                    <select class="w-full border p-2" v-model="keputusan">
                        <option :value="''">-- Pilih Opsi --</option>
                        <option :value="'terima'">Terima</option>
                        <option :value="'tolak'">Tolak</option>
                    </select>
                </div>
                <div>
                    <button class="bg-red-700 text-white w-full p-2" v-if="keputusan == 'tolak'" @click="konfirmasi">Simpan untuk menolak permintaan</button>
                </div>
                
            </div>
            <div class="bg-white border p-4 m-2" v-if="keputusan == 'terima'">
                <label>Nama Barang</label>
                <input type="text" class="p-2 w-full border" />
                <label>Harga barang</label>
                <input type="text" class="w-full p-2 border" />
                <label>Frekuensi Angsuran</label>
                <select class="p-2 w-full border">
                    <option>-- Pilih Frekuensi Angsuran --</option>
                    <option>2 Bulan</option>
                    <option>6 Bulan</option>
                    <option>12 Bulan</option>
                </select>
                <label>Surplus untuk Bank</label>
                <input type="text" class="p-2 w-full border" />
                <label>Total Biaya Jual Beli Akad Murabahah</label>
                <input type="text" class="p-2 w-full border" disabled />
                <button class="w-full bg-blue-700 text-white p-2 mt-4">Simpan untuk menerima permintaan</button>
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
        axios.get('/api/bank/listJualBeliMurabahah/'+ this.$route.query.id).then(res => {
            console.log(res.data)

            this.formTransaksi.kd_transaksi_murabahah   = res.data.data.kd_transaksi_murabahah
            this.formTransaksi.nama_permintaan          = res.data.data.nama_permintaan
            this.formTransaksi.status_admin_pembuat     = res.data.data.status_admin_pembuat
            this.formTransaksi.kd_cif                   = res.data.data.kd_cif,
            this.formTransaksi.deskripsi_permintaan     = res.data.data.deskripsi_permintaan

            console.log(this.formTransaksi)

            axios.get('/api/bank/listCIF/' + this.formTransaksi.kd_cif).then(res2 => {
                console.log(res2.data)

                this.formTransaksi.nama_sesuai_identitas = res2.data.nama_sesuai_identitas
            })

        }).catch(err => {
            console.log(err)
        })
    },
    data() {
        return {
            kdTransaksi     : '',
            formTransaksi   : {
                kd_transaksi_murabahah      : '',
                nama_permintaan             : '',
                status_admin_pembuat        : '',
                nama_sesuai_identitas       : '',
                deskripsi_permintaan        : '',
            },
            judulNavbar     : 'Verifikasi Transaksi',
            keputusan       : '',
        }
    },
    methods: {
        konfirmasi()
        {
            let konfirm = confirm("Apakah anda yakin untuk menolak permintaan ini ?")

            console.log(konfirm)
        }
    }
}
</script>
    