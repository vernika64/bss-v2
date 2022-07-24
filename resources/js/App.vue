<template>
    <template v-if="this.$route.name == 'SuperLogin' || this.$route.name == 'BankingLogin'">
        <router-view />
    </template>
    <template v-else-if="this.$route.name == 'PekoNotFound'">
        <router-view />
    </template>
    <template v-else>
        <div class="flex">
            <div class="bg-sidebar text-white w-[300px]">
                <ul class="grid gap-4 pr-5 pl-5">
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
                        <router-link :to="{ name: ''}" class="flex">
                            <document-report-icon class="h-7 w-7 mr-3" /> Laporan <p class="ml-2 bg-white text-black rounded-sm italic">(experimental)</p>
                        </router-link>
                    </li>
                    <li class="bg-slate-900 p-4 rounded-md ">
                        <router-link :to="{ name: 'DevelopmentArea'}" class="flex">
                            <code-icon class="h-7 w-7 mr-3" /> Development Area
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
                <div class="bg-slate-200">
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
import { HomeIcon, IdentificationIcon, OfficeBuildingIcon, DocumentReportIcon, UsersIcon, CodeIcon } from '@heroicons/vue/solid'
import { LogoutIcon } from '@heroicons/vue/outline'

export default {

    name: "App",
    
    components: { 
        HomeIcon, 
        IdentificationIcon, 
        OfficeBuildingIcon, 
        DocumentReportIcon,
        LogoutIcon,
        UsersIcon,
        CodeIcon
        },
    mounted() {
        var tgl = new Date()

        this.tanggal = tgl.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric'})
        
        if(localStorage.getItem('uname') != null)
        {
            this.userCpanel = localStorage.getItem('uname')
        }
    },
    data()
    {
        return {
            tanggal: '',
            userCpanel: 'User'
        }
    },
    methods: {
        logout() {
            axios.get('/api/super/keluar').then(out => {
                console.log('Logout berhasil')
                console.log(out.data)
                return router.push({name: 'BankingLogin'})
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