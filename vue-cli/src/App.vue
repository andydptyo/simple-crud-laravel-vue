<template>
  <div id="app">
    <div id="nav">
      <Navbar :authenticated="authenticated" />
    </div>
    <router-view/>
  </div>
</template>
<script>
import Navbar from './components/Navbar.vue'
import axios from 'axios'
export default {
  components: { Navbar },
  computed : {
    authenticated() { 
      return this.$store.getters['auth/authenticated']
    }
  },
  methods: {

  },
  created: function () {
    axios.interceptors.response.use(undefined, function (err) {
      return new Promise(function () {
        if (err.status === 401 && err.config && !err.config.__isRetryRequest) {
          this.$store.dispatch('auth/logout')
        }
        throw err;
      });
    });
  }
}
</script>
<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}

/* #nav {
  padding: 30px;
}

#nav a {
  font-weight: bold;
  color: #2c3e50;
}

#nav a.router-link-exact-active {
  color: #42b983;
} */
</style>
