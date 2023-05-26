import {createRouter, createWebHistory} from 'vue-router'
import HomeView from '../views/HomeView.vue'
import Login from "../views/Auth/Login.vue";
import BookingList from "../views/Bookings/List.vue";
import CreateForm from "../views/Bookings/Form.vue";
import {ElMessage} from "element-plus";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'home',
            redirect: to => {
                return { path: '/bookings', query: { q: to.params.searchText } }
            }
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/bookings',
            name: 'bookingList',
            component: BookingList,
        },
        {
            path: '/bookings/create',
            name: 'createBooking',
            component: CreateForm,
        },
    ]
})

// router.beforeEach((to, from, next) => {
//     if (to.matched.some((record) => record.meta.requiresAuth)) {
//         if (localStorage.getItem('authenticated') === true) {
//             next()
//         }
//         else {
//             ElMessage.error('Unauthorised, please login again')
//             next('/login')
//         }
//     }
// })

export default router
