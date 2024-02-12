<template>
    <div v-if="this.$route.name == 'SuperLogin' || this.$route.name == 'BankingLogin'">
        <router-view />
    </div>
    <div v-else-if="this.$route.name == 'PekoNotFound'">
        <router-view />
    </div>
    <div v-else>
        <div class="flex h-full">
            <div class="bg-pikisuperstars-circle bg-left text-white md:w-[30%] lg:w-[18%] bg-fixed h-full overflow-auto">
                <router-view name="sidebar"></router-view>
            </div>
            <div class="flex-1 h-full overflow-auto">
                <div class="grid grid-cols-5 bg-white text-black w-full border-b">
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
                    <router-view />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
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
        var tgl = new Date();

        this.tanggal = tgl.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

        this.userCpanel = localStorage.getItem('uname');

        axios.get('/api/super/tknCheck').then(loggedin => {
            this.userRole = loggedin.data.role;
        });
    },
    data() {
        return {
            tanggal         : '',
            userCpanel      : 'User',
            userRole        : '',
            menuAdmin: {
                menuDashboard   : false,
                menuBank        : false,
                menuUser        : false,
                menuPekerjaan   : false,
                menuBkAkuntansi : false,
                menuDevArea     : false
            },
        }
    },
    methods: {
        // 
    }
}
</script>