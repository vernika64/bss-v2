<template>
    <ul class="grid gap-4 pr-5 pl-5">
        <li class="italic text-xl pb-4 pt-4 mt-2 text-center">
            {{ sidebarName }}
        </li>
        <li class="bg-slate-900 p-4 rounded-md focus:bg-content">
            <router-link :to="{ name: 'SuperDashboard' }" class="flex">
                <home-icon class="h-7 w-7 mr-3" />Dashboard
            </router-link>
        </li>
        <li class="bg-slate-900 p-4 rounded-md focus:bg-blue-500">
            <router-link :to="{ name: 'SuperBank' }" class="flex">
                <office-building-icon class="h-7 w-7 mr-3" /> Bank
            </router-link>
        </li>
        <li class="bg-slate-900 p-4 rounded-md ">
            <router-link :to="{ name: 'SuperUser' }" class="flex">
                <identification-icon class="h-7 w-7 mr-3" /> Users
            </router-link>
        </li>
        <li class="bg-slate-900 p-4 rounded-md ">
            <router-link :to="{ name: 'SuperPekerjaan' }" class="flex">
                <users-icon class="h-7 w-7 mr-3" /> Pekerjaan
            </router-link>
        </li>
        <li class="bg-slate-900 p-4 rounded-md ">
            <router-link :to="{ name: 'SuperAkunAkuntansi' }" class="flex">
                <book-open-icon class="h-7 w-7 mr-3" /> Buku Akuntansi
            </router-link>
        </li>
        <!-- <li class="bg-slate-900 p-4 rounded-md ">
            <router-link :to="{ name: ''}" class="flex">
                <document-report-icon class="h-7 w-7 mr-3" /> Laporan <p class="ml-2 bg-white text-black rounded-sm italic">(experimental)</p>
            </router-link>
        </li> -->
        <li class="bg-slate-900 p-4 rounded-md ">
            <router-link :to="{ name: 'DevelopmentArea' }" class="flex">
                <code-icon class="h-7 w-7 mr-3" /> Development Area
            </router-link>
        </li>
        <li class="bg-slate-900 p-4 rounded-md ">
            <button @click="logout" class="flex"><logout-icon class="h-7 w-7 mr-3" />Logout</button>
        </li>
    </ul>
</template>

<script>
import axios from 'axios'
import { HomeIcon, IdentificationIcon, OfficeBuildingIcon, DocumentReportIcon, UsersIcon, CodeIcon, BookOpenIcon } from '@heroicons/vue/solid'
import { LogoutIcon, ViewGridIcon } from '@heroicons/vue/outline'

export default {
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
    data() {
        return {
            sidebarName : 'Adil Mini Bank System'
        }
    },
    methods: {
        logout() {
            axios.get('/api/super/keluar').then(out => {
                localStorage.removeItem('uname')
                return this.$router.push({ name: 'BankingLogin' })
            }).catch(out_err => {
                console.log(out_err.data)
            })
        }
    }
}
</script>