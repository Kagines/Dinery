<template>
<MyHeader />
<h1>Hello User, Welcome to Update Restaurant Page</h1>
<form class="update">
  <div class="input-group">
    <input type="text" v-model="restaurant.name" class="input" placeholder="Enter Name" required>
  </div>
  <div class="input-group">
    <input type="text" v-model="restaurant.address" class="input" placeholder="Enter Address" required>
  </div>
  <div class="input-group">
    <input type="text" v-model="restaurant.contact" class="input" placeholder="Enter Contact" required>
  </div>
  <button type="submit" v-on:click.prevent="updateRestaurant">Update Restaurant</button>
</form>
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
        contact: ''
      }
    }
  },

  async mounted() {
    let user = localStorage.getItem('user-info');
    if (!user) {
      this.$router.push({ name: 'MySignUp' })
    }

    const id = this.$route.params.id; // Access restaurant ID from URL
    if (!id) {
      console.error('Missing restaurant ID in URL!');
      // Handle the case where there's no ID (optional: redirect or display error)
      return;
    }

    try {
      const result = await axios.get(`http://localhost:3000/restaurant/${id}`);
      this.restaurant = result.data; // Assign fetched restaurant data
      console.log('Fetched restaurant data:', result);
    } catch (error) {
      console.error('Error fetching restaurant:', error);
      // Handle errors gracefully (e.g., display error message)
    }
  },

  methods: {
    async updateRestaurant() {
      // Update restaurant logic using this.restaurant data
      const id = this.$route.params.id;
      try {
        const response = await axios.put(`http://localhost:3000/restaurant/${id}`, this.restaurant);
        if (response.status === 200) {
          console.log('Restaurant updated successfully!');
          // Handle successful update (e.g., redirect to another page, display success message)
        } else {
          console.error('Error updating restaurant:', response.status, response.data);
          // Handle update failure (e.g., display error message)
        }
      } catch (error) {
        console.error('Error updating restaurant:', error);
        // Handle network or other errors
      }
    }
  }
};
</script>
