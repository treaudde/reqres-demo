/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * ROUTER CONFIGURATION
 */
let VueRouter = require('vue-router').default;
const routes = require('./components/reqres/routes.js').routes;
let NProgress = require('nprogress');

Vue.use(VueRouter);

const router = new VueRouter({
    routes
});

//loader for route transition
router.beforeResolve( (to, from, next) => {
    if(to.name) {
        NProgress.start();
    }

    next();
})

router.afterEach((to, from) => {
    NProgress.done();
})


Vue.component('login-form', require('./components/reqres/components/LoginComponent.vue').default);
Vue.component('user-list', require('./components/reqres/components/ListComponent.vue').default);
Vue.component('create-form', require('./components/reqres/components/FormComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const reqResApp = new Vue({
    router,
    el: '#app',
});
