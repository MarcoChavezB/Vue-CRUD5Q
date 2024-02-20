<template>
    <article class="mod">
        <div class="content">
            <div class="intra grid">
                <div class="header">
                    
                </div>
                <div class="inputs flex flex-col gap-4">
                    <div v-for="(value, key) in infoAdd" :key="key" class="input-group">
                        <input
                            v-if="key !== 'id'"
                            v-model="infoAdd[key]"
                            required=""
                            type="text"
                            name="text"
                            autocomplete="off"
                            class="input"
                        >
                        <label class="user-label" v-if="key !== 'id'">{{ key }}:</label>
                    </div>        
                </div>
                <div class="buttons flex justify-end gap-2">
                    <div class="alerts">
                        <alertErrorVue v-if="showError" :message="messAlert" />
                        <alertSuccesVue v-if="showSucces" :message="messAlert" />
                    </div>
                    
                    <PrimaryButton @click="$emit('close')">
                        Cerrar
                    </PrimaryButton>
                    <PrimaryButton 
                    @click="add()">
                        Guardar
                    </PrimaryButton>
                </div>
            </div>
        </div>
    </article>
</template>

<script>
import PrimaryButton from '../PrimaryButton.vue'
import alertErrorVue from './alertError.vue';
import alertSuccesVue from './alertSuccess.vue';

export default {
    props: {
        infoAdd:{
            type: Object,
            required: true,
        },
        level:{
            type: String,
            required: true,
        }
    },
    data(){
        return {
            messAlert: "",
            showError: false,
            showSucces: false
        }
    },
    components: {
        PrimaryButton,
        alertSuccesVue,
        alertErrorVue
    },
    methods: {
        showMessage(text, type) {
            this.messAlert = text
            if (type === 'error') {
                this.showError = true
                setTimeout(() => {
                    this.showError = false
                }, 3000)
            } else {
                this.showSucces = true
                setTimeout(() => {
                    this.showSucces= false
                }, 3000)
            }
        },
        
        async add(){
            try {
                switch(this.level){
                    case 1:
                        const responseUniversidad = await axios.post(route('Universidad.createUniversidad', this.infoAdd))
                        this.showMessage(responseUniversidad.data.message, 'success')
                        this.$emit('reload', {nivel: 1, id: responseUniversidad.data.id})
                        console.log(responseUniversidad)
                        break;
                    case 2:
                        const responseCarrera = await axios.post(route('Carrera.createCarrera', this.infoAdd))
                        this.showMessage(responseCarrera.data.message, 'success')
                        this.$emit('reload', {nivel: 2, id: responseCarrera.data.id})
                        console.log(responseCarrera)
                        break;
                    case 3:
                        const responseMateria = await axios.post(route('Materia.createMateria', this.infoAdd))
                        this.showMessage(responseMateria.data.message, 'success')
                        this.$emit('reload', {nivel: 3, id: responseMateria.data.id})
                        break;
                    case 4:
                        const responseProfesor = await axios.post(route('Profesor.createProfesor', this.infoAdd))
                        this.showMessage(responseProfesor.data.message, 'success')
                        console.log(responseProfesor.data.id)
                        this.$emit('reload', {nivel: 4, id: responseProfesor.data.id})
                        break;
                    case 5:
                        const responseAlumno = await axios.post(route('Alumno.createAlumno', this.infoAdd))
                        this.showMessage(responseAlumno.data.message, 'success')
                        this.$emit('reload', {nivel: 5, id: responseAlumno.data.id})
                        console.log(responseAlumno)
                        console.log(responseAlumno.data.id)
                        break;
                }
            } catch (error) {
                this.showMessage(error.response.data.message, 'error')
            }
        }
    }
}
</script>

<style scoped>
.mod {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: end;
    z-index: 100;
}

input {
    width: 100%;
    height: 100%;
    background-color: white;
    grid-template-rows: 1fr 5fr 0.5fr;

}

.intra {
    width: 90%;
    height: 90%;
    background-color: white;
    grid-template-rows: 1fr 5fr 0.5fr;
}

.content {
    margin-left: 20px;
    width: 40%;
    height: 86%;
    background-color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50px 50px 0px 0px;
    box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
}

.input-group {
    position: relative;
}
.alerts{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 100;
}
.input {
    border: solid 1.5px #9e9e9e;
    border-radius: 1rem;
    background: none;
    padding: 1rem;
    font-size: 1rem;
    color: black;
    transition: border 150ms cubic-bezier(0.4, 0, 0.2, 1);
}

.user-label {
    position: absolute;
    left: 15px;
    color: #9e9e9e;
    pointer-events: none;
    transform: translateY(1rem);
    transition: 150ms cubic-bezier(0.4, 0, 0.2, 1);
}

.input:focus,
input:valid {
    outline: none;
    border: 1.5px solid black;
}

.input:focus~label,
input:valid~label {
    transform: translateY(-50%) scale(0.8);
    background-color: white;
    padding: 0 .2em;
    color: black;
}
</style>

