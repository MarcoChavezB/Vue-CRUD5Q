<template>
    <div class=" tableComp relative flex flex-col w-full h-full text-gray-700 bg-white shadow-lg rounded-xl bg-clip-border">
        <div class="relative mx-4 mt-4 overflow-hidden text-gray-700 bg-white rounded-none bg-clip-border">
            <div class="flex flex-col justify-between gap-8 mb-4 md:flex-row md:items-center">
                <div class="flex gap-2 ">
                    <button class="btn btn-neutral" @click="getUniversidad()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z"/>
                    <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466"/>
                    </svg></button>

                    <button class="btn btn-neutral" @click="showOptions = !showOptions">Agregar</button>

                    <div v-if="showOptions" class="list flex gap-2 justify-center items-center">
                        <button @click="fillObject(1)" class="btn btn-sm">Universidad</button>
                        <button @click="fillObject(2)" class="btn btn-sm">Carrera</button>
                        <button @click="fillObject(3)" class="btn btn-sm">Materia</button>
                        <button @click="fillObject(4)" class="btn btn-sm">Profesor</button>
                        <button @click="fillObject(5)" class="btn btn-sm">Alumno</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-6 px-0 overflow-scroll tb">
            <table class="w-full text-left table-auto min-w-max">
                <headTable v-if="infoData.length > 0" :headers="Object.keys(infoData[0])" />

                <tbody>
                    <rowTable 
                    @clickRow="goTo" 
                    @getOption="handleOption" 
                    v-for="data in infoData" :key="data.id"
                    :data="data" />
                </tbody>
            </table>
        </div>
    </div>
    <!-- v-if="showModal" -->
    <div v-if="showModal">
        <ModalCompModify 
        @reload="reloadPage" 
        @close="closeModal()" 
        @save="edit()" 
        :infoEdit="inforEdit" 
        :nivel="level"/>
    </div>

    <div v-if="showAdd">
        <Add
        @reload="reloadPage"
        :level="addLevel"
        @close = "showAdd = false"
         :infoAdd="addObject" />
    </div>

    <div class="alerts">
        <alertErrorVue v-if="showError" :message="messAlert" />
        <alertSuccesVue v-if="showSucces" :message="messAlert" />
    </div>
</template>

<script>
// crear el eliminar con inertinal 
// crear modales con inertial y mandarle el objeto que se manda por propiedad todo por inertial 
// -- Universidades - carreras - materias - profesores - alumnos
import PrimaryButton from '../PrimaryButton.vue'
import alertAdvertencia from '../Modals/alertAdvertencia.vue'
import rowTable from './rowTable.vue'
import headTable from './headTable.vue'
import ModalCompModify from '../Modals/modal.vue'
import Add from '../Modals/modalAdd.vue'
import alertErrorVue from '../Modals/alertError.vue';
import alertSuccesVue from '../Modals/alertSuccess.vue'; 

export default {
    components: {
        rowTable,
        headTable,
        PrimaryButton,
        ModalCompModify,
        Add,
        alertErrorVue,
        alertSuccesVue,
        alertAdvertencia
    },
    data() {
        return {
            infoData: [],
            inforEdit: [],
            addObject: [],
            level: 1,
            addLevel: 0,
            showModal: false,
            showAdd: false,
            showOptions: false,
            showError: false,
            showSucces: false,
            showAdvertencia: false,
        }
    },

    methods: {
        closeModal() {
            this.showModal = false
        },
        showMessage(text, type) {
            this.messAlert = text
            if (type === 'error') {
                this.showError = true
                setTimeout(() => {
                    this.showError = false
                }, 3000)
            } else if (type === 'succes') {
                this.showSucces = true
                setTimeout(() => {
                    this.showSucces= false
                }, 3000)
            }else if (type === 'advertencia') {
                this.showAdvertencia = true
                setTimeout(() => {
                    this.showAdvertencia= false
                }, 3000)
            }
        },


        // async renderModal(){
        //     try {
        //         const response = await axios.post(route('Modal.renderModal'))
        //         console.log(response)
        //     } catch (error) {
        //         this.showMessage(error, 'error')
        //     }
        // },
        
        async handleOption({ id, action }) {
            if (action && action.action === 'edit') {
                switch (this.level) {
                    case 1:
                        await this.getUniversidadById(id);
                        this.showModal = true
                        break;
                    case 2:
                        await this.getCarrera(id);
                        this.showModal = true
                        break;
                    case 3:
                        await this.getMateria(id);
                        this.showModal = true
                        break;
                    case 4:
                        await this.getProfesor(id);
                        this.showModal = true

                        break;
                    case 5:
                        await this.getAlumno(id);
                        this.showModal = true
                        break;
                }
            } else if (action && action.action === 'delete'){
                try {
                    switch (this.level) {
                    case 1:
                        const responseUniversidad = await axios.delete(route('Universidad.deleteUniversidad', { id: id }))
                        this.showMessage(responseUniversidad.data.message, 'succes')
                        console.log(id)
                        this.reloadPage({ nivel: 1, id: id })
                        break;
                    case 2:
                        console.log(id)
                        const responseCarrera = await axios.delete(route('Carrera.deleteCarrera', { id: id }))
                        this.showMessage(responseCarrera.data.message, 'succes')
                        this.reloadPage({ nivel: 2, id: id })
                        break;
                    case 3:
                        console.log(id)
                        const responseMateria = await axios.delete(route('Materia.deleteMateria', { id: id }))
                        this.showMessage(responseMateria.data.message, 'succes')
                        this.reloadPage({ nivel: 3, id: id })
                        break;
                    case 4:
                        console.log(id)
                        const responseProfesor = await axios.delete(route('Profesor.deleteProfesor', { id: id }))
                        this.showMessage(responseProfesor.data.message, 'succes')
                        this.reloadPage({ nivel: 4, id: id })
                        break;
                    case 5:
                        console.log(id)
                        const responseAlumno = await axios.delete(route('Alumno.deleteAlumno', { id: id }))
                        this.showMessage(responseAlumno.data.message, 'succes')
                        this.reloadPage({ nivel: 5, id: id })
                        break;
                    }
                } catch (error) {
                    this.showMessage(error, 'error')   
                }
            }
        },

        // recargar pagina cuando se modifica 
        reloadPage({ nivel ,id }){
            switch (nivel) {
                case 1:
                    this.getUniversidad()
                    break;
                case 2:
                    this.getCarreraById(id)
                    console.log(id)
                    break;
                case 3:
                    this.getMateriasById(id)
                    break;
                case 4:
                    this.getProfesoresById(id)
                    break;
                case 5:
                    this.getAlumnosById(id)
                    break;
            }
        },  
        goTo(id) {
            switch (this.level) {
                case 1:
                    this.getCarreraById(id)
                    this.level++
                    break;
                case 2:
                    this.getMateriasById(id)
                    this.level++
                    break;
                case 3:
                    this.getProfesoresById(id)
                    this.level++
                    break;
                case 4:
                    this.getAlumnosById(id)
                    this.level++
                    break;
            }
        },
        // * Peticiones AXIOS
        async getUniversidad() {
            try {
                this.level = 1
                const responseUniversidad = await axios.get(route('Universidad.index'))
                this.infoData = responseUniversidad.data
            } catch (error) {
                console.error(error)
            }
        },
        async getCarreraById(id) {
            try {
                const responseCarrera = await axios.get(route('Carrera.getCarreras', { id: id }))
                this.infoData = responseCarrera.data;
            } catch (error) {
                console.error(error);
            }
        },
        async getMateriasById(id) {
            try {
                const responseCarrera = await axios.get(route('Materia.getMaterias', { id: id }))
                this.infoData = responseCarrera.data;
            } catch (error) {
                console.error(error);
            }
        },
        async getProfesoresById(id) {
            try {
                const responseProfesores = await axios.get(route('Profesor.getProfesores', { id: id }))
                this.infoData = responseProfesores.data;
            } catch (error) {
                console.error(error);
            }
        },
        async getAlumnosById(id) {
            try {
                const responseAlumnos = await axios.get(route('Alumno.getAlumnos', { id: id }))
                this.infoData = responseAlumnos.data;
            } catch (error) {
                console.error(error);
            }
        },


        /* 
            infoEdit para mandar la peticion con la informacion de la peticion
            realizar una peticion con inertia para renderizar el modal modify con su informacion pasandola
            por props
        */

        async getUniversidadById(id) {
            try {
                const response = await axios.get(route('Universidad.getUniversidad', { id: id }))
                this.inforEdit = response.data
            } catch (error) {
                console.error(error);
            }
        },
        async getCarrera(id) {
            try {
                const response = await axios.get(route('Carrera.getCarrera', { id: id }))
                this.inforEdit = response.data
            } catch (error) {
                console.error(error);
            }
        },
        async getMateria(id) {
            try {
                const response = await axios.get(route('Materia.getMateria', { id: id }))
                this.inforEdit = response.data
            } catch (error) {
                console.error(error);
            }
        },
        async getProfesor(id) {
            try {
                const response = await axios.get(route('Profesor.getProfesor', { id: id }))
                this.inforEdit = response.data
            } catch (error) {
                console.error(error);
            }
        },
        async getAlumno(id) {
            try {
                const response = await axios.get(route('Alumno.getAlumno', { id: id }))
                this.inforEdit = response.data
            } catch (error) {
                console.error(error);
            }
        },
        showModalAdd(){
            this.showOptions = false
            this.showAdd = true
        },
        fillObject(type) {
            switch (type) {
                case 1:
                    this.addLevel = 1
                    this.addObject = {
                        "nombre": "",
                        "direccion": "",
                        "telefono": "",
                        "email": "",
                        "web": "",
                        "logo": "",
                        "estado": ""
                    }
                    this.showModalAdd()
                    break;
                case 2:
                this.addLevel = 2
                    this.addObject = {
                        "nombre": "",
                        "descripcion": "",
                        "creditos": "",
                        "duracion": "",
                        "certificada": "",
                        "logo": "",
                        "universidad": ""
                    }
                    this.showModalAdd()

                    break;
                case 3:
                this.addLevel = 3
                    this.addObject = {
                        "nombre": "",
                        "carrera": "",
                        "codigo": "",
                        "especialidad": "",
                        "descripcion": "",
                        "creditos": "",
                        "codigo": "",
                        "horas": ""
                    }
                    this.showModalAdd()
                    break;
                case 4:
                this.addLevel = 4
                    this.addObject = {
                        "nombre": "",
                        "apellido": "",
                        "email": "",
                        "telefono": "",
                        "direccion": "",
                        "foto": "",
                        "matricula": "",
                        "materia": "",
                        "campo": "",
                    }
                    this.showModalAdd()

                    break;
                case 5:
                this.addLevel = 5
                    this.addObject = {
                        "nombre": "",
                        "apellido": "",
                        "email": "",
                        "telefono": "",
                        "direccion": "",
                        "grado": "",
                        "foto": "",
                        "matricula": "",
                        "profesor": ""
                    }
                    this.showModalAdd()

                    break;
            }
        }

    },
    mounted() {
        this.getUniversidad()
    }
}
</script>


<style scoped>
.tableComp {
    max-height: 90vh;
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

.tb{
    max-height: 70vh;
    overflow-y: auto;
    overflow-x: auto;
    min-height: 70vh;
    min-width: 90vw;
}
</style>