<template>
  <div>
    <MyHeader />
    <div class="home-container">
      <h1>Hello {{ name }}, Welcome to the Home Page</h1>
      <table border="2">
        <thead>
          <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Contact</th>
            <th>Address</th>
            <th>Link</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in restaurants" :key="item.id">
            <td>{{ item.id }}</td>
            <td>{{ item.name }}</td>
            <td>{{ item.contact }}</td>
            <td>{{ item.address }}</td>
            <td>
              <a :href="item.link" target="_blank" rel="noopener noreferrer" v-if="item.link">
                {{ item.link }}
              </a>
              <span v-else>No link available</span>
            </td>
            <td>
              <div class="action-buttons">
                <router-link v-if="isAdmin" :to="'/update/' + item.id" class="update-link">
                  <img src="../assets/update.png" alt="Update Icon" class="icon" style="height: 1em;"> Update
                </router-link>
                <button v-if="isAdmin" @click="deleteRestaurant(item.id)" class="delete-button">
                  <img src="../assets/delete.png" alt="Delete Icon" class="icon" style="height: 1em;"> Delete
                </button>
                <router-link :to="'/review/' + item.id" class="review-link">
                  <img src="../assets/review.png" alt="Review Icon" class="icon" style="height: 1em;"> Review
                </router-link>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
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
      restaurants: [],
      isAdmin: false,
    };
  },
  components: {
    MyHeader,
  },
  methods: {
    async deleteRestaurant(id) {
      try {
        const response = await axios.delete(`http://localhost:8080/restaurants/${id}`);
        if (response.status === 200) {
          console.log('Restaurant deleted successfully:', id);
          this.restaurants = this.restaurants.filter((restaurant) => restaurant.id !== id);
        } else {
          console.error('Error deleting restaurant:', response.status, response.data);
        }
      } catch (error) {
        console.error('Error deleting restaurant:', error);
      }
    },
    async loadData() {
      const user = localStorage.getItem('user-info');
      if (user) {
        const userInfo = JSON.parse(user);
        this.name = userInfo.name;
        this.isAdmin = userInfo.role === 'admin';
      } else {
        this.$router.push({ name: 'MySignUp' });
      }

      try {
        const result = await axios.get('http://localhost:8080/restaurants');
        console.log('Fetched restaurant data:', result.data);
        this.restaurants = result.data;
      } catch (error) {
        console.error('Error fetching restaurants:', error);
      }
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
.delete-button,
.review-link {
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

.review-link {
  background-color: rgb(68, 68, 228);
  color: white;
}

.review-link:hover,
.update-link:hover,
.delete-button:hover {
  opacity: 0.8;
}

.icon {
  margin-right: 5px;
}
</style>
