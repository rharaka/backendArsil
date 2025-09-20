<template>
    <h1>Register Page</h1>
    <div class="form-container">
        <form @submit.prevent="register" class="register-form">
            <input type="text" v-model="name" placeholder="Name" required />
            <input type="email" v-model="email" placeholder="Email" required />
            <input type="password" v-model="password" placeholder="Password" required />
            <input type="password" v-model="confirmPassword" placeholder="Confirm Password" required />
            <button type="submit">Register</button>
        </form>
    </div>
</template>

<script>
import axios from '@/axios';
export default {
    data() {
        return {
            name: "",
            email: "",
            password: "",
            confirmPassword: "",
            role: "0"
        }
    },
    methods: {
        async register() {
            try {
                const response = await axios.post("/register", {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    role: '0',
                });
                if(response.data.token) {
                    localStorage.setItem('token', response.data.token);
                }
                // this.$store.commit('REGISTER');
                this.$router.push('/Login');
            }
            catch(error) {
                console.error("An error occurred during the registration: ", error.response.data);
            }
        }
    }
};
</script>