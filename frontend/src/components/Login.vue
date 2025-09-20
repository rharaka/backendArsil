<template>
    <h1>Login Page</h1>
    <div class="form-container">
        <form @submit.prevent="login" class="login-form">
            <input type="email" v-model="email" placeholder="Email" required />
            <input type="password" v-model="password" placeholder="Password" required />
            <button type="submit">Login</button>
        </form>
    </div>
</template>

<script>
import axios from '@/axios';
export default {
    data() {
        return {
            email: "",
            password: ""
        }
    },
    methods: {
        async login() {
            try {
                const expireDate = new Date().setDate(new Date().getMinutes()+1560);
                const response = await axios.post("/login", {
                    email: this.email,
                    password: this.password,
                    expireDate: expireDate
                });
                if(response.data.token) {
                    localStorage.setItem('token', response.data.token);
                    localStorage.setItem('tokenExpireAt', expireDate);
                    // const obj = { value: response.data.token, expires: expireDate.toString() };
                    // localStorage.setItem('token', JSON.stringify(obj));
                }
                this.$store.commit('LOGIN');
                this.$router.push('/');
            }
            catch(error) {
                console.error("An error occurred during the login: ", error);
            }
        }
    }
};
</script>