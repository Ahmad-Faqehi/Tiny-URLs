<template>

</template>

<script>
 import feather from 'feather-icons'

export default {
    data(){
        return{
            date:new Date().getFullYear()
        }
    },
    mounted() {
        feather.replace();
    }
}
</script>