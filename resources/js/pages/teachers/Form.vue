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
                        <p class="text-uppercase text-sm">Información del Profesor</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-control-label">Nombre</label>
                                    <input id="name" class="form-control" type="text" v-model="data.name" :class="errors.name ? 'is-invalid' : ''">
                                    <small class="invalid-feedback">{{ errors.name ? errors.name[0] : '' }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name" class="form-control-label">Apellido</label>
                                    <input id="last_name" class="form-control" type="text" v-model="data.last_name" :class="errors.last_name ? 'is-invalid' : ''">
                                    <small class="invalid-feedback">{{ errors.last_name ? errors.last_name[0] : '' }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-control-label">Correo</label>
                                    <input id="email" class="form-control" type="email" v-model="data.email" :class="errors.email ? 'is-invalid' : ''">
                                    <small class="invalid-feedback">{{ errors.email ? errors.email[0] : '' }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="form-control-label">Contraseña</label>
                                    <input id="password" class="form-control" type="password" v-model="data.password" :class="errors.password ? 'is-invalid' : ''">
                                    <small class="invalid-feedback">{{ errors.password ? errors.password[0] : '' }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="form-control-label">Teléfono</label>
                                    <input id="phone" class="form-control" type="text" v-model="data.phone" :class="errors.phone ? 'is-invalid' : ''">
                                    <small class="invalid-feedback">{{ errors.phone ? errors.phone[0] : '' }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address" class="form-control-label">Direccion</label>
                                    <input id="address" class="form-control" type="text" v-model="data.address" :class="errors.address ? 'is-invalid' : ''">
                                    <small class="invalid-feedback">{{ errors.address ? errors.address[0] : '' }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="active" class="form-control-label">Estado</label>
                                    <select  id="active" class="form-select" v-model="data.active" :class="errors.active ? 'is-invalid' : ''">
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                    <small class="invalid-feedback">{{ errors.active ? errors.active[0] : '' }}</small>
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
                name: '',
                last_name: '',
                email: '',
                password: '',
                address: '',
                phone: '',
                active: '',
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
                axios({url: '/teachers/' + _this.id, method: 'GET' })
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
                    axios({url: '/teachers' + method, method: 'POST', data: form })
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
