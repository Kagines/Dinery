<template>
  <div>
    <MyHeader />
    <div class="container">
      <h1 class="heading">Hello User, Welcome to the Add Restaurant Page</h1>
      <form class="add-form" @submit.prevent="addRestaurant">
        <div class="input-group">
          <input type="text" v-model="restaurant.name" class="input" placeholder="Enter Name" required>
        </div>
        <div class="input-group">
          <input type="text" v-model="restaurant.address" class="input" placeholder="Enter Address" required>
        </div>
        <div class="input-group">
          <input type="text" v-model="restaurant.contact" class="input" placeholder="Enter Contact" required>
        </div>
        <div class="input-group">
          <input type="url" v-model="restaurant.link" class="input" placeholder="Enter Link" required>
        </div>
        <button type="submit" class="btn">Add new Restaurant</button>
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
      restaurant: {
        name: '',
        address: '',
        contact: '',
        link: ''
      }
    };
  },
  methods: {
    async addRestaurant() {
      try {
        const user = JSON.parse(localStorage.getItem('user-info'));
        const token = user ? user.token : null;

        const result = await axios.post('http://localhost:8080/restaurants', this.restaurant, {
          headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json'
          }
        });

        if (result.status === 201) {
          this.$router.push({ name: 'MyHome' });
        }
      } catch (error) {
        console.error("Error adding restaurant:", error);
        if (error.response) {
          console.error("Response data:", error.response.data);
          console.error("Response status:", error.response.status);
          console.error("Response headers:", error.response.headers);
        } else {
          console.error("Error message:", error.message);
        }
        alert("An error occurred while adding the restaurant. Please try again.");
      }
    }
  },
  mounted() {
    const user = localStorage.getItem('user-info');
    if (user) {
      const userInfo = JSON.parse(user);
      if (userInfo.role !== 'admin') {
        this.$router.push({ name: 'MyHome' });
      }
    } else {
      this.$router.push({ name: 'MySignUp' });
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
