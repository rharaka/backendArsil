<template>
    <h1>Checkout</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- {{ this.$route.params.ORDER_NUMBER }} <br> -->
                SENDER_CODE: {{ this.$route.params.SENDER_CODE }} <br>
                RECEIVER_CODE: {{ this.$route.params.RECEIVER_CODE }} <br>
                weight: {{ this.$route.params.weight }} <br>
                length: {{ this.$route.params.length }} <br>
                width: {{ this.$route.params.width }} <br>
                height: {{ this.$route.params.height }} <br>
                volume: {{ this.$route.params.volume }} <br>
                PRICE: {{ this.$route.params.PRICE }} <br>
                COURIER: {{ this.$route.params.COURIER }} <br>
                ID_USER: {{ this.$route.params.ID_USER }} <br>
                <!-- <ul class="well titles">
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
                </ul>     -->
            </div>
        </div>
    </div>
    <div v-if="this.$route.params.PRICE">
        <div class="form-container">
            <!-- <form @submit.prevent="getStripe" class="stripe"> -->
                <!-- <input class="input-field" type="text" v-model="senderCode" placeholder="Sender Zip Code" required />
                <p v-if="errors.senderCode" class="errors">{{ errors.senderCode }}</p>
                <input class="input-field" type="text" v-model="receiverCode" placeholder="Receiver Zip Code" required />
                <p v-if="errors.receiverCode" class="errors">{{ errors.receiverCode }}</p>
                <input class="input-field" type="number" v-model="weight" placeholder="Weight in kg" required />
                <p v-if="errors.weight" class="errors">{{ errors.weight }}</p>
                <input class="input-field" type="number" v-model="length" placeholder="Length in cm" required />
                <p v-if="errors.length" class="errors">{{ errors.length }}</p>
                <input class="input-field" type="number" v-model="width" placeholder="Width in cm" required />
                <p v-if="errors.width" class="errors">{{ errors.width }}</p>
                <input class="input-field" type="number" v-model="height" placeholder="Height in cm" required />
                <p v-if="errors.height" class="errors">{{ errors.height }}</p> -->
                <!-- <button type="submit">Checkout</button> -->
            <!-- </form> -->
            <h2>Please give us your payment details:</h2>
                <card class='stripe-card'
                    :class='{ complete }'
                    stripe='pk_test_51QzlmzRcuBqeHh0iYtJBhCHpDDXQKaHrzv9809lrcGbeLGelkVKVc4ODtApxnJM5RO72dHrw9hPAnAt8llKQVDL500mL1gKk60'
                    :options='stripeOptions'
                    @change='complete = $event.complete'
                />
            <button class='pay-with-stripe' @click='pay' :disabled='!complete'>Pay with credit card</button>
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
    .stripe-card {
        width: 300px;
        border: 1px solid grey;
    }
    .stripe-card.complete {
        border-color: green;
    }
</style>

<script>
// import { stripeKey, stripeOptions } from './stripeConfig.json'
import { Card, createToken } from 'vue-stripe-elements-plus';

export default {
  data () {
    return {
      complete: false,
      stripeOptions: {
        // see https://stripe.com/docs/stripe.js#element-options for details
        mode: 'payment',
        currency: 'eur',
        amount: 1599
      }
    }
  },

  components: { Card },

  methods: {
    pay () {
        console.log("START pay");
        // createToken returns a Promise which resolves in a result object with
        // either a token or an error key.
        // See https://stripe.com/docs/api#tokens for the token object.
        // See https://stripe.com/docs/api#errors for the error object.
        // More general https://stripe.com/docs/stripe.js#stripe-create-token.
        createToken().then(data => console.log(data.token));
        console.log("END pay");
    }
  }
}
// import axios from '@/axios';

// export default {
//     // mounted() {
//     //     this.getStripe();
//     // },
//     data() {
//         return {
//             userID: "",
//             shipmentToPay: {},
//             checkoutStart: false,
//             orderPayed: false
//         }
//     },
//     methods: {
//         async getStripe() {
//             const response = await axios.get("/stripe");
//             this.pageCheckout = response.data;
//             console.log(response.data);
//         },
//         async createToken() {
//             stripe.createToken(cardElement).then(function(result) {
//                 if(typeof result.error != 'undefined') {
//                     // document.getElementById("pay-btn").disabled = false;
//                     alert(result.error.message);
//                 }
//                 /* creating token success */
//                 if(typeof result.token != 'undefined') {
//                     stripeTokenId = result.token.id;
//                     // document.getElementById('checkout-form').submit();
//                 }
//             });
//         }
//         // async listShipments() {
//         //     const user = await axios.get("http://localhost:8000/api/user", {
//         //         headers: {
//         //             'Authorization': `Bearer ${localStorage.getItem('token')}`
//         //         }
//         //     });
//         //     this.userID = user.data.id;
//         //     const payload = { ID_USER: this.userID };
//         //     const headers = { 'Authorization': `Bearer ${localStorage.getItem('token')}` };
//         //     this.userShipments = await axios.post("/shipments-by-user", payload, { headers });
//         //     this.userShipments = this.userShipments.data;
//         //     console.log(this.userID, this.userShipments);
//         // }
//     //     validateInput() {
//     //         const errors = {};
//     //         if(!this.senderCode) errors.senderCode = 'The Sender Zip Code is required!';
//     //         if(!this.receiverCode) errors.receiverCode = 'The Receiver Zip Code is required!';
//     //         if(!this.weight) errors.weight = 'The Weight is required!';
//     //         if(!this.length) errors.length = 'The Length is required!';
//     //         if(!this.width) errors.width = 'The Width is required!';
//     //         if(!this.height) errors.height = 'The Height is required!';
//     //         return errors;
//     //     },
//     //     async addShipment() {
//     //         const errors = this.validateInput();
//     //         const currentDate = new Date().setDate(new Date().getMinutes());
//     //         var userID = null;
//     //         if(Object.keys(errors).length > 0) {
//     //             this.errors = errors;
//     //             return;
//     //         }
//     //         try {
//     //             if(localStorage.getItem('token')) {
//     //                 if(currentDate > localStorage.getItem('tokenExpireAt')) {
//     //                     localStorage.removeItem('token');
//     //                     localStorage.removeItem('tokenExpireAt');
//     //                     this.$router.push('/login');
//     //                 }
//     //                 else {
//     //                     const user = await axios.get("http://localhost:8000/api/user", {
//     //                         headers: {
//     //                             'Authorization': `Bearer ${localStorage.getItem('token')}`
//     //                         }
//     //                     });
//     //                     userID = user.data.id;
//     //                     console.log("userID", userID);
//     //                 }
//     //             }
//     //             const response = await axios.post("/insert-shipment", {
//     //                 SENDER_CODE: this.senderCode,
//     //                 RECEIVER_CODE: this.receiverCode,
//     //                 DETAILS: JSON.stringify({
//     //                     weight: this.weight,
//     //                     length: this.length,
//     //                     width: this.width,
//     //                     height: this.height,
//     //                     volume: (this.length * this.width * this.height) / 5000
//     //                 }),
//     //                 ID_USER: userID
//     //             });
//     //             if(userID) {
//     //                 const payload = { ID_USER: userID };
//     //                 const headers = { 'Authorization': `Bearer ${localStorage.getItem('token')}` };
//     //                 const userShipments = await axios.post("/shipments-by-user", payload, { headers });
//     //                 console.log(userShipments);
//     //                 this.$router.push({name: 'myShipments', params: { userShipments: userShipments, userID: userID }});
                    
//     //             }
//     //             else 
//     //                 this.$router.push('/');
//     //         }
//     //         catch(error) {
//     //             console.error("An error occurred during the insert shipment: ", error);
//     //         }
//     //     }
//     }
// }
</script>