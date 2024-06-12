<template>
  <MyHeader />
  <div class="home-container">
    <h1>Hello {{ name }}, Welcome on Home Page</h1>
    <table border="2">
      <thead>
        <tr>
          <th>Id</th>
          <th>Name</th>
          <th>Contact</th>
          <th>Address</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in restaurant" :key="item.id">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.contact }}</td>
          <td>{{ item.address }}</td>
          <td>
            <div class="action-buttons">
              <router-link :to="'/update/' + item.id" class="update-link">
                <img src="../assets/update.png" alt="Update Icon" class="icon" style="height: 1em;"> Update
              </router-link>
              <button v-on:click="deleteRestaurant(item.id)" class="delete-button">
                <img src="../assets/delete.png" alt="Delete Icon" class="icon" style="height: 1em;"> Delete
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
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
      if (user) {
        this.name = JSON.parse(user).name;
      } else {
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
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
  background-image: url('../assets/background4.jpg');
  background-size: cover;
  background-position: center;
}

.home-container {
  padding: 20px;
  background: rgba(255, 255, 255, 0.8);
  margin: 150px 20px; /* Added top margin to push the container down */
  border-radius: 10px;
}

h1 {
  color: #333;
  text-align: center;
  font-size: 2.5em;
  margin-bottom: 20px;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin: 20px 0;
}

th, td {
  padding: 30px 80px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: #f4f4f4;
}

tr:nth-child(even) {
  background-color: #f9f9f9;
}

.action-buttons {
  display: flex;
  align-items: center;
}

.update-link,
.delete-button {
  padding: 10px 15px;
  margin-right: 10px;
  text-decoration: none;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  display: flex;
  align-items: center;
}

.update-link {
  background-color: #4CAF50;
  color: white;
}

.delete-button {
  background-color: #f44336;
  color: white;
}

.update-link:hover,
.delete-button:hover {
  opacity: 0.8;
}

.icon {
  margin-right: 5px;
}
</style>
