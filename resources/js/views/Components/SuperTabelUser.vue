<template>
    <table class="border border-white w-full">
        <thead>
            <tr>
                <th class="p-4 bg-slate-500 text-slate-100 bold text-left w-[50px]">#</th>
                <th class="p-4 bg-slate-500 text-slate-100 bold text-left">Username</th>
                <th class="p-4 bg-slate-500 text-slate-100 bold text-left">Terdaftar di Bank</th>
                <th class="p-4 bg-slate-500 text-slate-100 bold text-left">Role</th>
                <th class="p-4 bg-slate-500 text-slate-100 bold text-left">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            <tr v-for="(isi, index) in items" :key="index" class="even:bg-slate-100 even:text-black hover:bg-slate-300">
                <td class="text-center border border-white p-2">{{ index + 1 }}</td>
                <td class="border border-white p-3">{{ isi.fname }}</td>
                <td class="border border-white p-3">{{ isi.nama_bank }}</td>
                <td class="border border-white p-3">{{ isi.nama_role }}</td>
                <td class="border border-white p-3"></td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    mounted() {
        console.log(this.items)
    },
    props: ['items']
}
</script>