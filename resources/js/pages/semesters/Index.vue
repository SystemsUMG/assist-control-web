<template>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col">
                            <h6>Tabla de Semestres</h6>
                        </div>
                        <div class="col text-end">
                            <button type="button" @click="OPEN('POST')" class="btn btn-dark btn-sm mb-3">Crear Semestre</button>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Número</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Año</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha Inicio</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha Fin</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                            </tr>
                            </thead>
                            <tbody v-if="show">
                            <tr v-for="semester in semesters" :key="semester.id">
                                <td>
                                    <div class="px-3">
                                        <span class="text-secondary text-xs font-weight-bold ">{{ semester.number }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="px-3">
                                        <span class="text-secondary text-xs font-weight-bold ">{{ semester.year }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="px-3">
                                        <span class="text-secondary text-xs font-weight-bold ">{{ semester.begin_date }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="px-3">
                                        <span class="text-secondary text-xs font-weight-bold ">{{ semester.end_date }}</span>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <a  class="text-success font-weight-bold text-xs cursor-pointer"  @click="OPEN('PUT', semester.id)">Editar</a>
                                    &nbsp;
                                    <a class="text-danger font-weight-bold text-xs cursor-pointer" @click="OPEN('DELETE', semester.id)">Eliminar</a>
                                </td>
                            </tr>
                            </tbody>
                            <tbody v-else>
                            <tr>
                                <td class="text-center py-5" colspan="6">
                                    <p>No hay semestres registrados</p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <data-form v-if="get_open" :open="get_open" :method="method" :id="id" @close="loadData()"/>
    <data-delete v-if="get_delete" :open="get_delete" :id="id" @close="loadData()"/>
</template>
<script>
import axios from "axios";
import DataForm from './Form.vue';
import DataDelete from './Delete.vue';
export default {
    components: { DataForm, DataDelete },
    data() {
        return {
            semesters: [],
            icon: '',
            message: '',
            loader: {},
            show: false,
            get_delete: false,
            get_open: false,
            method: '',
            id: ''
        }
    },
    mounted() {
        this.loadData()
    },
    methods: {
        showToast(icon = "error", message = "Ocurrió un error, por favor vuelva a intentar") {
            const Toast = this.$swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', this.$swal.stopTimer)
                    toast.addEventListener('mouseleave', this.$swal.resumeTimer)
                }
            })
            Toast.fire({
                icon: icon,
                title: message
            })
        },
        showLoader(show = false) {
            if (show) {
                this.loader = this.$loading.show({
                    container:  null,
                    canCancel: false,
                    color: '#000000',
                    backgroundColor: '#808080'
                })
            } else {
                this.loader.hide()
            }
        },
        loadData(){
            let _this = this

            _this.get_delete = false
            _this.get_open = false
            _this.showLoader(true)

            setTimeout(
                function() {
                    axios({url: 'semesters' , method: 'GET'})
                        .then((resp) => {
                            if(resp.data.records.length > 0) {
                                _this.show = true
                                _this.semesters = resp.data.records
                                _this.icon = 'success'
                                _this.message = resp.data.message
                            } else {
                                _this.icon = 'warning'
                                _this.message = 'No existen registros'
                                _this.showToast(_this.icon, _this.message)
                            }
                        }).catch((err) => {
                        _this.icon = 'error'
                        _this.showToast(_this.icon)
                    })
                    _this.showLoader(false)
                },
                300
            )
        },
        OPEN: function(method, id = null){
            this.method = method
            this.id = id
            if(method == 'DELETE') {
                this.get_delete = true
            } else {
                this.get_open = true
            }
        }
    }
}
</script>
