<template>
<div class="grid grid-rows-1 ml-2 mr-2">
    <h1 class="text-2xl mb-[20px]">Tambah Data Mahasiswa</h1>
    <form class="flex flex-col gap-2">
        <div>
            <vSelect label="nama" :options="jenisKartu" class="border border-slate-500" v-model="formMahasiswa.kd_id" v-on:change="tesSelect" />
        </div>
    </form>
</div>
</template>

<script>
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'

export default {
    components: {
        vSelect
    },
    data() {
        return {
            formMahasiswa: {
                kd_id           : '',
                uid             : '',
                nama_lengkap    : '',
                kd_grup         : ''
            },
            jenisKartu: [
                { kode: 'KTP', nama: 'Kartu Tanda Penduduk'},
                { kode: 'KTM', nama: 'Kartu Tanda Mahasiswa'},
            ]
        }
    },
    methods: {
        tesSelect() {
            console.log(this.formMahasiswa.kd_id)
        }
    }
}
</script>