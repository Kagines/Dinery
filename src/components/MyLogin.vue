<template>
  <div class="login-container">
    <img class="logo" src="../assets/dinery1.png" alt="Dinery Logo">
    <h1>Login</h1>
    <form class="login" @submit="login">
      <div class="input-group">
        <input type="email" v-model="email" class="input" placeholder="Enter Email" required>
        <span class="error-message"></span>
      </div>
      <div class="input-group">
        <input type="password" v-model="password" class="input" placeholder="Enter Password" required>
        <span class="error-message"></span>
      </div>
      <button class="button" type="submit">Login</button>
      <p>
        <router-link to="/sign-up">Sign Up</router-link>
      </p>
    </form>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'MyLogin',
  data() {
    return {
      email: '',
      password: ''
    }
  },
  methods: {
    async login(event) {
      event.preventDefault(); // Prevent default form submission

      try {
        const response = await axios.get(`http://localhost:3000/users?email=${this.email}&password=${this.password}`);

        // Handle successful login
        if (response.status === 200 && response.data.length > 0) {
          localStorage.setItem("user-info", JSON.stringify(response.data[0]));
          this.$router.push({ name: 'MyHome' });
        } else {
          console.error('Login failed:', response.status, response.data);
          // Handle login failure logic (e.g., display error message)
        }
      } catch (error) {
        console.error('Login error:', error);
        // Handle network or other errors (e.g., display generic error message)
      }
    }
  },
  mounted() {
    let user = localStorage.getItem('user-info');
    if (user) {
      this.$router.push({ name: 'MyHome' });
    }
  }
}
</script>

<style scoped>
body {
  font-family: 'Arial', sans-serif;
  background-color: #f9f9f9;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  margin: 0;
}

.login-container {
  background-color: rgba(132, 128, 128, 0.3); /* White color with 50% opacity */
  backdrop-filter: blur(8px);
  padding: 20px 40px;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  text-align: center;
  width: 100%;
  max-width: 450px;
  height: auto;
  outline: auto;
  margin-left: 700px;
}

.logo {
  width: 300px;
  margin-bottom: 100px;
  margin-top: -30px;
}

h1 {
  font-size: 26px;
  color: #ffffff;
  margin-bottom: 30px;
}

.input-group {
  margin-bottom: 15px;
  text-align: left;
}

.input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 16px;
  box-sizing: border-box;
}

.input:focus {
  border-color: #009688;
  outline: none;
}

.error-message {
  color: red;
  font-size: 12px;
  margin-top: 5px;
}

.button {
  width: 100%;
  padding: 10px;
  background-color: #009688;
  border: none;
  border-radius: 4px;
  color: white;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.button:hover {
  background-color: #00796b;
}

p {
  margin-top: 20px;
  font-size: 14px;
}

a {
  color: #009688;
  text-decoration: none;
  transition: color 0.3s ease;
}

a:hover {
  color: #00796b;
}
</style>
