import { createRouter, createWebHistory } from "vue-router";
import Login from "./pages/auth/Login.vue";
import Home from "./pages/Home.vue";
import Users from "./pages/users/Index.vue";
import Profile from "./pages/profile/Profile.vue";
import Countries from "./pages/countries/Index.vue";
import Departments from "./pages/departments/Index.vue";
import Regions from "./pages/regions/Index.vue";
import Roles from "./pages/roles/Index.vue";
import Centers from "./pages/centers/Index.vue";
import Careers from "./pages/careers/Index.vue";
import Courses from "./pages/courses/Index.vue";
import Sections from "./pages/sections/Index.vue";
import Schedules from "./pages/schedules/Index.vue";
import Semesters from "./pages/semesters/Index.vue";
import NotFound from "./pages/NotFound.vue";

const routes = [
    {
        path: "/login",
        name: "Login",
        component: Login
    },
    {
        path: "/",
        name: "Home",
        component: Home
    },
    {
        path: "/usuarios",
        name: "Users",
        component: Users
    },
    {
        path: "/perfil",
        name: "Profile",
        component: Profile
    },
    {
        path: "/paises",
        name: "Countries",
        component: Countries
    },
    {
        path: "/departamentos",
        name: "Departments",
        component: Departments
    },
    {
        path: "/regiones",
        name: "Regions",
        component: Regions
    },
    {
        path: "/roles",
        name: "Roles",
        component: Roles
    },
    {
        path: "/centros",
        name: "Centers",
        component: Centers
    },
    {
        path: "/carreras",
        name: "Careers",
        component: Careers
    },
    {
        path: "/cursos",
        name: "Courses",
        component: Courses
    },
    {
        path: "/secciones",
        name: "Sections",
        component: Sections
    },
    {
        path: "/horarios",
        name: "Schedules",
        component: Schedules
    },
    {
        path: "/semestres",
        name: "Semesters",
        component: Semesters
    },
    {
        path: "/:catchAll(.*)",
        name: NotFound,
        component: NotFound
    }
];

const history = createWebHistory();

const router = createRouter(
    {
        history,
        routes,
    }
);

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token');
    if (to.name !== 'Login' && !token) {
        next({ name: 'Login' })
    } else if (to.name === 'Login' && token) {
        next({ name: 'Home' })
    } else {
        next()
    }
  })

export default router;