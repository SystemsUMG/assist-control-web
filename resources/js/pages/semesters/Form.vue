<template>
    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" :class="OPEN == true ? 'd-block show' : ''">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form @submit.prevent="SEND()">
                    <div class="d-flex align-items-start px-3">
                        <button type="button " class="btn-close text-dark" @click="CLOSE()">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body pt-0 px-4">
                        <hr class="horizontal dark"/>
                        <p class="text-uppercase text-sm">Información del Semestre</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="number" class="form-control-label">Número de Semestre</label>
                                    <input id="number" class="form-control" type="number" min="0" v-model="data.number" :class="errors.number ? 'is-invalid' : ''">
                                    <small class="invalid-feedback">{{ errors.number ? errors.number[0] : '' }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="year" class="form-control-label">Año</label>
                                    <input id="year" class="form-control" type="number" min="1900" max="2099" v-model="data.year" :class="errors.year ? 'is-invalid' : ''">
                                    <small class="invalid-feedback">{{ errors.year ? errors.year[0] : '' }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="begin_date" class="form-control-label">Fecha de Inicio</label>
                                    <input id="begin_date" class="form-control" type="date" v-model="data.begin_date" :class="errors.begin_date ? 'is-invalid' : ''">
                                    <small class="invalid-feedback">{{ errors.begin_date ? errors.begin_date[0] : '' }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_date" class="form-control-label">Fecha de Fin</label>
                                    <input id="end_date" class="form-control" type="date" v-model="data.end_date" :class="errors.end_date ? 'is-invalid' : ''">
                                    <small class="invalid-feedback">{{ errors.end_date ? errors.end_date[0] : '' }}</small>
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <div class="row justify-content-center">
                            <div class="col mb-2 me-0 text-end">
                                <button @click="CLOSE()" type="button" class="btn btn-secondary btn-sm ms-auto mt-2 mb-0">
                                    <i class="fas fa-times"></i>
                                    <span class="ms-2">Cancelar</span>
                                </button>
                            </div>
                            <div class="col mb-2 ms-0 text-start">
                                <button type="submit" class="btn btn-primary btn-sm ms-auto mt-2 mb-0">
                                    <i class="fas fa-spinner fa-spin me-2" v-if="load"></i>
                                    <span>Guardar</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['open', 'method', 'id'],
    data(){
        return {
            icon: '',
            message: '',
            loader: {},
            data: {
                number: '',
                year: '',
                begin_date: '',
                end_date: '',
            },
            load: false,
            count: 0,
            url: '',
            errors: {},
        }
    },
    computed: {
        OPEN: function() {
            let _this = this
            if(_this.method == 'PUT') {
                axios({url: '/semesters/' + _this.id, method: 'GET' })
                    .then((resp) => {
                        if (resp.data.result) {
                            _this.data = resp.data.records
                        } else {
                            _this.showToast('error', resp.data.message)
                            _this.CLOSE()
                        }
                    })
                    .catch((err) => {
                        _this.CLOSE()
                        _this.showToast()
                    })
            }
            return _this.open
        },
    },
    methods:{
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
        CLOSE: function(){
            this.$emit('close')
        },
        SEND: function(){
            let _this = this
            _this.count++
            _this.load = true

            let method = _this.method == 'PUT' ? '/' + _this.data.id : ''

            if(_this.count == 1){
                let form = new FormData()
                $.each(this.data, function(key, item) {
                    if(item != null){
                        form.append(key, item)
                    }
                })
                if(this.method == 'PUT'){
                    form.append('_method', 'PUT')
                }
                this.errors = []
                setTimeout(function() {
                    axios({url: '/semesters' + method, method: 'POST', data: form })
                        .then((resp) => {
                            if(resp.data.result) {
                                _this.icon = 'success'
                                _this.message = resp.data.message
                                _this.CLOSE()
                                _this.showToast(_this.icon, _this.message)
                            } else {
                                _this.icon = 'error'
                                _this.message = resp.data.message.split("(")[0]
                                _this.showToast(_this.icon, _this.message)
                            }
                            _this.load = false
                            _this.count = 0
                        }).catch((err) => {
                            if(err.response.status === 422){
                                _this.errors = err.response.data.errors
                            }
                            _this.icon = 'error'
                            _this.message = err.response.data.message.split("(")[0]
                            _this.load = false
                            _this.count = 0
                            _this.showToast(_this.icon, _this.message)
                        })
                }, 1000)
            }
        }
    }
}
</script>
