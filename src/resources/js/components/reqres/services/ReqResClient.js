import axios from 'axios';

/**
 * Backend Client
 */
export default class ReqResClient {

    constructor() {
        this.httpClient = axios;
        this.reqresEndpoint = 'http://localhost:8080';
    }

    loginUser(email, password) {
        return this.httpClient(
            {
                method: 'post',
                url: `${this.reqresEndpoint}/api/user/login`,
                data: {
                    email: email,
                    password: password
                },
                headers: {'Accept': 'application/json'}
            }
        )
    }

    getUsersList() {
        return this.httpClient(
            {
                method: 'get',
                url: `${this.reqresEndpoint}/api/user/list-users`,
                headers: {'Accept': 'application/json'}
            }
        )
    }

    createUser(email, password) {
        return this.httpClient(
            {
                method: 'post',
                url: `${this.reqresEndpoint}/api/user/create-user`,
                data: {
                    email: email,
                    password: password
                },
                headers: {'Accept': 'application/json'}
            }
        )
    }
}