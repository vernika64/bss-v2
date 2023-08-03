<template>

    <div>
        <div class="p-3 bg-white flex flex-row">
            <h1 class="text-2xl italic">List User</h1>
            <button class="p-2 text-white bg-blue-600 w-auto text-sm ml-4" @click="openModalAddUser = true">Tambah User baru</button>
        </div>
        <div class="p-2">
            <table class="border border-white w-full">
                <thead>
                    <tr>
                        <th class="p-4 bg-slate-500 text-slate-100 bold text-left w-[50px]">#</th>
                        <th class="p-4 bg-slate-500 text-slate-100 bold text-left">Username</th>
                        <th class="p-4 bg-slate-500 text-slate-100 bold text-left">Terdaftar di Bank</th>
                        <th class="p-4 bg-slate-500 text-slate-100 bold text-left">Role</th>
                        <!-- <th class="p-4 bg-slate-500 text-slate-100 bold text-center">Aksi</th> -->
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr v-for="(user, index) in listUser" :key="index" class="even:bg-slate-100 even:text-black hover:bg-slate-300">
                        <td class="text-center border border-white p-2">{{ index + 1 }}</td>
                        <td class="border border-white p-3">{{ user.fname }}</td>
                        <td class="border border-white p-3">{{ user.nama_bank }}</td>
                        <td class="border border-white p-3">{{ user.nama_role }}</td>
                        <!-- <td class="border border-white p-3 text-center">
                            <button class="bg-blue-500 p-2 inline-block text-white text-sm rounded-md mr-1 ml-1" @click="openModalUserDetails = true">
                                Detail
                            </button>
                        </td> -->
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Section for Add New User -->
    <Transition name="slide-fade">


        <div class="flex flex-col w-full h-full bg-slate-900 left-0 top-0 fixed bg-opacity-70 justify-center align-middle" v-if="openModalAddUser == true">
            
                <div class="relative bg-white rounded-lg p-4 m-auto md:w-1/2 2xl:w-1/2">
                    <div class="grid grid-rows-1">
                        <h1 class="text-2xl text-black mb-5">Tambah User Baru</h1>
                        <div class="grid grid-rows-1 mb-5">
                                <label class="text-black mb-2">Username</label>
                                <input type="text" class="border border-slate-400 bg-white pt-1 pb-1 pl-2 rounded-md h-[50px] mb-3" v-model="formTambahUser.username" placeholder="Username hanya bisa menggunakan satu kata tanpa spasi" />

                                <label class="text-black mb-2">Bank Tujuan</label>
                                <select class="border border-slate-400 bg-white pt-1 pb-1 pl-2 pr-2 rounded-md h-[50px] mb-3" v-model="formTambahUser.bankTujuan">
                                    <option :value="0">-- Pilih Bank Tujuan --</option>
                                    <option v-for="bnk in listBank" :key="bnk.kd_bank" :value="bnk.id">{{ bnk.kd_bank }} - {{ bnk.nama_bank }}</option>
                                </select>

                                <label class="text-black mb-2">Pekerjaan</label>
                                <select class="border border-slate-400 bg-white pt-1 pb-1 pl-2 rounded-md h-[50px] mb-3" v-model="formTambahUser.pekerjaan">
                                    <option :value="0">-- Pilih Pekerjaan --</option>
                                    <option v-for="pkj in listRole" :key="pkj.kd_role" :value="pkj.kd_role">{{ pkj.nama_role }}</option>
                                </select>

                                <p class="text-red-600 text-justify">PERHATIAN! username dan password yang digunakan untuk login akun ini menggunakan nama username saja tanpa menggunakan huruf kapital.</p>

                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <button class="bg-slate-300 text-black p-2 rounded-md" @click="openModalAddUser = false">Tutup</button>
                            <button class="bg-blue-600 text-white p-2 rounded-md" @click="simpanUserBaru">Simpan</button>
                        </div>
                    </div>
                </div>
            
        </div>
    </Transition>
    
    <!-- Modal Section for User Details -->
    <Transition name="slide-fade">
        <div class="flex flex-col w-full h-full bg-slate-900 left-0 top-0 fixed bg-opacity-70 justify-center align-middle" v-if="openModalUserDetails == true">
            <!-- Modal Content -->
            
                <div class="relative bg-white rounded-lg m-auto w-[1000px] shadow">
                    <div class="grid grid-rows-1">
                        <h1 class="text-2xl text-black mb-2 border-b p-4">Detail User</h1>
                        <div class="grid gap-2 mb-2 pl-4 pr-4">
                                <label class="font-bold text-black">Username</label>
                                <input type="text" class="border shadow border-slate-300 bg-white p-2 rounded-md" v-model="formTambahUser.username" placeholder="Username" />
                        </div>
                        <div class="grid gap-2 mb-2 pl-4 pr-4">
                                <label class="font-bold text-black">Terdaftar di Bank</label>
                                <input type="text" class="border shadow border-slate-300 bg-white p-2 rounded-md" v-model="formTambahUser.username" placeholder="Username" />
                        </div>
                        <div class="grid gap-2 mb-2 pl-4 pr-4">
                                <label class="font-bold text-black">Pekerjaan</label>
                                <input type="text" class="border shadow border-slate-300 bg-white p-2 rounded-md" v-model="formTambahUser.username" placeholder="Username" />
                        </div>
                        <div class="grid grid-cols-3 gap-2 p-4 text-white">
                            <button class="bg-blue-900 p-2">Satu</button>
                            <button class="bg-red-900 p-2">Dua</button>
                            <button class="bg-yellow-500 p-2">Tiga</button>
                        </div>
                        <div class="grid grid-cols-2 gap-4 p-4">
                            <button class="bg-slate-300 text-black p-2 rounded-md" @click="openModalUserDetails = false">Tutup</button>
                            <button class="bg-blue-600 text-white p-2 rounded-md" @click="simpanUserBaru">Simpan</button>
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
            // console.log(this.listRole)
        })


    },
    data() {
        return {
            listUser                : [],
            listBank                : [],
            listRole                : [],
            openModalAddUser        : '',
            openModalUserDetails    : '',
            jenisPekerjaan          : [
                { kd_pekerjaan: 'office', nama_pekerjaan: 'Office Serbaguna'},
                { kd_pekerjaan: 'cservice', nama_pekerjaan: 'Customer Service'},
            ],
            formTambahUser      : {
                username    : '',
                bankTujuan  : 0,
                pekerjaan   : 0
            },
            dataUserDetail      : {
                username    : '',
                fname       : '',
                role        : '',
                bank        : ''
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
                alert(qry.data.message)
                return location.reload()
            }).catch(errors => {
                return alert(errors.data.message)
            })
        },
        cariDataUser($kduser) {
            
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