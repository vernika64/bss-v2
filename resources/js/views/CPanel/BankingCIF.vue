<template>

<div>
    <div class="p-3 bg-white border-t flex flex-row">
        <h1 class="text-2xl italic">{{ judulNavbar }}</h1>
        <button class="p-2 text-white bg-blue-600 w-auto text-sm ml-4" @click="openModalAddCIF = true">Tambah CIF baru</button>
    </div>
    <div class="p-2">
        <div>
            <table class="border border-white w-full">
                <thead class="bg-slate-500 text-white">
                    <tr>
                        <th class="p-4 bold font-md text-left font-semibold w-[50px]">No.#</th>
                        <th class="p-4 bold font-md text-left font-semibold">No. Kode Identitas</th>
                        <th class="p-4 bold font-md text-left font-semibold">Nama Nasabah</th>
                        <th class="p-4 bold font-md text-left font-semibold">Tanggal Ditambahkan</th>
                        <th class="p-4 bold font-md text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr v-for="(dat, index) in isiTabelCIF" :key="dat.cif_kode_id" class="even:bg-slate-200 even:text-black">
                        <td class="border border-white text-center p-3">{{ index + 1 }}</td>
                        <td class="border border-white p-3">{{ dat.cif_kode_id }}</td>
                        <td class="border border-white p-3">{{ dat.cif_nama_lengkap }}</td>
                        <td class="border border-white p-3">{{ dat.tglDibuat }}</td>
                        <td class="border border-white p-3">Aksi</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</template>

<script>

export default {
    mounted() {
        // 
    },
    data() {
        return {
            judulNavbar     : 'Customer Identification File',
            isiTabelCIF     : [
                { 
                    cif_kode_id         : '1642530023',
                    cif_nama_lengkap    : 'Mohammad Basori Wahyudi',
                    tglDibuat           : '2022-07-23'
                },
                { 
                    cif_kode_id         : '12121212',
                    cif_nama_lengkap    : 'Uciha Sasule',
                    tglDibuat           : '2022-07-24'
                },
            ],
            openModalAddCIF : false
        }
    }
}
</script>