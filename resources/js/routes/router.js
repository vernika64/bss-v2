import { createRouter, createWebHistory} from 'vue-router'
import axios from 'axios'

// Aset untuk Sistem

import Peko_404             from '../views/System/404.vue'

// import SuperMahasiswa       from "../views/Superadmin/SuperMahasiswa.vue"
// import SuperGrup            from "../views/Superadmin/SuperGrup.vue"

import SuperLogin           from '../views/Superadmin/SuperLogin.vue'
import SuperDashboard       from '../views/Superadmin/SuperDashboard.vue'
import SuperBank            from "../views/Superadmin/SuperBank.vue"
import SuperBankDetail      from "../views/Superadmin/SuperBankDetails.vue"
import SuperUser            from "../views/Superadmin/SuperUser.vue"
import SuperPekerjaan       from "../views/Superadmin/SuperPekerjaan.vue"
import SuperAkunAkuntansi   from "../views/Superadmin/SuperBukuAkuntansi.vue"

// Aset untuk Cpanel Banking
import BankingLogin                         from '../views/CPanel/BankingLogin.vue'
import BankingDashboard                     from '../views/CPanel/BankingDashboard.vue'
import BankingCIF                           from '../views/CPanel/BankingCIF.vue'
import BankingCIFAdd                        from '../views/CPanel/Forms/BankingCIFNew.vue'
import BankingCIFDetail                     from '../views/CPanel/BankingCIFDetails.vue'
import BankingTabungan                      from '../views/CPanel/BankingTabungan.vue'
import BankingTabunganTarikSetorTunai       from '../views/CPanel/BankingTabunganTarikSetorTunai.vue'
import BankingTabunganTransferUang          from '../views/CPanel/BankingTabunganTransfer.vue'
import BankingJualBeliMurabahah             from '../views/CPanel/BankingJualBeliMurabahah.vue'
import BankingJualBeliMurabahahDetail       from '../views/CPanel/Forms/BankingVerifikasiMurabahah.vue'
import BankingPermintaanBarangMurabahah     from '../views/CPanel/BankingPermintaanBarangMurabahah.vue'
import BankingAngsuranMurabahah             from '../views/CPanel/BankingAngsuranMurabahah.vue'
import BankingDaftarJurnalUmum              from '../views/CPanel/BankingJurnalUmum.vue'
import BankingDaftarJurnalUmumDetail        from '../views/CPanel/BankingJurnalUmumDetail.vue'

// Untuk Pengembangan dan Testing
import DevArea              from '../views/Superadmin/Dev/DevelopmentArea.vue'

let devurl      = '/dev'
let releaseurl  = '/bank'

// import Test from '../views/Test/Test.vue'

const routes = [

    // Rute untuk Sistem Vue Router
    {   
        path            : '/:pathMatch(.*)*',
        component       : Peko_404,
        name            : 'PekoNotFound'
    },

    // Rute untuk Cpanel Banking
    {   
        path            : '/',
        component       : BankingLogin,
        name            : 'BankingLogin'
    },

    {   
        path            : '/banking/dashboard',
        component       : BankingDashboard,
        name            : 'BankingDashboard'
    },

    {
        path            : '/banking/cif',
        component       : BankingCIF,
        name            : 'CIF',
        props           :   {
                                teksNavbar  : 'Customer Identification File'
                            }
    },

    // Rute untuk Superadmin

    {   
        path            : '/supercpl/',
        component       : SuperDashboard
    },

    {
        path            : '/supercpl/superdashboard/',
        component       : SuperDashboard,
        name            : 'SuperDashboard'
    },

    {
        path            : '/supercpl/superbank',
        component       : SuperBank,
        name            : 'SuperBank'
    },
    { 
        path            : '/supercpl/superbank/detail/:bankID',
        component       : SuperBankDetail,
        name            : 'SuperBankDetail'
    },

    { 
        path            : '/supercpl/superuser/',
        component       : SuperUser,
        name            : 'SuperUser'
    },


    { 
        path            : '/supercpl/superpekerjaan/',
        component       : SuperPekerjaan,
        name            : 'SuperPekerjaan'
    },

    {
        path            : '/supercpl/superakuntansi/',
        component       : SuperAkunAkuntansi,
        name            : 'SuperAkunAkuntansi'
    },

    { 
        path            : devurl,
        component       : DevArea,
        name            : 'DevelopmentArea'
    },

    // Customer Identification File

    { 
        path            : releaseurl + '/cif',
        component       : BankingCIF,
        name            : 'CIF'
    },

    { 
        path            : releaseurl + '/cif/add',
        component       : BankingCIFAdd,
        name            : 'CIFAdd'
    },
    {
        path            : releaseurl + '/cifdetail/',
        component       : BankingCIFDetail,
        name            : 'CIFDetail'
    },

    // Tabungan Wadiah

    { 
        path            : devurl + '/tabungan',
        component       : BankingTabungan,
        name            : 'Tabungan'
    },

    {
        path            : devurl + '/tabungan/tarik_setor_tunai',
        component       : BankingTabunganTarikSetorTunai,
        name            : 'TabunganTarikSetorTunai'
    },

    {
        path            : devurl + '/tabungan/transfer_uang',
        component       : BankingTabunganTransferUang,
        name            : 'TabunganTransferUang'
    },

    // Jual Beli Murabahah

    {
        path            : devurl + '/jualbeli',
        component       : BankingJualBeliMurabahah,
        name            : 'JualBeliMurabahah'
    },

    {
        path            : devurl + '/jualbelidetail/',
        component       : BankingJualBeliMurabahahDetail,
        name            : 'JualBeliMurabahahDetail',
    },

    // Untuk Storage

    {
        path            : devurl + '/permintaanbarang/',
        component       : BankingPermintaanBarangMurabahah,
        name            : 'PermintaanBarangMurabahah',
    },

    // Untuk Angsuran Murabahah

    {
        path            : devurl + '/angsuranmurabahah/',
        component       : BankingAngsuranMurabahah,
        name            : 'AngsuranMurabahah'
    },

    // Untuk Jurnal Umum

    {
        path            : devurl + '/daftarjurnalumum',
        component       : BankingDaftarJurnalUmum,
        name            : 'DaftarJurnalUmum'
    },

    {
        path            : devurl + '/daftarjurnalumum/',
        component       : BankingDaftarJurnalUmumDetail,
        name            : 'DaftarJurnalUmumDetail'
    },
 
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