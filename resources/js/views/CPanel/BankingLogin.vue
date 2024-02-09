<template>
    <div class="flex h-screen bg-pikisuperstars-circle bg-cover">
        <div class=" lg:w-1/2 lg:h-[70%] xl:w-1/4 xl:h-[70%] m-auto bg-white rounded-md">
            <!-- Login Section -->
            <div class="pl-8 pr-8 text-center mt-[50px]">
                <h1 class="text-4xl italic mb-2">BSS</h1>
                <p class="mb-4">Bank Syariah Simulator</p>
                <p class="mt-4 mb-4">Silahkan login untuk melanjutkan</p>
                <form class="grid gap-4">
                    <input class="border border-slate-300 pl-2 pt-4 pb-4 font-medium rounded-md shadow-md" 
                        v-model="formLogin.username"
                        type="text" 
                        placeholder="Username" />

                    <input class="border border-slate-300 pl-2 pt-4 pb-4 font-medium rounded-md shadow-md" 
                        v-model="formLogin.password"
                        type="password" 
                        placeholder="Password" />

                    <input class="border bg-blue-600 text-white text-xl p-4 rounded-md hover:bg-blue-900 shadow-md transition-all ease-in-out hover:tracking-widest hover:italic cursor-pointer"
                        type="submit" 
                        value="Login" 
                        @click="masukKeDashboard" />
                </form>
            </div>
            <div class="pl-8 pr-8 pt-4">
                <hr>
            </div>
            <div>      
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
        console.log(this.$route)
    },
    methods: {
        masukKeDashboard(e) {
            e.preventDefault();
            axios.post('/api/super/login', { username: this.formLogin.username, password: this.formLogin.password }).then(res => {
                if(res.data.status == true) {
                    localStorage.setItem('uname', res.data.nama);
                    localStorage.setItem('user', res.data.user);
                    switch (res.data.role) {
                        case 'office':
                            this.userRole = 'office';
                            router.push({ name: 'BankingDashboard' });
                            break;
                        case 'admin':
                            this.userRole = 'admin';
                            router.push({ name: 'SuperDashboard' });
                            break;
                        default:
                            alert('Server error, silahkan hubungi web administrator');
                            break;
                    }
                }
                else if(res.data.status == false) {
                    alert(res.data.message);
                }
            }).catch(err => {
                return alert("Terjadi kesalahan di dalam aplikasi, mohon menghubungi Admin website.");
            });
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