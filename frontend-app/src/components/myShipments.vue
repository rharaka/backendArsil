<template>
    <h1>My Shipments</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-4" v-if="userShipments.length > 0">
                <ul class="well titles">
                    <li>
                        <span class="order-number">#</span>
                        <span class="sender-code">SENDER</span>
                        <span class="receiver-code">RECEIVER</span>
                        <span class="price">PRICE</span>
                        <span class="courier">COURIER</span>
                        <span class="created-at">Created At</span>
                    </li>
                </ul> 
                <ul class="well" v-for="item in userShipments">
                    <li>
                        <span class="order-number">{{ item.ORDER_NUMBER }}</span>
                        <span class="sender-code">{{ item.SENDER_CODE }}</span>
                        <span class="receiver-code">{{ item.RECEIVER_CODE }}</span>
                        <span class="price">{{ item.PRICE }}</span>
                        <span class="courier">{{ item.COURIER }}</span>
                        <span class="created-at">{{ item.created_at.split("T")[0] }}</span>
                    </li>
                </ul>    
            </div>
        </div>
    </div>
</template>

<style>
    .well {
        display: flex;
        flex-direction: column;
        flex-wrap: nowrap;
        justify-content: center;
        align-items: center;
        margin: 5px;
        padding: 2px;
    }
    .well li {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        justify-content: space-around;
        align-items: center;
        gap: 10px;
        flex: 0 0 95%;
        max-width: 95%;
        width: 95%;
        margin-bottom: 5px;
    }
    .well li span {
        width: 15%;
        flex: 0 0 15%;
        border: 1px solid #333333;
        min-height: 21px;
        font-size: 15px;
    }
    .titles li span {
        font-weight: 700;
        border-bottom: 1px solid #333333;
        border-top: 1px solid transparent;
        border-left: 1px solid transparent;
        border-right: 1px solid transparent;
    }
</style>

<script>
import axios from '@/axios';

export default {
    mounted() {
        this.listShipments();
    },
    data() {
        return {
            userID: "",
            userShipments: {}
        }
    },
    methods: {
        async listShipments() {
            const user = await axios.get("http://localhost:8000/api/user", {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                }
            });
            this.userID = user.data.id;
            const payload = { ID_USER: this.userID };
            const headers = { 'Authorization': `Bearer ${localStorage.getItem('token')}` };
            this.userShipments = await axios.post("/shipments-by-user", payload, { headers });
            this.userShipments = this.userShipments.data;
            console.log(this.userID, this.userShipments);
        }
    //     validateInput() {
    //         const errors = {};
    //         if(!this.senderCode) errors.senderCode = 'The Sender Zip Code is required!';
    //         if(!this.receiverCode) errors.receiverCode = 'The Receiver Zip Code is required!';
    //         if(!this.weight) errors.weight = 'The Weight is required!';
    //         if(!this.length) errors.length = 'The Length is required!';
    //         if(!this.width) errors.width = 'The Width is required!';
    //         if(!this.height) errors.height = 'The Height is required!';
    //         return errors;
    //     },
    //     async addShipment() {
    //         const errors = this.validateInput();
    //         const currentDate = new Date().setDate(new Date().getMinutes());
    //         var userID = null;
    //         if(Object.keys(errors).length > 0) {
    //             this.errors = errors;
    //             return;
    //         }
    //         try {
    //             if(localStorage.getItem('token')) {
    //                 if(currentDate > localStorage.getItem('tokenExpireAt')) {
    //                     localStorage.removeItem('token');
    //                     localStorage.removeItem('tokenExpireAt');
    //                     this.$router.push('/login');
    //                 }
    //                 else {
    //                     const user = await axios.get("http://localhost:8000/api/user", {
    //                         headers: {
    //                             'Authorization': `Bearer ${localStorage.getItem('token')}`
    //                         }
    //                     });
    //                     userID = user.data.id;
    //                     console.log("userID", userID);
    //                 }
    //             }
    //             const response = await axios.post("/insert-shipment", {
    //                 SENDER_CODE: this.senderCode,
    //                 RECEIVER_CODE: this.receiverCode,
    //                 DETAILS: JSON.stringify({
    //                     weight: this.weight,
    //                     length: this.length,
    //                     width: this.width,
    //                     height: this.height,
    //                     volume: (this.length * this.width * this.height) / 5000
    //                 }),
    //                 ID_USER: userID
    //             });
    //             if(userID) {
    //                 const payload = { ID_USER: userID };
    //                 const headers = { 'Authorization': `Bearer ${localStorage.getItem('token')}` };
    //                 const userShipments = await axios.post("/shipments-by-user", payload, { headers });
    //                 console.log(userShipments);
    //                 this.$router.push({name: 'myShipments', params: { userShipments: userShipments, userID: userID }});
                    
    //             }
    //             else 
    //                 this.$router.push('/');
    //         }
    //         catch(error) {
    //             console.error("An error occurred during the insert shipment: ", error);
    //         }
    //     }
    }
}
</script>