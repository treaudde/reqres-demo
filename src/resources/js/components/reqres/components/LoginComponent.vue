<template>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-4 offset-4">
                <h1>Login</h1>
                <form>
                    <div class="alert alert-danger" v-show="errors">
                        <p id="errors"></p>
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" required class="form-control" id="email" name="email" v-model="email" placeholder="Email address...">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" v-model="password">
                    </div>
                    <button type="button" id="submit-button" class="btn btn-primary" @click.prevent.stop="login">Log In</button>
                </form>
            </div>

        </div>
    </div>
</template>


<script>
    import ReqResClient from '../services/ReqResClient.js'

    const httpClient = new ReqResClient();

    export default {
        mounted() {
            console.log('Component mounted.')
        },

        data() {
            return {
                email: "",
                password: "",
                errors: false,
            }
        },

        methods: {
            login() {
                this.errors = false;
                document.querySelector('#submit-button').innerText = 'Loading...'

                //do the user login
                if(this.validate()) {
                    httpClient.loginUser(this.email, this.password).
                        then((response) => {
                            //store the token
                            sessionStorage.setItem('reqResToken', response.data.token);
                            this.$router.push({name: 'list-users'});
                        }).catch((error) => {
                            this.showLoginErrors('Login failed.  Please check your credentials and try again');
                        })

                    return true;
                }
                return this.showLoginErrors('Login form errors. Please correct errors and try again.')
            },

            validate(){ //very basic validation
                return (this.email.length > 0) && (this.password.length > 0) && (this.email.indexOf('@') !== -1);
            },

            showLoginErrors(errorMessage) {
                this.errors = true;
                document.querySelector('#submit-button').innerText = 'Log In';
                document.querySelector('#errors').innerHTML = `<strong>${errorMessage}</strong>`;
                return false;
            }
        }
    }
</script>
