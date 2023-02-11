<template>
<div>
    <div class="p-3 bg-white flex flex-row">
        <h1 class="text-2xl italic">List Pekerjaan</h1>
        <!-- <button class="p-2 text-white bg-blue-600 w-auto text-sm ml-4" @click="openModalAddJobs = true">Tambah Pekerjaan Baru</button> -->
    </div>
    <div class="p-2">
        <div>
            <table class="border border-white w-full">
                <thead class="bg-slate-500 text-white">
                    <tr>
                        <th class="p-4 bold font-md text-left font-semibold w-[50px]">No.#</th>
                        <th class="p-4 bold font-md text-left font-semibold">Nama Pekerjaan</th>
                        <th class="p-4 bold font-md text-center font-semibold w-[100px]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr v-for="(bk, index) in tabelPekerjaan" :key="index" class="even:bg-slate-200 even:text-black border ">
                        <td class="border border-white text-center p-3">{{ index + 1 }}</td> 
                        <td class="border border-white p-3">{{ bk.nama_role }}</td>
                        <td class="border border-white p-3 text-center">
                            <router-link :to="''" class="p-2 bg-red-600 text-white rounded-md text-sm ">Hapus</router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</template>

<script>
import axios from 'axios'

export default {

    mounted() {
        axios.get('/api/super/roleList').then(res => {
            console.log(res.data)
            this.tabelPekerjaan = res.data.data
        }).catch(err => {
            console.log(err)
        })
    },
    data() {
        return {
            openModalAddJobs: '',
            tabelPekerjaan : []
        }
    }
}
</script>