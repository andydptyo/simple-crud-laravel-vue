<template>
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md">
                <template v-if="type == 'view'">
                    <h3>ACCOUNT DETAIL</h3>
                </template>
                <template v-else>
                    <h3>EDIT ACCOUNT</h3>
                </template>
                <div class="card">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="" class="card-img" alt="">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <form @submit.prevent="update">
                                    <div class="form-row mt-5">
                                        <div class="form-group col-md-6">
                                            <label for="firstname">First name</label>
                                            <input type="text" class="form-control" id="firstname" v-model="user.first_name" :disabled="type == 'view'">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="lastname">Last name</label>
                                            <input type="text" class="form-control" id="lastname" v-model="user.last_name" :disabled="type == 'view'">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" v-model="user.email" :disabled="type == 'view'">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputcity">City</label>
                                            <select id="inputcity" class="form-control" v-model="user.city" :disabled="type == 'view'">
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
                                            <label for="phone">Phone number</label>
                                            <input type="text" class="form-control" id="phone" v-model="user.phone" :disabled="type == 'view'">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="birthday">Birthday</label>
                                            <input type="date" class="form-control" id="birthday" v-model="user.birthday" :disabled="type == 'view'">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6 mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_admin" v-model="user.is_admin" :disabled="type == 'view'">
                                                <label class="form-check-label" for="is_admin">
                                                    Administrator
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <div class="row">
                                                <template v-if="type == 'edit'">
                                                    <div class="col-md-6 offset-md-6 d-flex justify-content-end">
                                                        <button class="btn btn-sm btn-danger" @click.prevent="cancel">Cancel</button>
                                                        <button type="submit" class="btn btn-sm btn-primary ml-2" @click.prevent="update">Save</button>
                                                    </div>
                                                </template>
                                                <template v-else>
                                                    <div class="col-md-6 offset-md-6 d-flex justify-content-end">
                                                        <button class="btn btn-sm btn-info" @click.prevent="edit(user.id)">Edit</button>
                                                        <button type="submit" class="btn btn-sm btn-danger ml-2" @click.prevent="destroy(user.id)">Delete</button>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'

export default {
    name: 'Profile',
    props: ['user', 'type'],
    created() {
        this.fetchCity()
    },
    data() {
        return {
            cities: [],
        }
    },
    methods: {
        async update() {
            this.user._method = "PUT"
            let response = await axios.post(`/api/users/${this.user.id}`, this.user)

            if (response.data.message == 'success') {
                this.$router.push('/home')
            } else {
                return false
            }
        },

        cancel() {
            this.$router.push('/home')
        },

        async fetchCity() {
            let response = await axios.get('/api/cities')
            
            this.cities = response.data
        },

        edit(id) {
            this.$router.push(`/user/${id}/edit`) 
        },

        async destroy(id) {
            let response = await axios.post(`/api/users/${id}`, {
                params: {
                    _method: "DELETE"
                }
            })

            if (response.data.message == 'success') {
                this.$router.push('/home')
            }
        }
    },
}
</script>
<style>
    
</style>