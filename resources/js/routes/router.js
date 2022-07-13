import { createRouter, createWebHistory } from 'vue-router'

// Aset untuk Super Admin
import SuperLogin           from '../views/Superadmin/SuperLogin.vue'
import SuperDashboard       from '../views/Superadmin/SuperDashboard.vue'
import SuperMahasiswa       from "../views/Superadmin/SuperMahasiswa.vue"
import SuperGrup            from "../views/Superadmin/SuperGrup.vue"
import SuperBank            from "../views/Superadmin/SuperBankList.vue"

// Aset untuk Cpanel Banking
import BankingLogin     from '../views/CPanel/BankingLogin.vue'
import BankingDashboard from '../views/CPanel/BankingDashboard.vue'
import axios from 'axios'


// import Test from '../views/Test/Test.vue'

const routes = [

    // Rute untuk Cpanel Banking
    { path: '/', component: BankingLogin, name: 'BankingLogin'},
    { path: '/banking/dashboard', component: BankingDashboard, name: 'BankingDashboard'},

    // Rute untuk Superadmin

    { path: '/supercpl/',                   component: SuperLogin,          name: 'SuperLogin'},

    { path: '/supercpl/superdashboard/',    component: SuperDashboard,      name: 'SuperDashboard'},

    { path: '/supercpl/supermahasiswa/',    component: SuperMahasiswa,      name: 'SuperMahasiswa'},

    { path: '/supercpl/supergrup/',         component: SuperGrup,           name: 'SuperGrup'},

    { path: '/supercpl/superbank',          component: SuperBank,           name: 'SuperBank'}


]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach((to, from, next) => {
    if(to.fullPath == '/supercpl/' || to.fullPath == '/') {
        next()
    } else {
        // axios.post('/api/super/authcheck', { tkn    : document.cookie})
        var jajan = document.cookie

        var jajan2 = jajan.split(';')

        console.log(jajan2)

        next()
    }
})

export default router