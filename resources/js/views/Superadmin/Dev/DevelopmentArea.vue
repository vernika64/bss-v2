<template>
    <div>
        <div class="p-3 bg-white border-t flex flex-row">
            <h1 class="text-2xl italic">Development Area</h1>
        </div>
        <div class="grid grid-rows-1 md:grid md:grid-cols-5 gap-2 mt-2 p-4">
            <router-link class="p-2 bg-white shadow-md grid justify-items-center" :to="{ name: 'CIF'}">
                <user-icon class="h-[50px] w-[50px] mb-4 mt-2" />
                <h1>Customer Identification File</h1>
            </router-link>
            <router-link class="p-2 bg-white shadow-md grid justify-items-center" :to="{ name: 'Tabungan' }">
                <download-icon class="h-[50px] w-[50px] mb-4 mt-2" />
                <h1>Tabungan Wadiah</h1>
            </router-link>
            <router-link class="p-2 bg-white shadow-md grid justify-items-center" :to="''">
                <cash-icon class="h-[50px] w-[50px] mb-4 mt-2" />
                <h1>Jual Beli akad Murabahah</h1>
            </router-link>
            <router-link class="p-2 bg-white shadow-md grid justify-items-center" :to="''">
                <currency-dollar-icon class="h-[50px] w-[50px] mb-4 mt-2" />
                <h1>Deposito akad Mudharabah</h1>
            </router-link>
            <router-link class="p-2 bg-white shadow-md grid justify-items-center" :to="''">
                <cube-icon class="h-[50px] w-[50px] mb-4 mt-2" />
                <h1>Daftar Barang</h1>
            </router-link>
            <router-link class="p-2 bg-white shadow-md grid justify-items-center" :to="''">
                <book-open-icon class="h-[50px] w-[50px] mb-4 mt-2" />
                <h1>Tutup Buku Harian</h1>
            </router-link>
        </div>
    </div>
</template>

<script>
import { UserIcon, DownloadIcon, BookOpenIcon, CubeIcon, CashIcon, CurrencyDollarIcon } from '@heroicons/vue/outline'

export default {
    components: {
        UserIcon,
        DownloadIcon,
        BookOpenIcon,
        CubeIcon,
        CashIcon,
        CurrencyDollarIcon
    }
}
</script>