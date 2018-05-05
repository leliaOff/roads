import VueRouter from 'vue-router';

let routes = [
    {
        path: '/',
        component: require('./components/Index.vue')
    },
    // {
    //     path: '/login',
    //     component: require('./components/LoginForm.vue')
    // },
];

const router = new VueRouter({
    routes,
});

/**
 * @brief Настройки для маршрутизатора
 */
router.beforeEach((to, from, next) => {
    /* Проверка - залогинися ли пользователь: */
    /* meta: { requiresAuth: true } */
    if (to.matched.some(record => record.meta.requiresAuth)) {
    if (sessionApiId === '') {
        window.location = baseurl;
    } else {
        next();
    }
} else {
    next();
}
});

export default router;