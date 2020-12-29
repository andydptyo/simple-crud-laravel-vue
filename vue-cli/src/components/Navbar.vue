<template>
    <div class="mb-5">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">SuperHelper</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li v-if="authenticated" class="nav-item">
                        <router-link to="/home" class="nav-link">Home</router-link>
                    </li>
                    <li v-else class="nav-item">
                        <router-link to="/login" class="nav-link">Login</router-link>
                    </li>
                </ul>
                <button v-if="authenticated" class="btn btn-outline-secondary my-2 my-lg-0" @click="logout">
                    Logout
                </button>
            </div>
        </nav>
    </div>
</template>
<script>
export default {
    name: 'Navbar',
    props: ['authenticated'],
    methods: {
        logout() {
            this.$store.dispatch('auth/logout')
            .then(() => {
                this.$router.push('/login')
            })
        }
    }
}
</script>
<style>
    
</style>