<template>
    <nav>
        <!-- <router-link to="/login" v-if="!isLoggedIn && this.$route.name == 'Register'">Login</router-link>
        <router-link to="/register" v-if="!isLoggedIn && this.$route.name == 'Login'">Register</router-link> -->
        <router-link to="/add-shipment">Ship it</router-link>
        <router-link to="/login" v-if="!isLoggedIn">Login</router-link>
        <router-link to="/register" v-if="!isLoggedIn">Register</router-link>
        <!-- <router-link to="/logout" v-if="isLoggedIn">Logout</router-link> -->
        <router-link to="/my-shipments" v-if="isLoggedIn">My Shipments</router-link>
        <a href="#" @click="logout" v-if="isLoggedIn">Logout</a>
    </nav>
</template>

<script>
import { mapState, mapActions } from 'vuex';
export default {
    computed: {
        ...mapState(['isLoggedIn'])
    },
    methods: {
        ...mapActions(['logout'])
    }
}
</script>