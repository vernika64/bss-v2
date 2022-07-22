<template>
<div>
    <div class="p-3 bg-white border-t flex flex-row">
        <h1 class="text-2xl italic">Development Area</h1>
    </div>
    <div class="grid grid-rows-1 md:grid md:grid-cols-5 gap-2 mt-2 p-4">
        <div class="p-2 bg-white shadow-md grid justify-items-center">
            <user-icon class="h-[50px] w-[50px] mb-4 mt-2" />
            <h1>Nasabah</h1>
        </div>
        <div class="p-2 bg-white shadow-md grid justify-items-center">
            <download-icon class="h-[50px] w-[50px] mb-4 mt-2" />
            <h1>Transaksi</h1>
        </div>
        <div class="p-2 bg-white shadow-md grid justify-items-center">
            <user-icon class="h-[50px] w-[50px] mb-4 mt-2" />
            <h1>Tabungan Wadiah</h1>
        </div>
        <div class="p-2 bg-white shadow-md grid justify-items-center">
            <user-icon class="h-[50px] w-[50px] mb-4 mt-2" />
            <h1>Pinjaman Murabahah</h1>
        </div>
    </div>
</div>
</template>

<script>
import { UserIcon, DownloadIcon } from '@heroicons/vue/outline'

export default {
    components: {
        UserIcon,
        DownloadIcon
    }
}
</script>