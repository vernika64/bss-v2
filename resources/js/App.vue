<template>
    <template v-if="this.$route.name == 'SuperLogin' || this.$route.name == 'BankingLogin'">
        <router-view />
    </template>
    <template v-else-if="this.$route.name == 'PekoNotFound'">
        <router-view />
    </template>
    <template v-else>
        <div class="grid grid-cols-4">
            <div class="">
                <ul>
                    <li class="mb-4 mt-4 ml-6 italic text-lg">Syariah Multi</li>
                    <li class="pb-2 pt-2 pl-4"><router-link :to="{ name: 'SuperDashboard'}">Dashboard</router-link></li>
                    <li class="pb-2 pt-2 pl-4"><router-link :to="{ name: 'SuperBank'}">Manajemen Bank</router-link></li>
                    <li class="pb-2 pt-2 pl-4"><router-link :to="{ name: 'SuperUser'}">Manajemen User</router-link></li>
                    <li class="pb-2 pt-2 pl-4"><router-link :to="{ name: ''}">Laporan (beta)</router-link></li>
                    <li class="pb-2 pt-2 pl-4"><button @click="logout">Logout</button></li>
                </ul>
            </div>
            <div class="col-span-3 grid grid-rows-1">
                <div class="grid grid-cols-5">
                    <div class="col-span-4 p-4">
                        <h1>{{ tanggal }}</h1>
                    </div>
                    <div class="p-4 text-right">
                        <h1>{{ userCpanel }}</h1>
                    </div>
                </div>
                <div>
                    <router-view />
                </div>
            </div>
        </div>
    </template>
</template>

<script>
import axios from 'axios';
import { data } from 'browserslist';
import router from './routes/router';

export default {

    name: "App",

    mounted() {
        var tgl = new Date()

        this.tanggal = tgl.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric'})
        
        // axios.post('').then(user => {
        //     console.log(user.data)
        // })
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
</style>