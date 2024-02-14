<template>
    <div class="app w-full h-full grid">
        <nav>
            <TopNavbarCrud />
        </nav>
        <main>
            <slot name="bodyCrud"></slot>
        </main>
    </div>
</template>



<script>
import TopNavbarCrud from '@/Components/sections/TopNavbarCrud.vue'
export default{
    components:{
        TopNavbarCrud
    }
}
</script>

<style scoped>

.app{
    grid-template-rows: 60px 1fr;
    height: 100vh;
}

main{
    margin: 20px;
}
</style>