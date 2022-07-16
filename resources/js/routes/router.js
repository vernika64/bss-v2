import { createRouter, createWebHistory} from 'vue-router'

// Aset untuk Sistem

import Peko_404             from '../views/System/404.vue'

// import SuperMahasiswa       from "../views/Superadmin/SuperMahasiswa.vue"
// import SuperGrup            from "../views/Superadmin/SuperGrup.vue"

import SuperLogin           from '../views/Superadmin/SuperLogin.vue'
import SuperDashboard       from '../views/Superadmin/SuperDashboard.vue'
import SuperBank            from "../views/Superadmin/SuperBank.vue"
import SuperBankDetail      from "../views/Superadmin/SuperBankDetails.vue"
import SuperUser            from "../views/Superadmin/SuperUser.vue"

// Aset untuk Cpanel Banking
import BankingLogin     from '../views/CPanel/BankingLogin.vue'
import BankingDashboard from '../views/CPanel/BankingDashboard.vue'
import axios from 'axios'


// import Test from '../views/Test/Test.vue'

const routes = [

    // Rute untuk Sistem Vue Router
    { path: '/:pathMatch(.*)*',                     component: Peko_404,                name: 'PekoNotFound'},

    // Rute untuk Cpanel Banking
    { path: '/',                                    component: BankingLogin,            name: 'BankingLogin'},

    { path: '/banking/dashboard',                   component: BankingDashboard,        name: 'BankingDashboard'},

    // Rute untuk Superadmin

    { path: '/supercpl/',                           component: SuperDashboard},

    { path: '/supercpl/superdashboard/',            component: SuperDashboard,          name: 'SuperDashboard'},

    { path: '/supercpl/superbank',                  component: SuperBank,               name: 'SuperBank'},
    { path: '/supercpl/superbank/detail/:bankID',   component: SuperBankDetail,         name: 'SuperBankDetail'},

    { path: '/supercpl/superuser/',                 component: SuperUser,               name: 'SuperUser'},



    // { path: '/supercpl/supermahasiswa/',    component: SuperMahasiswa,      name: 'SuperMahasiswa'},

    // { path: '/supercpl/supergrup/',         component: SuperGrup,           name: 'SuperGrup'},



]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach((to, from, next) => {
    if(to.fullPath == '/') {
        next()
    } else if(to.name == 'PekoNotFound') {
        next();
    } else {
        axios.get('/api/super/tknCheck').then(tkn => {
            if(tkn.data.status == 'token_notexist')
            {
                return router.push({name: 'BankingLogin'})
            }
            // console.log(tkn.data)
        })

        next()
    }
})

export default router