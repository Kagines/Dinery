<template>
  <div>
    <MyHeader />
    <div class="container">
      <h1 class="heading">Hello User, Welcome to the Add Restaurant Page</h1>
      <form class="add-form">
        <div class="input-group">
          <input type="text" v-model="restaurants.name" class="input" placeholder="Enter Name" required>
        </div>
        <div class="input-group">
          <input type="text" v-model="restaurants.address" class="input" placeholder="Enter Address" required>
        </div>
        <div class="input-group">
          <input type="text" v-model="restaurants.contact" class="input" placeholder="Enter Contact" required>
        </div>
        <button type="submit" class="btn" v-on:click="addRestaurant">Add new Restaurant</button>
      </form>
    </div>
  </div>
</template>

<script>
import MyHeader from './MyHeader.vue';
import axios from 'axios';

export default {
  name: 'MyAddRest',
  components: {
    MyHeader
  },
  data() {
    return {
      restaurants: {
        name: '',
        address: '',
        contact: ''
      }
    }
  },
  methods: {
    async addRestaurant(event) {
      event.preventDefault()
      console.warn(this.restaurants)
      const result = await axios.post('http://localhost:8080/restaurants', {
        name: this.restaurants.name,
        address: this.restaurants.address,
        contact: this.restaurants.contact
      });
      if (result.status === 201) {
        this.$router.push({ name: 'MyHome' })
      }
      console.warn("result", result)
    }
  },
  mounted() {
    let user = localStorage.getItem('user-info');
    if (!user) {
      this.$router.push({ name: 'MySignUp' })
    }
  }
}
</script>

<style >

.container {
  max-width: 600px;
  margin: 150px auto;
  padding: 90px;
  background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
  border-radius: 10px; /* Curved edges */
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Drop shadow */
}

.heading {
  text-align: center;
}

.input-group {
  margin-bottom: 20px;
}

.input {
  width: 80%;
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.btn {
  width: 50%;
  padding: 10px;
  font-size: 18px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.btn:hover {
  background-color: #0056b3;
}
</style>
