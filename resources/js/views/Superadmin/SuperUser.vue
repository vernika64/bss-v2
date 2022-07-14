<template>

    <div class="grid grid-rows-1 ml-2 mr-2">
        <h1 class="text-2xl mb-4">List User untuk Bank</h1>
        <div class="flex flex-row gap-2">
            <button class="p-2 text-white bg-black w-auto text-sm" @click="openModalAddBank = true">Tambah User baru</button>
        </div>
        <div>
            <table class="border-collapse mt-4 w-full">
                <thead>
                    <tr>
                        <th class="p-4 bg-slate-500 text-slate-100 bold text-left w-[70px]">No.#</th>
                        <th class="p-4 bg-slate-500 text-slate-100 bold text-left">Username</th>
                        <th class="p-4 bg-slate-500 text-slate-100 bold text-left">Terdaftar di Bank</th>
                        <th class="p-4 bg-slate-500 text-slate-100 bold text-left">Role</th>
                        <th class="p-4 bg-slate-500 text-slate-100 bold text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border">
                       <td class="text-center border p-2">1</td>
                       <td class="border p-2">Admin</td>
                       <td class="border p-2">SuperUser</td>
                       <td class="border p-2">Admin</td>
                       <td class="border p-2"><button class="bg-blue-500 p-2 text-white rounded-md">Aksi</button></td>
                    </tr>
                </tbody>
            </table>
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
            // 
        }
    },
    methods: {
        // 
    }
}
</script>