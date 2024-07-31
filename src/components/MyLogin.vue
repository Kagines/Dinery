<template>
  <div class="login-container">
    <img class="logo" src="../assets/dinery1.png" alt="Dinery Logo">
    <h1>Login</h1>
    <form class="login" @submit.prevent="login">
      <div class="input-group">
        <input type="email" v-model="email" class="input" placeholder="Enter Email" required>
        <span class="error-message" v-if="emailError">{{ emailError }}</span>
      </div>
      <div class="input-group">
        <input type="password" v-model="password" class="input" placeholder="Enter Password" required>
        <span class="error-message" v-if="passwordError">{{ passwordError }}</span>
      </div>
      <button class="button" type="submit">Login</button>
      <p class="error-message" v-if="loginError">{{ loginError }}</p>
      <p>
        <router-link to="/sign-up">Sign Up</router-link>
      </p>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'MyLogin',
  data() {
    return {
      email: '',
      password: '',
      emailError: '',
      passwordError: '',
      loginError: ''
    };
  },
  methods: {
    async login() {
      // Reset error messages
      this.emailError = '';
      this.passwordError = '';
      this.loginError = '';

      // Basic validation
      if (!this.validateEmail(this.email)) {
        this.emailError = 'Invalid email format';
        return;
      }
      if (this.password.length < 6) {
        this.passwordError = 'Password must be at least 6 characters';
        return;
      }

      try {
        const response = await axios.get('http://localhost:8080/users', {
          params: {
            email: this.email,
            password: this.password
          }
        });

        // Handle successful login
        if (response.status === 200 && response.data.length > 0) {
          const user = response.data[0];
          localStorage.setItem("user-info", JSON.stringify(user));
          if (user.role === 'admin') {
            this.$router.push({ name: 'MyHome' });
          } else if (user.role === 'user') {
            this.$router.push({ name: 'MyHome' }); // or some other user-specific page
          }
        } else {
          this.loginError = 'Invalid email or password';
        }
      } catch (error) {
        this.loginError = 'An error occurred during login. Please try again.';
        console.error('Login error:', error);
        if (error.response) {
          console.error('Response data:', error.response.data);
          console.error('Response status:', error.response.status);
          console.error('Response headers:', error.response.headers);
        } else {
          console.error('Error message:', error.message);
        }
      }
    },
    validateEmail(email) {
      const re = /^(([^<>().\]\\.,;:\s@"]+(\.[^<>().\]\\.,;:\s@"]+)*)|(".+"))@(([^<>()[\]\\.,;:\s@"]+\.)+[^<>()[\]\\.,;:\s@"]{2,})$/i;
      return re.test(String(email).toLowerCase());
    }
  },
  mounted() {
    const user = localStorage.getItem('user-info');
    if (user) {
      const userInfo = JSON.parse(user);
      if (userInfo.role === 'admin' || userInfo.role === 'user') {
        this.$router.push({ name: 'MyHome' });
      }
    }
  }
};
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
