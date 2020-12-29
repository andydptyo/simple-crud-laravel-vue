<template>
    <div class="container">
        <div class="row mb-3 align-items-center">
            <div class="col-md-4">
                <input type="text" class="form-control" name="search" id="search" placeholder="search user's name" v-model="options.search">
            </div>
            <div class="col-md-2">
                <select id="inputcity" class="form-control" v-model="options.filter">
                    <option value="">Filter by city</option>
                    <template v-for="(city, index) in cities">
                        <option :key="index" :value="city.id">
                            {{ city.name }}
                        </option>
                    </template>
                </select>
            </div>
            <div class="col-md-4 offset-md-2 d-flex justify-content-end">
                <button class="btn btn-sm btn-primary" @click.prevent="add">Add new account</button>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">NAME</th>
                                <th scope="col">PHONE NUMBER</th>
                                <th scope="col">BIRTHDAY</th>
                                <th scope="col">CITY</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(user, index) in users">
                                <tr :key="index">    
                                    <td>
                                        <img src="" alt="" width="50" height="50">
                                    </td>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.phone }}</td>
                                    <td>{{ user.birthday }}</td>
                                    <td>{{ user.city.name }}</td>
                                    <td class="d-flex align-items-center">
                                        <button 
                                            class="btn btn-sm btn-warning ml-2" 
                                            @click.prevent="detail(user.id)">
                                            View
                                        </button>
                                        <button 
                                            class="btn btn-sm btn-info ml-2"
                                            @click.prevent="edit(user.id)">
                                            Edit
                                        </button>
                                        <button 
                                            v-if="isAdmin"
                                            class="btn btn-sm btn-danger ml-2"
                                            @click.prevent="destroy(user.id)">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'

export default {
    name: 'Table',
    created() {
        this.fetchUsers();
        this.fetchCity();
    },
    data() {
        return {
            options: {
                search: '',
                filter: '',
            },
            users: [],
            cities: [],
        }
    },
    computed: {
        isAdmin() {
            return localStorage.getItem('is-admin')
        }
    },
    methods: {
        add() {
            this.$router.push('/user/create')
        },

        async fetchUsers() {
            let response = await axios.get('/api/users', { 
                params: this.options
            })

            this.users = response.data.data
        },

        detail(id) {
            this.$router.push(`/user/${id}`)
        },

        edit(id) {
            this.$router.push(`/user/${id}/edit`)
        },
        
        async destroy(id) {
            let response = await axios.post(`/api/users/${id}`, {
                _method: "DELETE"
            })

            if (response.data.message == 'success') {
                this.fetchUsers()
            }
        },

        async fetchCity() {
            let response = await axios.get('/api/cities')
            
            this.cities = response.data
        },
    },
    watch: {
        'options.search': function() {
            this.fetchUsers()
        },

        'options.filter': function() {
            this.fetchUsers()
        }
    }
}
</script>
<style>
    
</style>