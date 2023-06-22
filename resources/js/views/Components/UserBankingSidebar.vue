<template>

    <ul class="grid gap-4 pr-5 pl-5">
        <li class="mb-4 mt-4 ml-6 italic text-lg bg-">Syariah Multi</li>
        <li class="bg-slate-900 p-4 rounded-md " :class="['BankingDashboard' == this.$route.name ? activeSidebar : deactiveSidebar]">
            <router-link :to="{ name: 'BankingDashboard' }" class="flex">
                <home-icon class="h-7 w-7 mr-3" />Dashboard
            </router-link>
        </li>
        <li class="bg-slate-900 p-4 rounded-md " :class="['CIF' == this.$route.name || 'CIFAdd' == this.$route.name ? activeSidebar : deactiveSidebar]">
            <router-link :to="{ name: 'CIF' }" class="flex">
                <users-icon class="h-7 w-7 mr-3" />Customer Identification File
            </router-link>
        </li>
        <li class="bg-slate-900 p-4 rounded-md " :class="['Tabungan' == this.$route.name ? activeSidebar : deactiveSidebar]">
            <router-link :to="{ name: 'Tabungan' }" class="flex">
                <credit-card-icon class="h-7 w-7 mr-3" />Tabungan Wadiah
            </router-link>
        </li>
        <li class="bg-slate-900 p-4 rounded-md " :class="['TabunganTarikSetorTunai' == this.$route.name ? activeSidebar : deactiveSidebar]">
            <router-link :to="{ name: 'TabunganTarikSetorTunai' }" class="flex">
                <currency-dollar-icon class="h-7 w-7 mr-3" />Tarik / Setor Tunai
            </router-link>
        </li>
        <li class="bg-slate-900 p-4 rounded-md " :class="['JualBeliMurabahah' == this.$route.name ? activeSidebar : deactiveSidebar]">
            <router-link :to="{ name: 'JualBeliMurabahah' }" class="flex">
                <view-grid-icon class="h-7 w-7 mr-3" />Jual Beli Murabahah
            </router-link>
        </li>
        <li class="bg-slate-900 p-4 rounded-md " :class="['PermintaanBarangMurabahah' == this.$route.name ? activeSidebar : deactiveSidebar]">
            <router-link :to="{ name: 'PermintaanBarangMurabahah' }" class="flex">
                <view-grid-icon class="h-7 w-7 mr-3" />Aset Jual Beli Murabahah
            </router-link>
        </li>
        <li class="bg-slate-900 p-4 rounded-md " :class="['AngsuranMurabahah' == this.$route.name ? activeSidebar : deactiveSidebar]">
            <router-link :to="{ name: 'AngsuranMurabahah' }" class="flex">
                <view-grid-icon class="h-7 w-7 mr-3" />Angsur Jual Beli Murabahah
            </router-link>
        </li>
        <li class="bg-slate-900 p-4 rounded-md " :class="['DaftarJurnalUmum' == this.$route.name ? activeSidebar : deactiveSidebar]">
            <router-link :to="{ name: 'DaftarJurnalUmum' }" class="flex">
                <book-open-icon class="h-7 w-7 mr-3" />Jurnal Umum
            </router-link>
        </li>
        <li class="bg-slate-900 p-4 rounded-md ">
            <button @click="logout()" class="flex"><logout-icon class="h-7 w-7 mr-3" />Logout</button>
        </li>
    </ul>
    <!-- <ul class="grid pr-5 pl-5" v-for="itm in sidebarItems">
        <li class="p-4 rounded-md mt-4" :class="[itm.sidebarUrl == this.$route.name ? activeSidebar : deactiveSidebar]">
            <router-link :to="{ name: itm.sidebarUrl }" class="flex">
                <home-icon class="h-7 w-7 mr-3" />
                {{ itm.sidebarName }}
            </router-link>
        </li>
    </ul> -->

</template>

<script>

import axios from 'axios'
import { HomeIcon, IdentificationIcon, OfficeBuildingIcon, DocumentReportIcon, UsersIcon, CodeIcon, BookOpenIcon, CreditCardIcon, CurrencyDollarIcon } from '@heroicons/vue/solid'
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
        ViewGridIcon,
        CreditCardIcon,
        CurrencyDollarIcon
    },
    mounted() {
        console.log(this.sidebarItems)
    },
    methods: {
        logout() {
            axios.get('/api/super/keluar').then(out => {
                console.log(out.data)
                localStorage.removeItem('uname')
                localStorage.removeItem('user')
                return this.$router.push({ name: 'BankingLogin' })
            }).catch(out_err => {
                console.log(out_err.data)
            })
        },
        linkSidebar(sidebarLink) {
            var routerName  = this.$route.name
        }
    },
    data() {
        return {
            activeSidebar   : 'bg-blue-800',
            deactiveSidebar : 'bg-slate-900',
            sidebarItems    : [
                {
                    sidebarName     : 'Dashboard',
                    sidebarUrl      : 'BankingDashboard',
                    sidebarStatus   : false
                },
                {
                    sidebarName     : 'Customer Identification File',
                    sidebarUrl      : 'CIF',
                    sidebarStatus   : false
                },
                {
                    sidebarName     : 'Tabungan Wadiah',
                    sidebarUrl      : 'Tabungan',
                    sidebarStatus   : false
                },
                {
                    sidebarName     : 'Jual Beli Murabahah',
                    sidebarUrl      : 'JualBeliMurabahah',
                    sidebarStatus   : false
                },
                {
                    sidebarName     : 'Barang u/ Murabahah',
                    sidebarUrl      : 'PermintaanBarangMurabahah',
                    sidebarStatus   : false
                },
                {
                    sidebarName     : 'Angsuran Murabahah',
                    sidebarUrl      : 'AngsuranMurabahah',
                    sidebarStatus   : false
                },
                {
                    sidebarName     : 'Akuntansi Perbankan',
                    sidebarUrl      : 'DaftarJurnalUmum',
                    sidebarStatus   : false
                }
            ]
        }
    }
}
</script>