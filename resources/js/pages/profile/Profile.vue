<template>
<div class="row justify-content-center">
    <div class="col-12 col-md-8 container">
        <div class="card mx-5">
            <img :src="'/img/bg1.jpg'" alt="Image placeholder" class="card-img-top">
        	<div class="row justify-content-center">
				<div class="col-4 col-lg-4 order-lg-2">
					<div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
						<img :src="'/img/user.svg'"  class="rounded-circle img-fluid border border-2 border-white">
					</div>
				</div>
    		</div>
    		<div class="card-body pt-0">
        		<div class="text-center mt-4">
                    <span class="badge bg-primary" v-if="user.active == '1'">Activo</span>
                    <span class="badge bg-danger" v-else>Inactivo</span>
            		<h5 class="mt-4">{{ user.name }}</h5>
					<h6 class="font-weight-300">{{ user.email }}</h6>
					<p class="mt-2 mb-0">{{ user.address }}</p>
					<h6>Teléfono: {{ user.phone }}</h6>
        		</div>
    		</div>
		</div>
    </div>
</div>
</template>
<script>
export default {
	data() {
		return {
			icon: '',
			message: '',
			loader: {},
			id: '',
			user: {
				name: '',
				last_name: '',
				email: '',
				address: '',
				phone: '',
				active: '' 
			},
			roles: [],
            departments: [],
            regions: [],
            countries: [],
		}
	},
	mounted() {
		this.loadUser()
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
		loadUser() {
			let _this = this
			_this.showLoader(true)

			_this.id = localStorage.getItem('user')
			setTimeout(
				function() {
					axios({url: '/teachers/' + _this.id, method: 'GET'})
					.then((resp) => {
						if(resp.data.result) {
							_this.user = resp.data.records
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
        }
	}
}
</script>
