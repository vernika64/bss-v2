<template>

<div class="grid grid-cols-3 text-center">
    <div class="col-span-2 h-screen">
        
    </div>
    <div class="p-4 flex flex-col align-middle justify-center text-center">
        <div>
            <h1 class="text-2xl mb-4">Syariah Multi</h1>
            <p class="mb-4">Silahkan login untuk melanjutkan</p>
            <form class="grid grid-rows-1 gap-2">
                <input v-model="formLogin.username" type="text" class="border p-2" placeholder="Username" />
                <input v-model="formLogin.password" type="password" class="border p-2" placeholder="Password" />
        
                <input type="submit" value="Login" class="border bg-blue-500 text-white p-2" @click="masukKeDashboard" />
            </form>
        </div>
    </div>
</div>


</template>

<script>
import axios from 'axios'
import router from '../../routes/router'
import LoginImage from '../Assets/Images/nepu.jpg'

export default {

    mounted() {
        axios.get('/api/super/cekLogin').then(cek => {
            // console.log(cek.data.status)
            if(cek.data.status == 'token_available') {
                return router.push({name: 'SuperDashboard'})
            }
        })
    },
    methods: {
        masukKeDashboard(e) {
            // console.log(this.formLogin)

            axios.post('/api/super/login', { username: this.formLogin.username, password: this.formLogin.password}).then(res => {
                console.log(res.data)
                localStorage.setItem('uname', res.data.nama)
                if(res.data.role == 'admin')
                {
                    router.push({name: 'SuperDashboard'})
                } else if(res.data.role == 'office') {
                    router.push({name: 'BankingDashboard'})
                } else {
                    alert('Server error, silahkan hubungi web administrator')
                }
            })
            e.preventDefault()
        }
    },
    data() {
        return {
            formLogin: {
                username: '',
                password: ''
            },
            LoginImage
        }
    }
}
</script>