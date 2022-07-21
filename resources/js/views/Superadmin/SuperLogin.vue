<template>

<div class="md:grid md:grid-cols-3 text-center">
    <div>
        <!-- Blank Area -->
    </div>
    <div class="md:mt-[20rem]">
    <h1 class="text-2xl">Administrator Dashboard</h1>
    <p>Please login to continue</p>

    <form class="grid grid-rows-1 gap-2">
        <input v-model="formLogin.username" type="text" class="border" />
        <input v-model="formLogin.password" type="password" class="border" />

        <input type="submit" value="Login" class="border" @click="entryKeDashboard" />
    </form>
    </div>
    <div>
        <!-- Blank Area -->
    </div>
</div>

</template>

<script>
import axios from 'axios'
import router from '../../routes/router'

export default {
methods: {
    entryKeDashboard(e) {
        console.log(this.formLogin)
        e.preventDefault()

        const entryData = {
            username: this.formLogin.username,
            password: this.formLogin.password
        }

        axios.post('/api/super/adminLogin', entryData).then(user => {
            const nama = user.data.nama
            console.log(nama)
            console.log(user.data)


            return router.push({name: 'SuperDashboard'})
        })
    }
},
data() {
    return {
        formLogin: {
            username: '',
            password: ''
        }
    }
}
}
</script>