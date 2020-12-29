import axios from 'axios'

export default {
    namespaced: true,
    state: {
        status: '',
        authenticated: false,
        token: localStorage.getItem('token') || '',
        user: {},
        is_admin: false,
    },
    mutations: {
        auth_request(state) {
            state.status = 'loading'
        },
        auth_success(state, { token, user }) {
            state.status = 'success'
            state.token = token
            state.user = user
            state.is_admin = user.is_admin
        },
        auth_error(state) {
            state.status = 'error'
            state.is_admin = false
        },
        logout(state) {
            state.status = ''
            state.token = ''
            state.is_admin = false
        },
    },

    actions: {
        login({ commit }, user) {
            return new Promise((resolve, reject) => {
                commit('auth_request')

                axios.post('/api/login', user)
                .then(resp => {
                    const token = resp.data.access_token
                    const user = resp.data.user

                    localStorage.setItem('token', token)
                    localStorage.setItem('is-admin', user.is_admin)
                    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
                    commit('auth_success', { token, user })
                    resolve(resp)
                })
                .catch(err => {
                    commit('auth_error')
                    localStorage.removeItem('token')
                    reject(err)
                })
            })
        },

        register({commit}, user){
            return new Promise((resolve, reject) => {
                commit('auth_request')
                axios.post('/api/register', user)
                .then(resp => {
                    const token = resp.data.access_token
                    const user = resp.data.user
                    localStorage.setItem('token', token)
                    this.axios.defaults.headers.common['Authorization'] = token
                    commit('auth_success', token, user)
                    resolve(resp)
                })
                .catch(err => {
                    commit('auth_error', err)
                    localStorage.removeItem('token')
                    reject(err)
                })
            })
        },

        logout({commit}){
            return new Promise((resolve) => {
                commit('logout')
                localStorage.removeItem('token')
                delete axios.defaults.headers.common['Authorization']
                resolve()
            })
        }
    },
  
    getters: {
        authenticated: state => !!state.token,
        authStatus: state => state.status,
        isAdmin: state => state.is_admin,
    }
}