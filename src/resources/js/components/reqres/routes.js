import ListComponent from './components/ListComponent.vue';
import FormComponent from './components/FormComponent.vue';
import LoginComponent from './components/LoginComponent.vue';

//pseudo secure function, in a real api, the token would be validated by the server as well
let isLoggedIn = () => {
    if (sessionStorage.getItem('reqResToken')) {
        return true;
    }
    return false;
}


export const routes = [
    {path: '/', component: LoginComponent, name: 'login', beforeEnter:(to, from, next) => {
        if(isLoggedIn()) {
            next({'name': 'list-users'});
        }
        next();
    }},

    {path: '/list-users', component: ListComponent, name: 'list-users', beforeEnter: (to, from, next) => {
        if(!isLoggedIn()) {
            alert('Not logged in!');
            next({'name': 'list-users'});
        }
        next();
    }},
    {path: '/form', component: FormComponent, name: 'create-user-form'},
];