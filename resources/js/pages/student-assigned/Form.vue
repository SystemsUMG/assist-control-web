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
                        <p class="text-uppercase text-sm">Información del Estudiante</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="career_assigned_id" class="form-control-label">Carrera</label>
                                    <select  id="career_assigned_id" class="form-select" @change="loadCourses($event)" v-model="data.career_assigned_id" :class="errors.career_assigned_id ? 'is-invalid' : ''">
                                        <option value="" disabled hidden>Seleccione una opción</option>
                                        <option v-for="assigned_career in assigned_careers" :value="assigned_career.id" :key="assigned_career.id">{{ assigned_career.career_name + ' - ' + assigned_career.center_name }}</option>
                                    </select>
                                    <small class="invalid-feedback">{{ errors.career_assigned_id ? errors.career_assigned_id[0] : '' }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="career_assigned_id" class="form-control-label">Profesor</label>
                                    <select  id="teachers" class="form-select" v-model="data.teacher_id" :class="errors.teacher_id ? 'is-invalid' : ''">
                                        <option value="" disabled hidden>Seleccione una opción</option>
                                        <option v-for="teacher in teachers" :value="teacher.id" :key="teacher.id">{{ teacher.name + ' - ' + teacher.last_name }}</option>
                                    </select>
                                    <small class="invalid-feedback">{{ errors.teacher_id ? errors.teacher_id[0] : '' }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="career_assigned_id" class="form-control-label">Curso</label>
                                    <select  id="courses" class="form-select" v-model="data.course_id" :class="errors.course_id ? 'is-invalid' : ''">
                                        <option value="" disabled hidden>Seleccione una opción</option>
                                        <option v-for="course in courses" :value="course.id" :key="course.id">{{ course.name }}</option>
                                    </select>
                                    <small class="invalid-feedback">{{ errors.course_id ? errors.course_id[0] : '' }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="career_assigned_id" class="form-control-label">Semestre</label>
                                    <select  id="semesters" class="form-select" v-model="data.semester_id" :class="errors.semester_id ? 'is-invalid' : ''">
                                        <option value="" disabled hidden>Seleccione una opción</option>
                                        <option v-for="semester in semesters" :value="semester.id" :key="semester.id">{{ semester.number +'-'+ semester.year}}</option>
                                    </select>
                                    <small class="invalid-feedback">{{ errors.semester_id ? errors.semester_id[0] : '' }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="career_assigned_id" class="form-control-label">Sección</label>
                                    <select  id="sections" class="form-select" v-model="data.section_id" :class="errors.section_id ? 'is-invalid' : ''">
                                        <option value="" disabled hidden>Seleccione una opción</option>
                                        <option v-for="section in sections" :value="section.id" :key="section.id">{{ section.letter }}</option>
                                    </select>
                                    <small class="invalid-feedback">{{ errors.section_id ? errors.section_id[0] : '' }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="career_assigned_id" class="form-control-label">Horario</label>
                                    <select  id="schedules" class="form-select" v-model="data.schedule_id" :class="errors.schedule_id ? 'is-invalid' : ''">
                                        <option value="" disabled hidden>Seleccione una opción</option>
                                        <option v-for="schedule in schedules" :value="schedule.id" :key="schedule.id">{{ schedule.begin_hour +' - '+ schedule.end_hour }}</option>
                                    </select>
                                    <small class="invalid-feedback">{{ errors.schedule_id ? errors.schedule_id[0] : '' }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total" class="form-control-label">Total de Asistencias</label>
                                    <input id="total" class="form-control" type="number" v-model="data.total_assists" :class="errors.total_assists ? 'is-invalid' : ''">
                                    <small class="invalid-feedback">{{ errors.total_assists ? errors.total_assists[0] : '' }}</small>
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
                career_assigned_id: '',
                teacher_id: '',
                course_id: '',
                semester_id: '',
                section_id: '',
                schedule_id: '',
                total_assists: '',
            },
            load: false,
            count: 0,
            url: '',
            assigned_careers: [],
            teachers: [],
            courses: [],
            semesters: [],
            sections: [],
            schedules: [],
            errors: {},
        }
    },
    computed: {
        OPEN: function() {
            let _this = this
            _this.loadData('assigned-careers')
            _this.loadData('teachers')
            _this.loadData('semesters')
            _this.loadData('sections')
            _this.loadData('schedules')
            if(_this.method == 'PUT') {
                axios({url: '/teacher-courses/' + _this.id, method: 'GET' })
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
        loadData(url = '', id = '') {
            let _this = this
            axios({url: url + '/' + id , method: 'GET'})
			.then((resp) => {
			    if(resp.data.records.length > 0) {
                    let records = resp.data.records
                    switch(url) {
                    case 'assigned-careers':
                        _this.assigned_careers = records
                        break;
                    case 'teachers':
                        _this.teachers = records
                        break;
                    case 'semesters':
                        _this.semesters = records
                        break;
                    case 'sections':
                        _this.sections = records
                        break;
                    case 'schedules':
                        _this.schedules = records
                        break;
                    case 'courses-list':
                        _this.courses = records
                        break;
                    default:
                        _this.assigned_careers = records
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
                    axios({url: '/teacher-courses' + method, method: 'POST', data: form })
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
