<template>
  <div class="signup-container">
    <img class="logo" src="../assets/dinery1.png" alt="Dinery Logo">
    <h1>Sign Up</h1>
    <form class="register-form" @submit.prevent="signUp">
      <div class="input-group">
        <input type="text" v-model="name" class="input" placeholder="Enter Name" required>
        <span v-if="errors.name" class="error-message">{{ errors.name }}</span>
      </div>
      <div class="input-group">
        <input type="email" v-model="email" class="input" placeholder="Enter Email" required>
        <span v-if="errors.email" class="error-message">{{ errors.email }}</span>
      </div>
      <div class="input-group">
        <input type="password" v-model="password" class="input" placeholder="Enter Password" required>
        <span v-if="errors.password" class="error-message">{{ errors.password }}</span>
      </div>
      <div class="input-group">
        <select v-model="role" class="input" required>
          <option value="" disabled>Select Role</option>
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>
        <span v-if="errors.role" class="error-message">{{ errors.role }}</span>
      </div>
      <button class="button" type="submit">Sign Up</button>
      <p>
        <router-link to="/login">Login</router-link>
      </p>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'MySignUp',
  data() {
    return {
      name: '',
      email: '',
      password: '',
      role: '',
      errors: {}
    };
  },
  methods: {
    async signUp() {
      this.errors = {};

      try {
        const result = await axios.post('http://localhost:8080/users', {
          name: this.name,
          email: this.email,
          password: this.password,
          role: this.role
        });

        console.log(result);
        if (result.status === 201) {
          localStorage.setItem('user-info', JSON.stringify(result.data));
          this.$router.push({ name: 'MyHome' });
        }
      } catch (error) {
        if (error.response && error.response.data) {
          this.errors = error.response.data.errors || {};
        } else {
          this.errors.general = 'An error occurred. Please try again later.';
        }
      }
    }
  },
  mounted() {
    const user = localStorage.getItem('user-info');
    if (user) {
      this.$router.push({ name: 'MyHome' });
    }
  }
};
</script>


<style scoped>
body {
  font-family: 'Arial', sans-serif;
  background-color: #ffffff;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  margin: 0;
}

.signup-container {
  background-color: rgba(132, 128, 128, 0.3);
  backdrop-filter: blur(8px);
  padding: 5px 40px;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  text-align: center;
  width: 100%;
  max-width: 450px;
  height: 700px;
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
  border: 1px solid #000000;
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
