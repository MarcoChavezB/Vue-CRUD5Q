<template>
    <div>
        <div v-for="(campo, seccion) in $page.props.campos" :key="seccion">
            <h2>{{ seccion }}</h2>
            <div v-for="(valor, nombre) in campo" :key="nombre">
                <label>{{ nombre }}</label>
                <input v-model="campo[nombre]" />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        campos: {
            type: Object,
            required: true,
        },
    },
}
</script>
