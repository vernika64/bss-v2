<template>

    <div class="grid grid-rows-1 ml-2 mr-2">
        <h1 class="text-2xl mb-4">List User untuk Bank</h1>
        <div class="flex flex-row gap-2">
            <button class="p-2 text-white bg-black w-auto text-sm" @click="openModalAddUser = true">Tambah User baru</button>
        </div>
        <div>
            <table class="border-collapse mt-4 w-full">
                <thead>
                    <tr>
                        <th class="p-4 bg-slate-500 text-slate-100 bold text-left w-[50px]">#</th>
                        <th class="p-4 bg-slate-500 text-slate-100 bold text-left">Username</th>
                        <th class="p-4 bg-slate-500 text-slate-100 bold text-left">Terdaftar di Bank</th>
                        <th class="p-4 bg-slate-500 text-slate-100 bold text-left">Role</th>
                        <th class="p-4 bg-slate-500 text-slate-100 bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr v-for="(user, index) in listUser" :key="index" class="even:bg-slate-100 even:text-black hover:bg-slate-300">
                       <td class="text-center border border-white p-2">{{ index + 1 }}</td>
                       <td class="border border-white p-3">{{ user.username }}</td>
                       <td class="border border-white p-3">{{ user.nama_bank }}</td>
                       <td class="border border-white p-3">{{ user.nama_role }}</td>
                       <td class="border border-white p-3 text-center"><router-link class="bg-blue-500 p-2 text-white text-sm rounded-md" :to="''">Details</router-link></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Section -->
    <Transition name="slide-fade">
        <div class="w-full h-full overflow-auto bg-slate-900 left-0 top-0 fixed bg-opacity-70" v-if="openModalAddUser == true">
            <!-- Modal Content -->
            <div class="flex justify-center">
                <div class="bg-white w-[1000px] p-4 mt-[200px] rounded-lg">
                    <div class="grid grid-rows-1">
                        <h1 class="text-2xl text-black mb-10">Tambah Bank Baru</h1>
                        <div class="grid grid-rows-1 gap-2 mb-10">
                            <label class="font-bold text-black">Username</label>
                                <input type="text" class="border border-slate-500 bg-white p-1" v-model="formTambahUser.username" placeholder="username menggunakan huruf kecil" />
                            <label class="font-bold text-black">Bank Tujuan</label>
                                <select class="border border-slate-500 bg-white p-1" v-model="formTambahUser.bankTujuan">
                                    <option :value="0">-- Pilih Bank Tujuan --</option>
                                    <option v-for="bnk in listBank" :key="bnk.kd_bank" :value="bnk.kd_bank">{{ bnk.kd_bank }} - {{ bnk.nama_bank }}</option>
                                </select>
                            <label class="font-bold text-black">Pekerjaan</label>
                                <select class="border border-slate-500 bg-white p-1" v-model="formTambahUser.pekerjaan">
                                    <option :value="0">-- Pilih Pekerjaan --</option>
                                    <option v-for="pkj in listRole" :key="pkj.kd_role" :value="pkj.kd_role">{{ pkj.nama_role }}</option>
                                </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <button class="bg-slate-300 text-black p-2 rounded-md" @click="openModalAddUser = false">Tutup</button>
                            <button class="bg-blue-600 text-white p-2 rounded-md" @click="simpanUserBaru">Simpan</button>
                        </div>
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
        
        axios.get('/api/super/bankList').then(hsl => {
            this.listBank = hsl.data.data
            // console.log(this.listBank)
        }).catch(err => {
            console.log('Server Error')
        })

        axios.get('/api/super/memberList').then(hsl2 => {
            this.listUser = hsl2.data.data
            // console.log(this.listUser)
        }).catch(err => {
            console.log('Server Error')
        })

        axios.get('/api/super/roleList').then(hsl3 => {
            this.listRole = hsl3.data.data
            console.log(this.listRole)
        })


    },
    data() {
        return {
            listUser            : [],
            listBank            : [],
            listRole            : [],
            openModalAddUser    : '',
            jenisPekerjaan      : [
                { kd_pekerjaan: 'office', nama_pekerjaan: 'Office Serbaguna'},
                { kd_pekerjaan: 'cservice', nama_pekerjaan: 'Customer Service'},
            ],
            formTambahUser      : {
                username    : '',
                bankTujuan  : 0,
                pekerjaan   : 0
            }
        }
    },
    methods: {
        simpanUserBaru() {
            // console.log(this.formTambahUser)

            const dataUserBaru = {
                username        : this.formTambahUser.username,
                bankTujuan      : this.formTambahUser.bankTujuan,
                pekerjaan       : this.formTambahUser.pekerjaan
            }

            axios.post('/api/super/addNewMember', dataUserBaru).then(qry => {
                console.log(qry.data)
                alert(qry.data.status)
                location.reload()
            })
        }
    }
}
</script>

<style>
.slide-fade-enter-active {
  transition: all 0.1s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.1s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  /* transform: translateX(20px); */
  opacity: 0;
}
</style>