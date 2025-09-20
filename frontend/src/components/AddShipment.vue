<template>
    <h1>Add Shipment</h1>
    <div v-if="!courierSelected">
        <div class="form-container">
            <form @submit.prevent="getMinPrice" class="add-shipment-form">
                <input class="input-field" type="text" v-model="senderCode" placeholder="Sender Zip Code" required />
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
                <p v-if="errors.height" class="errors">{{ errors.height }}</p>
                <button type="submit">Ship{{ minPriceText }}</button>
            </form>
        </div>
    </div>
    <div v-if="courierSelected">
        <h2>List Couriers</h2>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <ul class="well" v-for="item in listCouries">
                        <li>
                            <form @submit.prevent="addShipment(item.PRICE, item.COURIER)" class="add-shipment-form">
                                <span>{{ item.COURIER }}</span>
                                <span>$ {{ item.PRICE }}</span>
                                <input type="hidden" v-model="item.PRICE" name="price">
                                <input type="hidden" v-model="item.COURIER" name="courier">
                                <button type="submit">Select</button>
                            </form>
                        </li>
                    </ul>    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from '@/axios';

export default {
    data() {
        return {
            orderNumber: "",
            senderCode: "",
            receiverCode: "",
            weight: "",
            length: "",
            width: "",
            height: "",
            volume: 0,
            minPrice: 0,
            minPriceText: "",
            courierSelected: false,
            listCouries: [],
            courier: "",
            price: 0,
            userID: null,
            errors: {}
        }
    },
    methods: {
        validateInput() {
            const errors = {};
            if(!this.senderCode) errors.senderCode = 'The Sender Zip Code is required!';
            if(!this.receiverCode) errors.receiverCode = 'The Receiver Zip Code is required!';
            if(!this.weight) errors.weight = 'The Weight is required!';
            if(!this.length) errors.length = 'The Length is required!';
            if(!this.width) errors.width = 'The Width is required!';
            if(!this.height) errors.height = 'The Height is required!';
            return errors;
        },
        async getMinPrice() {
            if(this.minPrice == 0) {
                const response = await axios.post("/get-prices", {
                    WEIGHT: this.weight, 
                    VOLUME: (this.length * this.width * this.height) / 5000
                });
                console.log(response);
                if(response.data.length > 0) {
                    console.log(response.data);
                    this.listCouries = response.data;
                    this.minPriceText = ' From $ '+response.data[0].PRICE;
                    this.minPrice = response.data[0].PRICE;
                    this.volume = (this.length * this.width * this.height) / 5000;
                }
                else {
                    console.log(response.data);
                    this.listCouries = [];
                    this.minPriceText = 'ment Price Not Available!';
                    this.minPrice = 0;
                    this.volume = 0;
                }
            }
            else {
                if(this.minPrice > 0 && this.courierSelected) {
                    // this.addShipment();
                    console.log("go to addShipment");
                }
                else if(this.minPrice > 0) {
                    this.courierSelected = true;
                    // this.listCouriers();
                    console.log("go to listCouriers");
                }
                else {
                    this.courierSelected = false;
                    console.log("Price not found!");
                }
            }
        },
        async addShipment(selectedPrice, selectedCourier) {
            this.price = selectedPrice;
            this.courier = selectedCourier;
            const errors = this.validateInput();
            const currentDate = new Date().setDate(new Date().getMinutes());
            if(Object.keys(errors).length > 0) {
                this.errors = errors;
                return;
            }
            try {
                if(localStorage.getItem('token')) {
                    if(currentDate > localStorage.getItem('tokenExpireAt')) {
                        localStorage.removeItem('token');
                        localStorage.removeItem('tokenExpireAt');
                        this.$router.push('/login');
                    }
                    else {
                        const user = await axios.get("http://localhost:8000/api/user", {
                            headers: {
                                'Authorization': `Bearer ${localStorage.getItem('token')}`
                            }
                        });
                        this.userID = user.data.id;
                        console.log("userID", this.userID);
                    }
                }
                const response = await axios.post("/insert-shipment", {
                    ORDER_NUMBER : Math.floor(Math.random() * (9999999999 - 1000000000 + 1) ) + 1000000000,
                    SENDER_CODE: this.senderCode,
                    RECEIVER_CODE: this.receiverCode,
                    DETAILS: JSON.stringify({
                        weight: this.weight,
                        length: this.length,
                        width: this.width,
                        height: this.height,
                        volume: this.volume
                    }),
                    PRICE: this.price,
                    COURIER: this.courier,
                    ID_USER: this.userID
                });
                if(response) {
                    console.log(response.data);
                    if(this.userID) {
                        // // const payload = { ID_USER: userID };
                        // // const headers = { 'Authorization': `Bearer ${localStorage.getItem('token')}` };
                        // // const userShipments = await axios.post("/shipments-by-user", payload, { headers });
                        // // console.log(userShipments);
                        // this.$router.push({name: 'myShipments', params: { userID: userID }});
                        console.log(response.data.ORDER_NUMBER);
                        console.log(response.data.SENDER_CODE);
                        console.log(response.data.RECEIVER_CODE);
                        console.log(this.weight);
                        console.log(this.length);
                        console.log(this.width);
                        console.log(this.height);
                        console.log(this.volume);
                        console.log(response.data.PRICE);
                        console.log(response.data.COURIER);
                        console.log(response.data.ID_USER);
                        this.$router.push({name: 'Checkout', params: { 
                                ORDER_NUMBER : response.data.ORDER_NUMBER,
                                SENDER_CODE: response.data.SENDER_CODE,
                                RECEIVER_CODE: response.data.RECEIVER_CODE,
                                weight: this.weight,
                                length: this.length,
                                width: this.width,
                                height: this.height,
                                volume: this.volume, 
                                PRICE: response.data.PRICE,
                                COURIER: response.data.COURIER,
                                ID_USER: response.data.ID_USER
                            }
                        });
                        
                    }
                    else {
                        console.log(response.data.ORDER_NUMBER);
                        console.log(response.data.SENDER_CODE);
                        console.log(response.data.RECEIVER_CODE);
                        console.log(this.weight);
                        console.log(this.length);
                        console.log(this.width);
                        console.log(this.height);
                        console.log(this.volume);
                        console.log(response.data.PRICE);
                        console.log(response.data.COURIER);
                        console.log(response.data.ID_USER);
                        this.$router.push({ name: 'Checkout', params: { 
                                ORDER_NUMBER : response.data.ORDER_NUMBER,
                                SENDER_CODE: response.data.SENDER_CODE,
                                RECEIVER_CODE: response.data.RECEIVER_CODE,
                                weight: this.weight,
                                length: this.length,
                                width: this.width,
                                height: this.height,
                                volume: this.volume, 
                                PRICE: response.data.PRICE,
                                COURIER: response.data.COURIER,
                                ID_USER: response.data.ID_USER
                            }
                        });
                        // // this.$router.push('/');
                    }
                }
                else 
                    console.error("An error occurred before the insert shipment");
                
            }
            catch(error) {
                console.error("An error occurred during the insert shipment: ", error);
            }
        }
    }
}
</script>