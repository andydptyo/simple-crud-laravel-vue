import Vue from 'vue'
import Vuex from 'vuex'
import auth from './auth'
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex)

export default new Vuex.Store({
  plugins: [
    createPersistedState({
      paths: [
        'auth/authenticated', 
        'auth/token', 
        'auth/is_admin', 
        'auth/user'
      ]
    })
  ],
  modules: {
    auth
  }
})
