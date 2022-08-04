<template>
<div>
    <div class="p-3 bg-white border-t flex flex-row">
        <h1 class="text-2xl italic">{{ judulNavbar }}</h1>
        <button class="p-2 text-white bg-blue-600 w-auto text-sm ml-4" @click="openModalAddBank = true">Tambah Bank Baru</button>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            judulNavbar         : 'Transfer uang'
        }
    }
}
</script>