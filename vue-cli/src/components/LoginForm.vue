<template>
    <div class="container">
        <h3 class="mb-2">Login</h3>
        <form @submit.prevent="login">
            <div class="form-row">
                <div class="form-group col-md-6 mt-5">
                    <label for="email">Email</label>
                    <input type="text" id="email" class="form-control" v-model="model.email" required>
                    <div class="invalid-feedback">{{ error.message }}</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="password">Password</label>
                    <input type="password" id="password" class="form-control" v-model="model.password" required>
                </div>
            </div>
            <div class="form-row mt-4">    
                <div class="form-group col-md-6">
                    <button class="btn btn-primary btn-block" type="submit">
                        Login
                    </button>
                </div>
            </div>
            <div class="form-row mt-4">
                <div class="form-group col-md-4">
                    Dont't have account ? <router-link to="/register">register here</router-link>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
export default {
    name: 'LoginForm',
    data() {
        return {
            model: {
                email: '',
                password: '',
            },
            error: {
                message: '',
            }
        }
    },
    methods: {
        login() {
            this.$store.dispatch('auth/login', this.model)
            .then(() => this.$router.push('/home'))
            .catch(err => console.log(err))
        }
    }
}
</script>
<style>
    
</style>