<template>

<div>
    <div class="p-3 bg-white border-t flex flex-row">
        <h1 class="text-2xl italic">{{ judulNavbar }}</h1>
    </div>
    <div class="p-2">
        <div class="grid grid-cols-2 gap-4 ml-4">
            <div>
                <div class="mb-2">
                    <p class="font-bold text-md mb-1">Nama Lengkap</p>
                    <p class="text-md pt-1 pb-1 pl-2 border">{{ dataCIF.nama_sesuai_identitas }}</p>
                </div>
                <div class="mb-2">
                    <p class="font-bold text-md mb-1">Kewarganegaraan</p>
                    <p class="text-md pt-1 pb-1 pl-2 border">{{ dataCIF.kewarganegaraan }}</p>
                </div>
                <div class="mb-2">
                    <p class="font-bold text-md mb-1">Kode Identitas</p>
                    <div class="flex">
                        <p class="text-md pt-1 pb-1 pl-2 pr-2 border bg-slate-200">{{ descJenisIdentitas(dataCIF.tipe_id) }} </p>
                        <p class="text-md pt-1 pb-1 pl-2 border w-full">{{ dataCIF.kd_identitas }}</p>
                    </div>
                </div>
                <div class="mb-2">
                    <p class="font-bold text-md mb-1">Alamat Sesuai Kartu Identitas</p>
                    <p class="text-md pt-1 pb-1 pl-2 border">{{ dataCIF.alamat_sekarang }}</p>
                </div>
                <div class="mb-2">
                    <p class="font-bold text-md mb-1">Kontak yang bisa dihubungi</p>
                    <div>
                        <div class="flex mb-2">
                            <p class="text-md pt-1 pb-1 pl-2 pr-2 border bg-slate-200">@</p>
                            <p class="text-md pt-1 pb-1 pl-2 border w-full">{{ dataCIF.email }}</p>
                        </div>
                        <div class="flex">
                            <p class="text-md pt-1 pb-1 pl-2 pr-2 border bg-slate-200">Telp</p>
                            <p class="text-md pt-1 pb-1 pl-2 border w-full">{{ dataCIF.no_telp }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div>
                    <p>Lorem</p>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import axios from 'axios';

export default {
    mounted() {
        axios.get('/api/bank/cariCIF/' + this.$route.query.id).then(hsl => {
            // console.log(hsl.data)
            this.dataCIF = hsl.data.data
            console.log(this.dataCIF)
        }).catch(err => {
            console.log(err.data)
        })
    },
    data() {
        return {
            judulNavbar : 'Detail CIF',
            dataCIF     : []
        }
    },
    methods: {
        descJenisIdentitas(jenis) {

            switch (jenis) {
                case 'ktp':
                    return 'KTP'
                    break;
                case 'ktm':
                    return 'KTM'
                    break;
                default: 

                break;
            }
        }
    }
}
</script>