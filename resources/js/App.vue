<template>
    <template v-if="this.$route.name == 'SuperLogin' || this.$route.name == 'BankingLogin'">
        <router-view />
    </template>
    <template v-else-if="this.$route.name == 'PekoNotFound'">
        <router-view />
    </template>
    <template v-else>
        <div class="flex">
            <div class="bg-sidebar text-white w-[300px] bg-fixed">
                <ul class="grid gap-4 pr-5 pl-5" v-if="userRole == 'admin'">
                    <li class="mb-4 mt-4 ml-6 italic text-lg bg-">Syariah Multi</li>
                    <li class="bg-slate-900 p-4 rounded-md ">
                        <router-link :to="{ name: 'SuperDashboard'}" class="flex">
                        <home-icon class="h-7 w-7 mr-3" />Dashboard
                        </router-link>
                    </li>
                    <li class="bg-slate-900 p-4 rounded-md ">
                        <router-link :to="{ name: 'SuperBank'}" class="flex">
                            <office-building-icon class="h-7 w-7 mr-3" /> Bank
                        </router-link>
                        </li>
                    <li class="bg-slate-900 p-4 rounded-md ">
                        <router-link :to="{ name: 'SuperUser'}" class="flex">
                            <identification-icon class="h-7 w-7 mr-3" /> Users
                        </router-link>
                    </li>
                    <li class="bg-slate-900 p-4 rounded-md ">
                        <router-link :to="{ name: 'SuperPekerjaan'}" class="flex">
                            <users-icon class="h-7 w-7 mr-3" /> Pekerjaan
                        </router-link>
                    </li>
                    <li class="bg-slate-900 p-4 rounded-md ">
                        <router-link :to="{ name: 'SuperAkunAkuntansi'}" class="flex">
                            <book-open-icon class="h-7 w-7 mr-3" /> Buku Akuntansi
                        </router-link>
                    </li>
                    <!-- <li class="bg-slate-900 p-4 rounded-md ">
                        <router-link :to="{ name: ''}" class="flex">
                            <document-report-icon class="h-7 w-7 mr-3" /> Laporan <p class="ml-2 bg-white text-black rounded-sm italic">(experimental)</p>
                        </router-link>
                    </li> -->
                    <li class="bg-slate-900 p-4 rounded-md ">
                        <router-link :to="{ name: 'DevelopmentArea'}" class="flex">
                            <code-icon class="h-7 w-7 mr-3" /> Development Area
                        </router-link>
                    </li>
                    <li class="bg-slate-900 p-4 rounded-md ">
                        <button @click="logout" class="flex"><logout-icon class="h-7 w-7 mr-3"/>Logout</button>
                    </li>
                </ul>

                <!-- Untuk user dengan role office -->

                <ul class="grid gap-4 pr-5 pl-5" v-else-if="userRole == 'office'">
                    <li class="mb-4 mt-4 ml-6 italic text-lg bg-">Syariah Multi</li>
                    <li class="bg-slate-900 p-4 rounded-md ">
                        <router-link :to="{ name: 'BankingDashboard'}" class="flex">
                        <home-icon class="h-7 w-7 mr-3" />Dashboard
                        </router-link>
                    </li>
                    <li class="bg-slate-900 p-4 rounded-md ">
                        <router-link :to="{ name: 'CIF' }" class="flex">
                        <users-icon class="h-7 w-7 mr-3" />Customer Identification File
                        </router-link>
                    </li>
                    <li class="bg-slate-900 p-4 rounded-md ">
                        <router-link :to="{ name: 'Tabungan' }" class="flex">
                        <home-icon class="h-7 w-7 mr-3" />Tabungan Wadiah
                        </router-link>
                    </li>
                    <li class="bg-slate-900 p-4 rounded-md ">
                        <router-link :to="{ name: 'TabunganTarikSetorTunai' }" class="flex">
                        <home-icon class="h-7 w-7 mr-3" />Tarik / Setor Tunai
                        </router-link>
                    </li>
                    <li class="bg-slate-900 p-4 rounded-md ">
                        <router-link :to="{ name: 'JualBeliMurabahah' }" class="flex">
                        <view-grid-icon class="h-7 w-7 mr-3" />Jual Beli Murabahah
                        </router-link>
                    </li>
                    <li class="bg-slate-900 p-4 rounded-md ">
                        <router-link :to="{ name: 'PermintaanBarangMurabahah' }" class="flex">
                        <view-grid-icon class="h-7 w-7 mr-3" />Aset Jual Beli Murabahah
                        </router-link>
                    </li>
                    <li class="bg-slate-900 p-4 rounded-md ">
                        <router-link :to="{ name: 'AngsuranMurabahah' }" class="flex">
                        <view-grid-icon class="h-7 w-7 mr-3" />Angsur Jual Beli Murabahah
                        </router-link>
                    </li>
                    <li class="bg-slate-900 p-4 rounded-md ">
                        <router-link :to="{ name: 'DaftarJurnalUmum'}" class="flex">
                        <book-open-icon class="h-7 w-7 mr-3" />Jurnal Umum
                        </router-link>
                    </li>
                    <li class="bg-slate-900 p-4 rounded-md ">
                        <button @click="logout" class="flex"><logout-icon class="h-7 w-7 mr-3"/>Logout</button>
                    </li>
                </ul>
            </div>
            <div class="flex-1">
                <div class="grid grid-cols-5 bg-white text-black w-full">
                    <div class="col-span-4 p-4">
                        <h1>{{ tanggal }}</h1>
                    </div>
                    <div class="p-4 text-right">
                        <div>
                            <h1>{{ userCpanel }}</h1>
                        </div>
                    </div>
                </div>
                <div class="bg-white">
                    <div class="h-screen">
                        <router-view />
                    </div>
                </div>
            </div>
        </div>
    </template>
</template>

<script>
import axios from 'axios'
import router from './routes/router'
import { HomeIcon, IdentificationIcon, OfficeBuildingIcon, DocumentReportIcon, UsersIcon, CodeIcon, BookOpenIcon } from '@heroicons/vue/solid'
import { LogoutIcon, ViewGridIcon } from '@heroicons/vue/outline'

export default {

    name: "App",
    
    components: { 
        HomeIcon, 
        IdentificationIcon, 
        OfficeBuildingIcon, 
        DocumentReportIcon,
        LogoutIcon,
        UsersIcon,
        CodeIcon,
        BookOpenIcon,
        ViewGridIcon
        },
    mounted() {
        var tgl = new Date()

        this.tanggal = tgl.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric'})
        
        this.userCpanel = localStorage.getItem('uname')

        axios.get('/api/super/tknCheck').then(loggedin => {
            this.userRole = loggedin.data.role
        })
    },
    data()
    {
        return {
            tanggal         : '',
            userCpanel      : 'User',
            userRole        : ''
        }
    },
    methods: {
        logout() {
            axios.get('/api/super/keluar').then(out => {
                console.log('Logout berhasil')
                console.log(out.data)

                this.userCpanel = ''
                this.userRole   = ''
                return router.go({name: 'BankingLogin'})
            }).catch(out_err => {
                console.log('Logout Error')
                console.log(out_err.data)
            })
        }
    }
}
</script>

<style>
/*  */

/* .bg-sidebar {
    background-color: #1b213d;
}
.bg-content {
    background-color: #151934;
}
.bg-navbar {
    background-color: #1c2340;
} */
</style>