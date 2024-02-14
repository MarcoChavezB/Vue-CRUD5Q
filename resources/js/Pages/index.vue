<template>
    <CrudLayout>
        <template #bodyCrud>
            <body class="flex justify-center items-center">
                <div class="intra-layout h-full w-full">
                    <indexTable />
                </div>
            </body>
        </template>
    </CrudLayout>
</template>

<script>
import CrudLayout from '@/Layouts/CrudLayout.vue'
import indexTable from '@/Components/Tables/indexTable.vue'
export default {
    components: {
        CrudLayout,
        indexTable
    }
}
</script>


<style scoped>

body{
    width: 100%;
    height: 100%;
}

.intra-layout{
    
    width: 90%;
}
</style>
