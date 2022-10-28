<template>
<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
      	<i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      	<router-link class="navbar-brand m-0" :to="{ name: 'Home' }">
			<img :src="'/img/logo.png'" class="navbar-brand-img h-100" alt="main_logo">
			<span class="ms-1 font-weight-bold">Control de Asistencia</span>
      	</router-link>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto " id="sidenav-collapse-main" style="height: inherit">
      	<ul class="navbar-nav">
			<li class="nav-item">
				<router-link class="nav-link" :to="{ name: 'Home' }">
        	    	<div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
						<i class="ni ni-chart-bar-32 text-primary text-sm opacity-10"></i>
        	    	</div>
        	    	<span class="nav-link-text ms-1">Dashboard</span>
        	  	</router-link>
        	</li>
        	<li class="nav-item">
				<router-link class="nav-link " :to="{ name: 'Centers' }">
					<div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
						<i class="ni ni-square-pin text-secondary text-sm opacity-10"></i>
					</div>
					<span class="nav-link-text ms-1">Centros</span>
				</router-link>
        	</li>
        	<li class="nav-item">
				<router-link class="nav-link " :to="{ name: 'Careers' }">
					<div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
						<i class="ni ni-building text-success text-sm opacity-10"></i>
					</div>
					<span class="nav-link-text ms-1">Carreras</span>
				</router-link>
        	</li>
        	<li class="nav-item">
				<router-link class="nav-link " :to="{ name: 'Courses' }">
					<div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
						<i class="ni ni-books text-danger text-sm opacity-10"></i>
					</div>
					<span class="nav-link-text ms-1">Cursos</span>
				</router-link>
        	</li>
        	<li class="nav-item">
				<router-link class="nav-link " :to="{ name: 'Sections' }">
					<div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
						<i class="ni ni-bold text-warning text-sm opacity-10"></i>
					</div>
					<span class="nav-link-text ms-1">Secciones</span>
				</router-link>
        	</li>
        	<li class="nav-item">
				<router-link class="nav-link " :to="{ name: 'Schedules' }">
					<div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
						<i class="fa fa-calendar text-info text-sm opacity-10"></i>
					</div>
					<span class="nav-link-text ms-1">Horarios</span>
				</router-link>
        	</li>
        	<li class="nav-item">
				<router-link class="nav-link " :to="{ name: 'Semesters' }">
					<div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
						<i class="ni ni-app text-dark text-sm opacity-10"></i>
					</div>
					<span class="nav-link-text ms-1">Semestres</span>
				</router-link>
        	</li>
			<li class="nav-item">
				<router-link class="nav-link " :to="{ name: 'Students' }">
					<div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
						<i class="ni ni-badge text-primary text-sm opacity-10"></i>
					</div>
					<span class="nav-link-text ms-1">Estudiantes</span>
				</router-link>
			</li>
			<li class="nav-item">
				  <router-link class="nav-link " :to="{ name: 'Teachers' }">
						<div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
							  <i class="fa fa-users text-secondary text-sm opacity-10"></i>
						</div>
						<span class="nav-link-text ms-1">Profesores</span>
				  </router-link>
			</li>
            <li class="nav-item">
                <router-link class="nav-link " :to="{ name: 'TeachersAssigned' }">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-user-plus text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Asignación de Profesores</span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link " :to="{ name: 'StudentAssigned' }">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-book-bookmark text-danger text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Asignación de Estudiantes</span>
                </router-link>
            </li>
        	<li class="nav-item">
        	  	<router-link class="nav-link " :to="{ name: 'Profile' }">
        	  	  	<div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
        	  	  	  	<i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
        	  	  	</div>
        	  	  	<span class="nav-link-text ms-1">Perfil</span>
        	  	</router-link>
        	</li>
      	</ul>
    </div>
</aside>
</template>
<script>
var win = navigator.platform.indexOf('Win') > -1;
if (win && document.querySelector('#sidenav-scrollbar')) {
  	var options = {
    	damping: '0.5'
  	}
  	Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
}
</script>
