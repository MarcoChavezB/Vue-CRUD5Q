<!-- ModalComp.vue (componente hijo) -->
<template>
    <article class="mod">

        <div class="content">
            <div class="intra grid">
                
                <div class="header flex justify-between">
                    <h1>Modificar </h1>
                    <h1>{{ infoEdit.nombre }}</h1>
                </div>
                
                <div class="inputs flex flex-col gap-4">
                    <div v-for="(value, key) in infoEdit" :key="key" class="input-group">
                        <input
                            v-if="key !== 'id'"
                            v-model="infoEdit[key]"
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
                    <div 
                    v-if="nivel === 5"
                    class="addProfe flex justify-center">
                        <PrimaryButton @click="showModalProfesor()">
                            Agregar Profesor
                        </PrimaryButton>
                    </div>

                    <div 
                    v-if="nivel === 4"
                    class="addProfe flex justify-center">
                        <PrimaryButton @click="showModalProfesor()">
                            Agregar Materia
                        </PrimaryButton>
                    </div>
                    <div class="alerts">
                        <alertErrorVue v-if="showError" :message="messAlert" />
                        <alertSuccesVue v-if="showSucces" :message="messAlert" />
                        <alertAdvertencia v-if="showAdvertencia" :message="messAlert" />
                    </div>
                    <PrimaryButton @click="$emit('close')">
                        Cerrar
                    </PrimaryButton>
                    <PrimaryButton @click="edit()">
                        Guardar
                    </PrimaryButton>
                </div>

                <!-- v-if="showFormAddProfesor" -->
                <div 
                v-if="showFormAddProfesor"
                 class="addProfesor">
                    <div class="intra-cont">
                        <div class="inputs flex gap-4">
                            <div class="input-group">
                                <input
                                    v-model="nombre"
                                    required=""
                                    type="text"
                                    name="text"
                                    autocomplete="off"
                                    class="input"
                                >
                                <label class="user-label">Nombre:</label>
                            </div>
                            <div class="input-group">
                                <input
                                    v-model="matricula"
                                    required=""
                                    type="text"
                                    name="text"
                                    autocomplete="off"
                                    class="input"
                                >
                                <label class="user-label">Matricula:</label>
                            </div>
                            <PrimaryButton @click="RequestAddProfesor()">
                                Añadir profesor
                            </PrimaryButton>
                        </div>        
                    </div>
                </div>
                

                <div
                v-if="showFormAddProfesor"
                 class="addProfesor">
                    <div class="intra-cont">
                        <div class="inputs flex gap-4">
                            <div class="input-group">
                                <input
                                    v-model="nombreMateria"
                                    required=""
                                    type="text"
                                    name="text"
                                    autocomplete="off"
                                    class="input"
                                >
                                <label class="user-label">Nombre:</label>
                            </div>
                            <div class="input-group">
                                <input
                                    v-model="codigoMateria"
                                    required=""
                                    type="text"
                                    name="text"
                                    autocomplete="off"
                                    class="input"
                                >
                                <label class="user-label">Codigo:</label>
                            </div>
                            <PrimaryButton @click="RequestAddMateria()">
                                Añadir profesor
                            </PrimaryButton>
                        </div>        
                    </div>
                </div>
            </div>
        </div>
    </article>
</template>
  
<script>
import PrimaryButton from '../PrimaryButton.vue'
import alertErrorVue from './alertError.vue';
import alertSuccesVue from './alertSuccess.vue';
import alertAdvertencia from './alertAdvertencia.vue';

export default {
    components: {
        PrimaryButton,
        alertSuccesVue,
        alertErrorVue,
        alertAdvertencia
    },
    props: {
        infoEdit: {
            type: Object,
            required: true,
        },
        nivel: {
            type: Number,
            required: true,
        }
    },
    data() {
        return {
            messAlert: "",
            showError: false,
            showSucces: false,
            showAdvertencia: false,
            showFormAddProfesor: false,
            nombre: "",
            matricula: "",
            nombreMateria: "",
            codigoMateria:"",
        }
    },
    methods: {
        showModalProfesor() {
            this.showFormAddProfesor = !this.showFormAddProfesor
        },
        async RequestAddProfesor() {
            this.ObjectAddProfesor = {
                nombre: this.nombre,
                matricula: this.matricula,
                id_alumno: this.infoEdit.id
            }
            try {
                const response = await axios.post(route('Alumno.agregarProfesor', this.ObjectAddProfesor))
                this.showMessage(response.data.message, 'success')
                
            } catch (error) {
                this.showMessage(error.response.data.message, 'error')
            }
        },

        async RequestAddMateria() {
            this.ObjectAddMateria = {
                nombre: this.nombreMateria,
                codigo: this.codigoMateria,
                id_profesor: this.infoEdit.id
            }
            try {
                const response = await axios.post(route('Profesor.agregarMateria', this.ObjectAddMateria))
                this.showMessage(response.data.message, 'success')
                
            } catch (error) {
                this.showMessage(error.response.data.message, 'error')
            }
        },
        async edit() {
            try {
                switch (this.nivel) {
                case 1:
                    const responseUniversidad = await axios.put(route('Universidad.updateUniversidad', this.infoEdit))
                    this.showMessage(responseUniversidad.data.message, 'success')
                    this.$emit('reload', { nivel: this.nivel, id: this.infoEdit.id})
                    break;
                case 2:
                    const responseCarrera = await axios.put(route('Carrera.updateCarrera', this.infoEdit))
                    this.showMessage(responseCarrera.data.message, 'success')
                    this.$emit('reload', {nivel: 2, id: this.infoEdit.id})
                    break;
                case 3:
                    const responseMateria = await axios.put(route('Materia.updateMateria', this.infoEdit))
                    this.showMessage(responseMateria.data.message, 'success')
                    this.$emit('reload', {nivel: 3, id: this.infoEdit.id})
                 break;
                case 4:
                    const responseProfesor = await axios.put(route('Profesor.updateProfesor', this.infoEdit))
                    this.showMessage(responseProfesor.data.message, 'success')
                    this.$emit('reload', {nivel: 4, id: this.infoEdit.id})
                    break;
                case 5:
                    const responseAlumno = await axios.put(route('Alumno.updateAlumno', this.infoEdit))
                    this.showMessage(responseAlumno.data.message, 'success')
                    this.$emit('reload', {nivel: 5, id: this.infoEdit.id})
                    break;
                }
            } catch (error) {
                this.showMessage(error.response.data.message, 'error')
            }
        },
        showMessage(text, type) {
            this.messAlert = text
            if (type === 'error') {
                this.showError = true
                setTimeout(() => {
                    this.showError = false
                }, 3000)
            } else if (type === 'success'){
                this.showSucces = true
                setTimeout(() => {
                    this.showSucces= false
                }, 3000)
            } 
        }
    },
};
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

.addProfesor{
    width: 100%;
    height: 30%;
    position: absolute;
    top: 0;
    left: 0;
    display: flex;
    justify-content: end;
    z-index: 100;
}

.intra-cont{
    width: 50%;
    height: 70%;
    background-color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 0px 0px 50px 50px;
    box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
}
</style>

