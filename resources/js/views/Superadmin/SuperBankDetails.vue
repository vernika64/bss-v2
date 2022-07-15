<template>
<div class="grid grid-rows-1">
    <div class="p-4">
        <h1 class="text-3xl italic">{{ judulDetail.nama_bank }}</h1>
    </div>
</div>
</template>

<script>
import axios from 'axios'

export default {
    mounted() {
        axios.get('/api/super/bankList/'+ this.$route.params.bankID).then(res => {
            this.judulDetail = res.data.data
            console.log(this.judulDetail)
        }).catch(err => {
            console.log(err)
        })
    },
    methods: {

    },
    data(){
        return {
            judulDetail     : 'User',
            detailBank      : []
        }
    }
}
</script>