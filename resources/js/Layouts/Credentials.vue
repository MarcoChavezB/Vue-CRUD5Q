<template>
    <div class="app w-full h-full grid ">
        <nav>
            <TopNavbar />
        </nav>
        <main>
            <slot name="body"></slot>
        </main>
    </div>
</template>

<style scoped>

.app{
    grid-template-rows: 60px 1fr;
    height: 100vh;
}

main{
    margin: 20px;
}
</style>

<script>
import TopNavbar from '@/Components/sections/TopNavbar.vue'
export default {
    components: {
        TopNavbar
    }
}
</script>