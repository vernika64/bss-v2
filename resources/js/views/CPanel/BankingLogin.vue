<template>

<div class="grid grid-rows-1 text-center">
    <h1>Syariah V</h1>
    <p>Silahkan login untuk melanjutkan</p>
    <form class="grid grid-rows-1 gap-2">
        <input v-model="formLogin.username" type="text" class="border" />
        <input v-model="formLogin.password" type="password" class="border" />

        <input type="submit" value="Login" class="border" @click="masukKeDashboard" />
    </form>
</div>


</template>

<script>
export default {
methods: {
    masukKeDashboard(e) {
        console.log(this.formLogin)
        e.preventDefault()
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