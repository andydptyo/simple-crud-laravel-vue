<template>
    <div>
        <Profile :user="user" :type="'view'" />
    </div>
</template>
<script>
import Profile from '@/components/UserProfile.vue'
import axios from 'axios'

export default {
    components: {
        Profile
    },
    mounted() {
        this.id = this.$route.params.id

        this.fetchUser()
    },
    data() {
        return {
            id: '',
            user: {}
        }
    },
    methods: {
        async fetchUser() {
            let response = await axios.get(`/api/users/${this.id}`)

            this.user = response.data
            this.user.city = this.user.city.id
        }
    },
}
</script>
<style>
    
</style>