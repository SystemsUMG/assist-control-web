<template>
  	<div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          	<div class="card">
            	<div class="card-body p-3">
              		<div class="row">
                		<div class="col-8">
							<div class="numbers">
								<p class="text-sm mb-0 text-uppercase font-weight-bold">Usuarios</p>
								<h5 class="font-weight-bolder">{{ totals.total_users }}</h5>
							</div>
                		</div>
                		<div class="col-4 text-end">
                  			<div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                    			<i class="ni ni-single-02 text-lg opacity-10" aria-hidden="true"></i>
                  			</div>
                		</div>
              		</div>
            	</div>
        	</div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        	<div class="card">
            	<div class="card-body p-3">
              		<div class="row">
                		<div class="col-8">
                  			<div class="numbers">
                    			<p class="text-sm mb-0 text-uppercase font-weight-bold">Países</p>
                    			<h5 class="font-weight-bolder">{{ totals.total_countries }}</h5>
                  			</div>
                		</div>
                		<div class="col-4 text-end">
                  			<div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                    			<i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                  			</div>
                		</div>
              		</div>
            	</div>
        	</div>
    	</div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          	<div class="card">
            	<div class="card-body p-3">
              		<div class="row">
              		  	<div class="col-8">
              		    	<div class="numbers">
              		      		<p class="text-sm mb-0 text-uppercase font-weight-bold">Departamentos</p>
              		      		<h5 class="font-weight-bolder">{{ totals.total_departments }}</h5>
              		    	</div>
              		  	</div>
              			<div class="col-4 text-end">
							<div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
								<i class="ni ni-square-pin text-lg opacity-10" aria-hidden="true"></i>
							</div>
           				</div>
        			</div>
            	</div>
          	</div>
        </div>
        <div class="col-xl-3 col-sm-6">
          	<div class="card">
          	  	<div class="card-body p-3">
          	  	  	<div class="row">
          	  	  	  	<div class="col-8">
          	  	  	  	  	<div class="numbers">
          	  	  	  	  	  	<p class="text-sm mb-0 text-uppercase font-weight-bold">Regiones</p>
          	  	  	  	  	  	<h5 class="font-weight-bolder">{{ totals.total_departments }}</h5>
          	  	  	  	  	</div>
          	  	  	  	</div>
          	  	  	  	<div class="col-4 text-end">
          	  	  	  	  	<div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
          	  	  	  	    	<i class="ni ni-world-2 text-lg opacity-10" aria-hidden="true"></i>
          	  	  	  	  	</div>
          	  	  	  	</div>
          	  	  	</div>
          		</div>
          	</div>
        </div>
	</div>
    <div class="row mt-4">
        <div class="col-lg-6 mb-lg-0 mb-4">
			<div class="card z-index-2 h-100">
				<div class="card-header p-0 pt-3 position-relative mx-3 z-index-2 bg-transparent">
                    <h6 class="text-capitalize">Estudiantes</h6>
					<div class="row align-items-center">
                        <div class="col-md-5 p-1">
                            <div class="form-group mb-0">
                                <label for="student" class="form-control-label">Estudiante</label>
								<select  id="student" class="form-select" v-model="student.student_id" :class="errors.students ? 'is-invalid' : ''" required>
                                    <option value="">Seleccione una opción</option>
                                    <option v-for="student in students" :value="student.id" :key="student.id">{{ student.name + ' ' + student.last_name }}</option>
                                </select>
                                <small class="invalid-feedback">{{ errors.students ? errors.students : '' }}</small>
                            </div>
                        </div>
						<div class="col p-1 text-end">
                            <button type="button" @click="getGraphicsData('student')" class="btn btn-dark btn-sm mb-0">
								<i class="fa fa-search text-white text-sm opacity-10"></i>
							</button>
                        </div>
					</div>
                    <hr class="dark horizontal">
                    <div class="d-flex ">
                    	<p class="mb-0 text-sm">Asistencia de Estudiantes por Fecha</p>
                	</div>
            	</div>
            	<div class="card-body p-3">
					<div class="border-radius-lg py-3 pe-1">
                    	<div class="chart">
                            <line-chart :labels="labels.student" :values="values.student" v-if="show" style="height: 170px"/>
                		</div>
                    </div>
            	</div>
          	</div>
        </div>
        <div class="col-lg-6 mb-lg-0 mb-4">
			<div class="card z-index-2 h-100">
				<div class="card-header p-0 pt-3 position-relative mx-3 z-index-2 bg-transparent">
                    <h6 class="text-capitalize">Estudiantes</h6>
					<div class="row align-items-center">
                        <div class="col-md-5 p-1">
                            <div class="form-group mb-0">
                                <label for="student" class="form-control-label">Estudiante</label>
								<select  id="student" class="form-select" v-model="student.student_id" :class="errors.students ? 'is-invalid' : ''" required>
                                    <option value="">Seleccione una opción</option>
                                    <option v-for="student in students" :value="student.id" :key="student.id">{{ student.name + ' ' + student.last_name }}</option>
                                </select>
                                <small class="invalid-feedback">{{ errors.students ? errors.students : '' }}</small>
                            </div>
                        </div>
						<div class="col p-1 text-end">
                            <button type="button" @click="getGraphicsData('student')" class="btn btn-dark btn-sm mb-0">
								<i class="fa fa-search text-white text-sm opacity-10"></i>
							</button>
                        </div>
					</div>
                    <hr class="dark horizontal">
                    <div class="d-flex ">
                    	<p class="mb-0 text-sm">Asistencia de Estudiantes por Fecha</p>
                	</div>
            	</div>
            	<div class="card-body p-3">
					<div class="border-radius-lg py-3 pe-1">
                    	<div class="chart">
                            <line-chart :labels="labels.student" :values="values.student" v-if="show" style="height: 170px"/>
                		</div>
                    </div>
            	</div>
          	</div>
        </div>
	</div>
    <div class="row mt-4">
        <div class="col-lg-6 mb-lg-0 mb-4">
			<div class="card z-index-2 h-100">
				<div class="card-header p-0 pt-3 position-relative mx-3 z-index-2 bg-transparent">
                    <h6 class="text-capitalize">Semestres</h6>
					<div class="row align-items-center">
                        <div class="col-md-5 p-1">
                            <div class="form-group mb-0">
                                <label for="career" class="form-control-label">Carrera</label>
								<select  id="career" class="form-select" v-model="semester.career_id" :class="errors.semesters.career ? 'is-invalid' : ''" required>
                                    <option value="">Seleccione una opción</option>
                                    <option v-for="career in careers" :value="career.id" :key="career.id">{{ career.name }}</option>
                                </select>
                                <small class="invalid-feedback">{{ errors.semesters.career ? errors.semesters.career : '' }}</small>
                            </div>
                        </div>
                        <div class="col-md-4 p-1">
                            <div class="form-group mb-0">
                                <label for="semester" class="form-control-label">Semestre</label>
								<select  id="semester" class="form-select" v-model="semester.semester_id" :class="errors.semesters.semester ? 'is-invalid' : ''" required>
                                    <option value="">Seleccione una opción</option>
                                    <option v-for="semester in semesters" :value="semester.id" :key="semester.id">{{ semester.number + '-' + semester.year }}</option>
                                </select>
                                <small class="invalid-feedback">{{ errors.semesters.semester ? errors.semesters.semester : '' }}</small>
                            </div>
                        </div>
						<div class="col p-1 text-end">
                            <button type="button" @click="getGraphicsData('semester')" class="btn btn-dark btn-sm mb-0">
								<i class="fa fa-search text-white text-sm opacity-10"></i>
							</button>
                        </div>
					</div>
                    <hr class="dark horizontal">
                    <div class="d-flex ">
                    	<p class="mb-0 text-sm">Asistencia de Carreras por Semestre</p>
                	</div>
            	</div>
            	<div class="card-body p-3">
					<div class="border-radius-lg py-3 pe-1">
                    	<div class="chart">
                            <line-chart :labels="labels.semester" :values="values.semester" v-if="show" style="height: 170px"/>
                		</div>
                    </div>
            	</div>
          	</div>
        </div>
        <div class="col-lg-6 mb-lg-0 mb-4">
			<div class="card z-index-2 h-100">
				<div class="card-header p-0 pt-3 position-relative mx-3 z-index-2 bg-transparent">
                    <h6 class="text-capitalize">Centros</h6>
					<div class="row align-items-center">
                        <div class="col-md-5 p-1">
                            <div class="form-group mb-0">
                                <label for="center" class="form-control-label">Centro</label>
								<select  id="center" class="form-select" v-model="center.center_id" :class="errors.centers ? 'is-invalid' : ''" required>
                                    <option value="">Seleccione una opción</option>
                                    <option v-for="center in centers" :value="center.id" :key="center.id">{{ center.name }}</option>
                                </select>
                                <small class="invalid-feedback">{{ errors.centers ? errors.centers : '' }}</small>
                            </div>
                        </div>
						<div class="col p-1 text-end">
                            <button type="button" @click="getGraphicsData('center')" class="btn btn-dark btn-sm mb-0">
								<i class="fa fa-search text-white text-sm opacity-10"></i>
							</button>
                        </div>
					</div>
                    <hr class="dark horizontal">
                    <div class="d-flex ">
                    	<p class="mb-0 text-sm">Asistencia por Centro</p>
                	</div>
            	</div>
            	<div class="card-body p-3">
					<div class="border-radius-lg py-3 pe-1">
                    	<div class="chart">
                            <line-chart :labels="labels.center" :values="values.center" v-if="show" style="height: 170px"/>
                		</div>
                    </div>
            	</div>
          	</div>
        </div>
	</div>
</template>

<script>
import LineChart from './charts/LineChart.vue'
import BarChart from './charts/BarChart.vue'

export default {
  	components: { LineChart, BarChart },
	data() {
		return {
			icon: '',
            message: '',
            totals: '',
            loader: {},
			show: false,
			data: {},
			labels: {
				student: [],
				semester: [],
				center: [],
			},
			values: {
				student: [],
				semester: [],
				center: [],
			},
			students: [],
			semesters: [],
			centers: [],
			careers: [],
			student: {
                student_id: '',
            },
			semester: {
				semester_id: '',
                career_id: '',
            },
			center: {
				center_id: '',
			},
			errors: {
				students: '',
				semesters: {
					career: '',
					semester: ''
				},
				centers: '',
			}
        }
    },
	mounted() {
		this.loadData('students')
		this.loadData('semesters')
		this.loadData('careers')
		this.loadData('centers')
		this.loadGraphics()
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
		loadData(url = '') {
            let _this = this
            axios({url: url , method: 'GET'})
			.then((resp) => {
			    if(resp.data.records.length > 0) {
                    let records = resp.data.records
                    switch(url) {
                    case 'students':
                        _this.students = records
                        break;
                    case 'semesters':
                        _this.semesters = records
                        break;
                    case 'careers':
                        _this.careers = records
                        break;
                    case 'centers':
                        _this.centers = records
                        break;
                    default:
                        _this.students = records
                    } 
				} else {
					_this.icon = 'error'
					_this.message = 'No existen ' + url + ' registrados'
					_this.showToast(_this.icon, _this.message)
				}
			}).catch((err) => {
				_this.showToast(_this.icon)
			})
        },
        loadGraphics(){
			let _this = this
			_this.showLoader(true)

			setTimeout(
				function() {
					axios({url: 'statistics/graphics' , method: 'GET'})
					.then((resp) => {
						if(resp.data.records.countries.length > 0) {
							// _this.labels = resp.data.records.countries
							// _this.values = resp.data.records.users_real
							_this.totals = resp.data.records.totals
							_this.show = true
							_this.icon = 'success'
							_this.message = resp.data.message
						} else {
							_this.icon = 'warning'
							_this.message = 'No existen registros'
						}
						_this.showToast(_this.icon, _this.message)
					}).catch((err) => {
						_this.icon = 'error'
						_this.showToast(_this.icon)
					})
					_this.showLoader(false)
				},
				300
			)
        },
		getGraphicsData(url = '') {
			let _this = this
			let valid = false
			switch(url) {
                case 'student':
					if (!_this.student.student_id) {
						_this.errors.students = 'Estudiante requerido'
					} else {
						valid = true
						_this.errors.students = ''
						_this.data = _this.student
					}
                    break;
                case 'semester':
					if (!_this.semester.career_id) {
						_this.errors.semesters.career = 'Carrera requerida'
					} else if (!_this.semester.semester_id) {
						_this.errors.semesters.semester = 'Semestre requerido'
					} else {
						valid = true
						_this.errors.semesters = ''
						_this.data = _this.semester
					}
                    break;
				case 'center':
					if (!_this.center.center_id) {
						_this.errors.centers = 'Centro requerido'
					} else {
						valid = true
						_this.errors.centers = ''
						_this.data = _this.center
					}
                    break;
                default:
                    _this.errors = {}
					valid = true
            }

			if (valid) {
				let form = _this.addFormData(_this.data)
				console.log(form)
				axios({url: 'statistics/' + url , method: 'POST', data: form})
				.then((resp) => {
					if(resp.data.result > 0) {
						let records = resp.data.records
						switch(url) {
						case 'student':
							_this.labels.student = records.dates
							_this.values.student = records.attendances
							break;
						case 'semester':
							_this.labels.semester = records.courses
							_this.values.semester = records.attendances
							break;
						case 'center':
							_this.labels.center = records.careers
							_this.values.center = records.attendances
							break;
						default:
							_this.students = records
						}
					} else {
						_this.icon = 'error'
						_this.message = 'No existen datos registrados'
						_this.showToast(_this.icon, _this.message)
					}
				}).catch((err) => {
					_this.showToast(_this.icon)
				})
			}
		},
		addFormData(data = {}) {
			let form = new FormData()
			$.each(data, function(key, item) {
                    if(item != null){
                        form.append(key, item)
                    }
                })
			return form
		}
	}
}
</script>
