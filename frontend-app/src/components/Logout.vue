<template>
    
</template>

<script>
import axios from '@/axios';
export default {
    data() {
        return {
            user: {}
        }
    },
    methods: {
        async function() {
            try {
                const user = await axios.get("http://localhost:8000/api/user", {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')}`
                    }
                });
                const payload = { user: user };
                const headers = { 'Authorization': `Bearer ${localStorage.getItem('token')}` };
                const response = await axios.post("/logout", payload, { headers });
                console.log(response);
                // if(response.data) 
                //     this.$store.commit('LOGOUT');
            }
            catch(error) {
                console.error("An error occurred during the logout: ", error.response.data);
            }
        }
    }
};
</script>