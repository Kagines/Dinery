<template>
<MyHeader />
<h1>Hello {{ name }}, Welcome on Home Page</h1>
<table border="2">
  <tr>
    <td>Id</td>
    <td>Name</td>
    <td>Contact</td>
    <td>Address</td>
    <td>Actions</td>
  </tr>
  <tr v-for="item in restaurant" :key="item.id">
    <td>{{ item.id }}</td>
    <td>{{ item.name }}</td>
    <td>{{ item.contact }}</td>
    <td>{{ item.address }}</td>
    <td>
      <router-link :to="'/update/' + item.id">Update</router-link>
      <button v-on:click="deleteRestaurant(item.id)">Delete</button>
    </td>
  </tr>
</table>
</template>

<script>
import MyHeader from './MyHeader.vue';
import axios from 'axios';

export default {
  name: 'MyHome',
  data() {
    return {
      name: '',
      restaurant: [],
    };
  },
  components: {
    MyHeader,
  },
  methods: {
    async deleteRestaurant(id) {
      try {
        const response = await axios.delete(`http://localhost:3000/restaurant/${id}`);
        if (response.status === 200) {
          console.log('Restaurant deleted successfully:', id);

          // Update the local restaurant data after successful deletion
          const updatedRestaurants = this.restaurant.filter(
            (restaurant) => restaurant.id !== id
          );
          this.restaurant = updatedRestaurants;
        } else {
          console.error('Error deleting restaurant:', response.status, response.data);
          // Handle errors (e.g., display error message to user)
        }
      } catch (error) {
        console.error('Error deleting restaurant:', error);
        // Handle network or other errors
      }
    },
    async loadData() {
      let user = localStorage.getItem('user-info');
      this.name = JSON.parse(user).name;
      if (!user) {
        this.$router.push({ name: 'MySignUp' });
      }
      let result = await axios.get('http://localhost:3000/restaurant');
      console.log('Fetched restaurant data:', result.data);
      this.restaurant = result.data;
    },
  },

  async mounted() {
    this.loadData();
  },
};
</script>

<style>
td {
  width: 160px;
  height: 40px;
}
</style>
