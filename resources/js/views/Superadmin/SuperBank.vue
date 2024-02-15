<template>
<div>
    <div class="p-3 bg-white flex flex-row">
        <h1 class="text-2xl italic">List Bank</h1>
        <button class="p-2 text-white bg-blue-600 w-auto text-sm ml-4" @click="openModalAddBank = true">Tambah Bank Baru</button>
    </div>
    <div class="p-2">
        <div>
            <SuperTabelBank :items="tabelBank" />
        </div>
    </div>
</div>
<!-- Modal Section -->
<Transition name="slide-fade">
    <div class="flex flex-col w-full h-full bg-slate-900 left-0 top-0 fixed bg-opacity-70 justify-center align-middle" v-if="openModalAddBank == true">
        <div class="relative bg-white rounded-lg shadow p-4 m-auto md:w-1/3 2xl:w-1/4">
            <div class="grid grid-rows-1">
                <h1 class="text-xl text-black mb-5">Tambah Bank Baru</h1>
                <div class="grid grid-rows-1 mb-5">
                    <label class="text-black mb-2">Nama Bank</label>
                    <input type="text" class="border border-slate-300 bg-white pt-1 pb-1 pl-2 rounded-md h-[50px] mb-3" v-model="formBankBaru.namabank" placeholder="Nama bank baru" />
                    <label class="text-black mb-2">Alamat Bank</label>
                    <textarea type="text" class="border border-slate-300 bg-white pt-2 pb-2 pl-2 rounded-md mb-3" v-model="formBankBaru.alamatbank" rows="4" placeholder="Alamat bank baru"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <button class="bg-slate-300 text-black p-2 rounded-md shadow-md" @click="openModalAddBank = false">Tutup</button>
                    <button class="bg-blue-600 text-white p-2 rounded-md shadow-md" @click="tambahBankBaru">Simpan</button>
                </div>
            </div>  
        </div>
    </div>
</Transition>
<!-- End Modal Selection -->

</template>

<script>
import axios from 'axios';
import SuperTabelBank from '../Components/SuperTabelBank.vue';

export default {
    components: {
        SuperTabelBank
    },
    mounted() {
        axios.get('/api/super/bankList').then(res => {
            this.tabelBank = res.data.data;
        }).catch(err => {
            alert('Mohon maaf, server sedang mengalami gangguan, mohon untuk menghubungi Web Administrator');
        })
    },
    data() {
        return {
            openModalAddBank: false,
            tabelBank: [],
            formBankBaru: {
                namabank        : '',
                alamatbank      : ''
            }
        }
    },
    methods: {
        tambahBankBaru() {

            let dataBank = {
                namabank        : this.formBankBaru.namabank,
                alamatbank      : this.formBankBaru.alamatbank
            };

            axios.post('/api/super/addNewBank', dataBank).then(res2 => {
                alert(res2.data.message);
                console.log(res2);
                location.reload();
            }).catch(err2 => {
                alert(err2.data.message);
            });
        }
    }
}
</script>