<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="flex justify-center items-center py-1">
            <div class="intra">
                <indexTable />
            </div>
        </div>
    </AuthenticatedLayout>
</template>


<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import indexTable from '@/Components/Tables/indexTable.vue'

export default {
    components: {
        AuthenticatedLayout,
        Head,
        indexTable
    }
}
</script>
