<template>
  <div class="container">
    <MyHeader />
    <h1 class="heading">Hello User, Welcome to Update Restaurant Page</h1>
    <form class="update">
      <div class="input-group">
        <input type="text" id="name" v-model="restaurant.name" class="input" placeholder="Enter Name" required>
      </div>
      <div class="input-group">
        <input type="text" id="address" v-model="restaurant.address" class="input" placeholder="Enter Address" required>
      </div>
      <div class="input-group">
        <input type="text" id="contact" v-model="restaurant.contact" class="input" placeholder="Enter Contact" required>
      </div>
      <div class="input-group">
        <input type="text" id="url" v-model="restaurant.url" class="input" placeholder="Enter url" required>
      </div>
      <button type="submit" class="btn" v-on:click.prevent="updateRestaurant">Update Restaurant</button>
    </form>
  </div>
</template>

<script>
import MyHeader from './MyHeader.vue';
import axios from 'axios';

export default {
  name: 'MyUpdateRest',
  components: {
    MyHeader
  },

  data() {
    return {
      restaurant: {
        name: '',
        address: '',
        contact: '',
        url:''
      }
    }
  },

  async mounted() {
    let user = localStorage.getItem('user-info');
    if (!user) {
      this.$router.push({ name: 'MySignUp' })
    }

    const id = this.$route.params.id;
    if (!id) {
      console.error('Missing restaurant ID in URL!');
      return;
    }

    try {
      const result = await axios.get(`http://localhost:3000/restaurant/${id}`);
      this.restaurant = result.data;
      console.log('Fetched restaurant data:', result);
    } catch (error) {
      console.error('Error fetching restaurant:', error);
    }
  },

  methods: {
    async updateRestaurant() {
      const id = this.$route.params.id;
      try {
        const response = await axios.put(`http://localhost:3000/restaurant/${id}`, this.restaurant);
        if (response.status === 200) {
          console.log('Restaurant updated successfully!');
          this.$router.push({ name: 'MyHome' })
        } else {
          console.error('Error updating restaurant:', response.status, response.data);
        }
      } catch (error) {
        console.error('Error updating restaurant:', error);
      }
    }
  }
};
</script>

<style scoped>
.container {
  max-width: 600px;
  margin: 150px auto;
  padding: 40px;
  background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
  border-radius: 10px; /* Curved edges */
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Drop shadow */
  text-align: center; /* Center align text */
}

.heading {
  text-align: center;
  margin-bottom: 20px;
}

.update {
  display: flex;
  flex-direction: column;
  align-items: center; /* Center align form elements */
}

.input-group {
  margin-bottom: 20px;
  width: 100%; /* Ensure input groups take full width */
  display: flex;
  justify-content: center; /* Center align input groups */
}

.input {
  width: 80%;
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.input:focus {
  border-color: #007bff;
  outline: none;
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
