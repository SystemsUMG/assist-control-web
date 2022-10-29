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
                        <p class="text-uppercase text-sm">Asignación de Estudiantes</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="teacher_course" class="form-control-label">Curso</label>
                                    <select  id="teacher_course" class="form-select" v-model="data.teacher_course_assigned_id" :class="errors.teacher_course_assigned_id ? 'is-invalid' : ''" :disabled="method == 'PUT'">
                                        <option value="" disabled hidden>Seleccione una opción</option>
                                        <option v-for="teacher_course in teacher_courses" :value="teacher_course.id" :key="teacher_course.id">{{ teacher_course.course.name + '-' + teacher_course.section.letter  + ' ' + teacher_course.career_assigned.center.name }}</option>
                                    </select>
                                    <small class="invalid-feedback">{{ errors.teacher_course_assigned_id ? errors.teacher_course_assigned_id[0] : '' }}</small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="students" class="form-control-label">Estudiantes</label>
                                    <Multiselect id="students" v-model="data.students_assigned" :options="students" mode="tags" :searchable="true" :close-on-select="false" :object="true" :class="errors.students_assigned ? 'is-invalid' : ''"/>
                                    <small class="invalid-feedback">{{ errors.students_assigned ? errors.students_assigned[0] : '' }}</small>
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
import Multiselect from '@vueform/multiselect'

export default {
    components: { Multiselect },
    props: ['open', 'method', 'id'],
    data(){
        return {
            icon: '',
            message: '',
            loader: {},
            data: {
                teacher_course_assigned_id: '',
                students_assigned: [],
            },
            load: false,
            count: 0,
            url: '',
            errors: {},
            teacher_courses : [],
            students: [{
                value: '',
                label: ''
            }]
        }
    },
    computed: {
        OPEN: function() {
            let _this = this
            _this.loadData('students')
            _this.loadData('teacher-courses')
            if(_this.method == 'PUT') {
                axios({url: '/teacher-courses/' + _this.id, method: 'GET' })
                    .then((resp) => {
                        if (resp.data.result) {
                            _this.data.teacher_course_assigned_id = resp.data.records.id
                            resp.data.records.students_assigned.map(function(item, key) {
                                let name =  item.student.carnet + ' ' + item.student.name + ' ' + item.student.last_name 
                                _this.data.students_assigned.push({value: item.student.id, label: name})
                            })
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
        loadData(url = '', id = '') {
            let _this = this
            axios({url: url + '/' + id , method: 'GET'})
			.then((resp) => {
			    if(resp.data.records.length > 0) {
                    let records = resp.data.records
                    switch(url) {
                    case 'students':
                        resp.data.records.map(function(item, key) {
                            let name = item.carnet  + ' - ' + item.name  + ' ' + item.last_name
                            _this.students.push({value: item.id, label: name })
                        })
                        break;
                    case 'teacher-courses':
                        _this.teacher_courses = resp.data.records 
                        break;
                    default:
                            _this.students = records
                    }
					_this.icon = 'success'
					_this.message = resp.data.message
				} else {
					_this.icon = 'error'
					_this.message = 'No existen ' + url + ' registrados'
                    //_this.CLOSE()
				    _this.showToast(_this.icon, _this.message)
				}
			}).catch((err) => {
				_this.showToast(_this.icon)
                _this.CLOSE()
			})
        },
        loadCourses (event) {
            this.courses = []
            this.loadData('courses-list', event.target.value)
        },
        CLOSE: function(){
            this.$emit('close')
        },
        SEND: function(){
            let _this = this
            _this.count++
            _this.load = true

            let method = _this.method == 'PUT' ? '/' + _this.id : ''

            if(_this.count == 1){
                let form = new FormData()
                $.each(this.data, function(key, item) {
                    if(item != null){
                        //Obtener value de objeto para careers assignments
                        if (key == "students_assigned") {
                            let students_assigned = []
                            item.map(function(element) {
                                students_assigned.push(element.value)
                            })
                            form.append(key, students_assigned)
                        } else {
                            form.append(key, item)
                        }
                    }
                })
                if(this.method == 'PUT'){
                    form.append('_method', 'PUT')
                }
                this.errors = []
                setTimeout(function() {
                    axios({url: '/student-courses' + method, method: 'POST', data: form })
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
