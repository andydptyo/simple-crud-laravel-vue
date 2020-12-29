<template>
    <div class="container">
        <h3 class="mb-2">Register</h3>
        <form @submit.prevent="register">
            <div class="form-row mt-5">
                <div class="form-group col-md-6">
                    <label for="firstname">First name</label>
                    <input type="text" class="form-control" id="firstname" v-model="model.first_name">
                </div>
                <div class="form-group col-md-6">
                    <label for="lastname">Last name</label>
                    <input type="text" class="form-control" id="lastname" v-model="model.last_name">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" v-model="model.email">
                </div>
                <div class="form-group col-md-6">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" v-model="model.password">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="phone">Phone number</label>
                    <input type="text" class="form-control" id="phone" v-model="model.phone">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputcity">City</label>
                    <select id="inputcity" class="form-control" v-model="model.city_id">
                        <option value="">Select a city</option>
                        <template v-for="(city, index) in cities">
                            <option :key="index" :value="city.id">
                                {{ city.name }}
                            </option>
                        </template>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="birthday">Birthday</label>
                    <input type="date" class="form-control" id="birthday" v-model="model.birthday">
                </div>
            </div>
            <div class="form-group col-md-6 mt-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="tos" v-model="model.tos">
                    <label class="form-check-label" for="tos">
                        by signing up your agree to privacy policy & term of service
                    </label>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block" :disabled="!model.tos">Sign up</button>
            </div>
        </form>
    </div>
</template>
<script>
import axios from 'axios'

export default {
    created() {
        this.fetchCity()
    },
    data() {
        return {
            model: {
                first_name: '',
                last_name: '',
                email: '',
                password: '',
                phone: '',
                city_id: '',
                birthday: '',
                tos: false,
            },
            cities: [],
        }
    },
    methods: {
        async register() {
            let response = await axios.post('/api/users', this.model)

            if (response.data.message == 'success') {
                this.$router.push('/home')
            }
        },

        async fetchCity() {
            let response = await axios.get('/api/cities')
            
            this.cities = response.data
        },
    }
}
</script>
<style>
    
</style>