<template>
    <div class="container">
        <div class="row">
            <div class="col-8 offset-2" id="loading-div" v-if="loading">
                <h1>Loading...</h1>
            </div>

            <div class="col-8 offset-2" v-if="!loading">
                <div class="d-flex">
                    <h1 class="d-flex flex-fill">Users List</h1>
                    <p class="menu-options">
                        <a class="btn btn-primary" href="#" @click.prevent.stop="showCreateNewUserForm">Create New User</a>
                        <a class="btn btn-danger" href="#" @click.prevent.stop="logout">Logout</a>
                    </p>
                </div>


                <div class="row">
                    <div class="col-12">
                        <ul>
                            <li class="d-flex w-100" v-for="user in usersList">
                                <p class="avatar">
                                    <img class="img-fluid" v-bind:src="user.avatar" />
                                </p>
                                <p class="info">
                                    {{user.first_name}} {{user.last_name}}<br />
                                    {{ user.email }}
                                </p>

                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <modal name="create-new-user" :click-to-close="false" :width="'50%'" :height="'50%'">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h2>Create New User</h2>

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
                                <button type="button" id="submit-button" class="btn btn-primary" @click.prevent.stop="createNewUser">Create User</button>
                                <button type="button" id="cancel-button" class="btn btn-danger" @click.prevent.stop="resetAndCloseModal">Cancel</button>
                            </form>
                        </div>
                    </div>

                </div>
            </modal>

        </div>
    </div>
</template>

<style scoped>
    LI {
        border-bottom: 1px solid black;
    }

    UL LI:nth-child(even) {
        background-color: #b2a8aa;
    }
    .avatar {
        padding-right: 10px;
    }

    .menu-options {
        text-align: right;
    }
</style>

<script>
    import ReqResClient from '../services/ReqResClient.js'

    const httpClient = new ReqResClient();

    export default {
        mounted() {
            console.log('Component mounted.')
        },

        created() {
            this.loadUsers();
        },

        data() {
            return {
                usersList:[],
                loading: false,
                errors: false,
                email: '',
                password: ''
            }
        },

        methods: {
            loadUsers() {
                this.loading = true;
                httpClient.getUsersList().then((response) => {
                    this.usersList = response.data.data;
                    this.loading = false;

                }).catch((error) => {
                    document.querySelector('#loading-div H1').innerText = 'An error has occurred.  Please reload page.'
                })

                return true;
            },

            showCreateNewUserForm() {
                this.$modal.show('create-new-user');
            },

            createNewUser() {
                this.errors = false;
                document.querySelector('#submit-button').innerText = 'Processing...'

                //do the user login
                if(this.validate()) {
                    httpClient.createUser(this.email, this.password).
                    then((response) => {
                        this.resetAndCloseModal();
                        this.loadUsers();

                    }).catch((error) => {
                        this.showErrors('User not created. Please check your form and try again.');
                    })

                    return true;
                }
                return this.showErrors('Form errors. Please correct errors and try again.')
            },

            validate(){ //very basic validation, needs to be put into a service or helper class
                return (this.email.length > 0) && (this.password.length > 0) && (this.email.indexOf('@') !== -1);
            },
            resetAndCloseModal() {
                this.email = '';
                this.password = '';
                this.errors = false;
                this.$modal.hide('create-new-user');
            },
            showErrors(errorMessage) {
                this.errors = true;
                document.querySelector('#submit-button').innerText = 'Create User';
                document.querySelector('#errors').innerHTML = `<strong>${errorMessage}</strong>`;
                return false;
            },
            logout() {
                this.$root.logout();
            }

        }
    }
</script>
