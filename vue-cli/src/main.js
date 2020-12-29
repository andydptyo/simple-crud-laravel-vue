import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios'
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'

Vue.config.productionTip = false
const token = localStorage.getItem('token')

window.axios = axios
axios.defaults.baseURL = 'http://localhost:8000'
axios.defaults.withCredentials = true

if (token) {
  axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
}

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
