<template>
<div class="grid grid-rows-1 ml-2 mr-2">
    <h1 class="text-2xl mb-4">Grup</h1>
    <div class="flex flex-row gap-2">
        <button class="p-2 text-white bg-black w-auto text-sm" @click="openModalAddGrup = true">Tambah Grup Baru</button>
    </div>
    <div>
        <table class="border-collapse mt-4 w-[1000px]">
            <thead>
                <tr>
                    <th class="p-4 bg-slate-500 text-slate-100 bold">No.#</th>
                    <th class="p-4 bg-slate-500 text-slate-100 bold">Kd. Grup</th>
                    <th class="p-4 bg-slate-500 text-slate-100 bold">Nama Grup</th>
                    <th class="p-4 bg-slate-500 text-slate-100 bold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(tab, index) in isiTabel" :key="index">
                    <td class="text-center p-2">{{ index }}</td>
                    <td class="text-center p-2">{{ tab.kd_grup }}</td>
                    <td>{{ tab.nama_grup}}</td>
                    <td class="text-center p-2"><button class="p-2 bg-blue-600 text-white">Primary</button></td>
                </tr>
            </tbody>
        </table>

    </div>

    <!-- Modal Section -->
    <div class="w-full h-full overflow-auto bg-slate-900 left-0 top-0 fixed bg-opacity-70" v-if="openModalAddGrup == true">
        <!-- Modal Content -->
        <div class="flex justify-center">
            <div class="bg-white w-[1000px] p-4 mt-[200px] rounded-lg">
                <div class="grid grid-rows-1">
                    <h1 class="text-2xl text-black mb-10">Tambah Grup</h1>
                    <div class="grid grid-cols-4 gap-2 mb-10">
                        <div class="grid grid-rows-1">
                            <label class="font-bold text-black">Kode Grup</label>
                            <input type="text" class="border border-slate-500 bg-white p-1" placeholder="Contoh: KEU" v-model="isiFormGrup.kdgrup" />
                        </div>
                        <div class="grid grid-rows-1 col-span-3">
                            <label class="font-bold text-black">Nomor Identitas</label>
                            <input type="text" class="border border-slate-500 bg-white p-1" placeholder="Nama Grup" v-model="isiFormGrup.namagrup" />
                        </div>
                        <div class="grid grid-rows-1 col-span-4">
                            <label class="font-bold text-black">Deskripsi Grup</label>
                            <textarea class="border border-slate-500 bg-white p-1" placeholder="(Opsional) Deskripsi Grup yang diisi" v-model="isiFormGrup.descgrup"></textarea>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <button class="bg-slate-300 text-black p-2 rounded-md" @click="openModalAddGrup = false">Tutup</button>
                        <button class="bg-blue-600 text-white p-2 rounded-md" @click="tambahGrup">Simpan</button>
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
        axios.get('/api/super/groupList').then(res => {
            this.isiTabel = res.data.data
            console.log(this.isiTabel)
        }).catch(err => {
            alert('Mohon maaf, server sedang mengalami gangguan, mohon untuk menghubungi Web Administrator')
        })
    },
    data() {
        return {
            isiTabel: [],
            isiFormGrup: {
                kdgrup      : '',
                namagrup    : '',
                descgrup    : ''
            },
            openModalAddGrup: false
        }
    },
    methods: {
        tambahGrup() {

            const $grupData = {
                kodegrup        : this.isiFormGrup.kdgrup,
                namagrup        : this.isiFormGrup.namagrup,
                descgrup        : this.isiFormGrup.descgrup
            }

            axios.post('/api/super/addNewGroup', $grupData).then(res2 => {
                console.log(res2.data.status)
                alert(res2.data.status)
            })
        }
    }
}
</script>