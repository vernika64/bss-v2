<template>

    <div class="flex h-screen bg-ppurple">
        <div class="grid grid-cols-2 w-[900px] h-[500px] m-auto bg-white rounded-md">
            <div class="bg-utah-road rounded-l-md">
            </div>
            <div class="p-4 text-center mt-auto mb-auto">
                <div>
                    <h1 class="text-2xl mb-4 italic">Syariah Multi</h1>
                    <p class="mb-4">Silahkan login untuk melanjutkan</p>

                    <form class="grid gap-2">

                        <input class="border p-2 font-light rounded-md shadow-sm" 
                            v-model="formLogin.username"
                            type="text" 
                            placeholder="Username" />

                        <input class="border p-2 font-light rounded-md shadow-sm" 
                            v-model="formLogin.password"
                            type="password" 
                            placeholder="Password" />

                        <input class="border bg-blue-500 text-white p-2 rounded-md hover:bg-blue-900 shadow-sm transition-all ease-in-out cursor-pointer"
                            type="submit" 
                            value="Login" 
                            @click="masukKeDashboard" />

                    </form>
                </div>
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
            if (cek.data.status == 'token_available') {
                return router.push({ name: 'SuperDashboard' })
            }
        })
    },
    methods: {
        masukKeDashboard(e) {
            // console.log(this.formLogin)
            e.preventDefault()
            axios.post('/api/super/login', { username: this.formLogin.username, password: this.formLogin.password }).then(res => {

                if(res.data.status == 200) {

                    console.log(res.data)
                    localStorage.setItem('uname', res.data.nama)

                    if (res.data.role == 'admin') {
                        router.go({ name: 'SuperDashboard' })
                    } else if (res.data.role == 'office') {
                        router.go({ name: 'BankingDashboard' })
                    } else {
                        alert('Server error, silahkan hubungi web administrator')
                    }
                } else {
                    alert('Server error, silahkan hubungi web administrator')
                }

            })
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