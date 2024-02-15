<template>
    <table class="border border-white w-full">
        <thead>
            <tr>
                <th class="p-4 bg-slate-500 text-slate-100 bold text-left w-[50px]">#</th>
                <th class="p-4 bg-slate-500 text-slate-100 bold text-left">Kode Bank</th>
                <th class="p-4 bg-slate-500 text-slate-100 bold text-left">Nama Bank</th>
                <th class="p-4 bg-slate-500 text-slate-100 bold text-left">Alamat Bank</th>
                <th class="p-4 bg-slate-500 text-slate-100 bold text-left">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            <tr v-for="(isi, index) in items" :key="index" class="even:bg-slate-100 even:text-black hover:bg-slate-300">
                <td class="text-center border border-white p-2">{{ index + 1 }}</td>
                <td class="border border-white p-3">{{ isi.kd_bank }}</td>
                <td class="border border-white p-3">{{ isi.nama_bank }}</td>
                <td class="border border-white p-3">{{ isi.alamat_bank }}</td>
                <td class="border border-white p-3 text-center">
                    <router-link class="p-2 bg-blue-600 text-white rounded-md text-sm" :to="{ name: 'SuperBankDetail', params: { bankID: isi.kd_bank }}">
                        Details
                    </router-link>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    mounted() {
        console.log("Items di Komponen Tabel Bank");
        console.log(this.items);
    },
    props: ['items']
}
</script>