import { createStore } from 'vuex';
import router from './router';
import axios from 'axios';

export default createStore({
    state: {
        isLoggedIn: !!localStorage.getItem('token')
    },
    mutations: {
        LOGIN(state) {
            state.isLoggedIn = true;
            state.inRegister = false;
        },
        LOGOUT(state) {
            state.isLoggedIn = false;
            state.inRegister = true;
        }
    },
    actions: {
        login({ commit }) {
            commit('LOGIN');
        },
        async logout({ commit, dispatch }) {
            try {
                const user = await axios.get("http://localhost:8000/api/user", {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')}`
                    }
                });
                const payload = { user: user };
                const headers = { 'Authorization': `Bearer ${localStorage.getItem('token')}` };
                const response = await axios.post("http://localhost:8000/api/logout", payload, { headers });
                console.log(response);
                // if(response.data) 
                //     this.$store.commit('LOGOUT');
            }
            catch(error) {
                console.error("An error occurred during the logout: ", error);
            }
            commit('LOGOUT');
            localStorage.removeItem('token');
            localStorage.removeItem('tokenExpireAt');
            dispatch('navigateToLogin');
        },
        navigateToLogin(){
            router.push({name: 'Login'});
        }
    }
});