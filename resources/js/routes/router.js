import { createRouter, createWebHistory} from 'vue-router'
import axios from 'axios'

// Aset untuk Sistem

import Peko_404             from '../views/System/404.vue'

// import SuperMahasiswa       from "../views/Superadmin/SuperMahasiswa.vue"
// import SuperGrup            from "../views/Superadmin/SuperGrup.vue"

// Aset untuk komponen

import UserBankingSidebar   from '../views/Components/UserBankingSidebar.vue'
import UserAdminSidebar     from '../views/Components/UserAdminSidebar.vue'

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
let releaseurl  = '/banking'
let superpanel  = '/supercpl'

// import Test from '../views/Test/Test.vue'

const routes = [

    // Rute untuk Sistem Vue Router
    {   
        path            : '/:pathMatch(.*)*',
        component       : Peko_404,
        name            : 'PekoNotFound'
    },

    // Rute untuk Superadmin

    {   
        path             : superpanel + '/dashboard',
        components       : {
            default : SuperDashboard,
            sidebar : UserAdminSidebar
        }
    },

    {
        path            : superpanel + '/superdashboard/',
        name            : 'SuperDashboard',
        components      : {
            default : SuperDashboard,
            sidebar : UserAdminSidebar
        }
    },

    {
        path            : superpanel + '/superbank',
        name            : 'SuperBank',
        components      : {
            default : SuperBank,
            sidebar : UserAdminSidebar
        }
    },
    { 
        path            : superpanel + '/superbank/detail/:bankID',
        name            : 'SuperBankDetail',
        components      : {
            default : SuperBankDetail,
            sidebar : UserAdminSidebar
        }
    },

    { 
        path            : superpanel + '/superuser/',
        name            : 'SuperUser',
        components       : {
            default : SuperUser,
            sidebar : UserAdminSidebar
        }
    },

    { 
        path            : superpanel + '/superpekerjaan/',
        name            : 'SuperPekerjaan',
        components      : {
            default : SuperPekerjaan,
            sidebar : UserAdminSidebar
        }
    },

    {
        path            : superpanel + '/superakuntansi/',
        name            : 'SuperAkunAkuntansi',
        components      : {
            default : SuperAkunAkuntansi,
            sidebar : UserAdminSidebar
        }
    },

    { 
        path            : devurl,
        name            : 'DevelopmentArea',
        components      : {
            default : DevArea,
            sidebar : UserAdminSidebar
        }
    },

    // Rute untuk role Office serbaguna

    {   
        path            : '/',
        component       : BankingLogin,
        name            : 'BankingLogin',
        params          : {
            id      : true
        }
    },

    {   
        path            : releaseurl + '/dashboard',
        name            : 'BankingDashboard',
        components      : { 
            default : BankingDashboard,
            sidebar : UserBankingSidebar
        }
    },

    {
        path            : releaseurl + '/cif',
        name            : 'CIF',
        components      : { 
            default : BankingCIF,
            sidebar : UserBankingSidebar
        }
    },

    { 
        path            : releaseurl + '/cif',
        name            : 'CIF',
        components      : {
            default : BankingCIF,
            sidebar : UserBankingSidebar
        },
    },

    { 
        path            : releaseurl + '/cif/add',
        name            : 'CIFAdd',
        components      : {
            default : BankingCIFAdd,
            sidebar : UserBankingSidebar
        }
    },
    
    {
        path            : releaseurl + '/cifdetail/',
        name            : 'CIFDetail',
        components       : {
            default : BankingCIFDetail,
            sidebar : UserBankingSidebar
        }
    },

    { 
        path            : releaseurl + '/tabungan',
        name            : 'Tabungan',
        components      : {
            default : BankingTabungan,
            sidebar : UserBankingSidebar
        }
    },

    {
        path            : releaseurl + '/tabungan/tarik_setor_tunai',
        name            : 'TabunganTarikSetorTunai',
        components      : {
            default : BankingTabunganTarikSetorTunai,
            sidebar : UserBankingSidebar
        }
    },

    {
        path            : releaseurl + '/tabungan/transfer_uang',
        name            : 'TabunganTransferUang',
        component       : {
            default : BankingTabunganTransferUang,
            sidebar : UserBankingSidebar
        }
    },

    {
        path            : releaseurl + '/jualbeli',
        name            : 'JualBeliMurabahah',
        components      : {
            default : BankingJualBeliMurabahah,
            sidebar : UserBankingSidebar
        }
    },

    {
        path            : releaseurl + '/jualbelidetail/',
        name            : 'JualBeliMurabahahDetail',
        components      : {
            default : BankingJualBeliMurabahahDetail,
            sidebar : UserBankingSidebar
        }
    },

    {
        path            : releaseurl + '/permintaanbarang/',
        name            : 'PermintaanBarangMurabahah',
        components      : {
            default : BankingPermintaanBarangMurabahah,
            sidebar : UserBankingSidebar
        }
    },

    {
        path            : releaseurl + '/angsuranmurabahah/',
        name            : 'AngsuranMurabahah',
        components      : {
            default : BankingAngsuranMurabahah,
            sidebar : UserBankingSidebar
        }
    },

    // Untuk Jurnal Umum

    {
        path            : releaseurl + '/daftarjurnalumum',
        name            : 'DaftarJurnalUmum',
        components      : {
            default : BankingDaftarJurnalUmum,
            sidebar : UserBankingSidebar
        }
    },

    {
        path            : releaseurl + '/daftarjurnalumum/',
        name            : 'DaftarJurnalUmumDetail',
        components      : {
            default : BankingDaftarJurnalUmumDetail,
            sidebar : UserBankingSidebar
        }
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
        axios.get('/api/super/cekLogin').then(cek => {
            // console.log(cek.data.status)
            switch (cek.data.status) {
                case 200:
                    router.push({ name: 'BankingDashboard' })
                    break;
                case 403:
                    alert(cek.data.message)
                    next()
                    break;
                case 404:
                    next()
                    break;
                case 500:
                    alert('Terdapat kesalah di server, mohon menghubungi staff IT website untuk ditijau kerusakan pada website')
                    next()
                    break;
                default:
                    next()
                    break;
            }
        })
    } else if(to.name == 'PekoNotFound') {
        next();
    } else {
        axios.get('/api/super/tknCheck').then(tkn => {
            if(tkn.data.status == 200)
            {
                next()
            } else {
                alert("Sesi login anda sudah habis, silahkan login lagi")

                return router.push({name: 'BankingLogin'})
            }
        })
    }
})

export default router