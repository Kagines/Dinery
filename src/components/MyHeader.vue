<template>
  <div class="nav">
    <img src="../assets/dinery1.png" alt="Logo" class="logo1">
    <router-link to="/">Home</router-link>
    <router-link v-if="user && user.role === 'admin'" to="/add">Add Restaurant</router-link>
    <router-link v-if="user && user.role === 'admin'" to="/analytics">Analytics</router-link>
    <router-link v-if="user" @click="logout" to="#">Logout</router-link>
  </div>
</template>

<script>
export default {
  name: 'MyHeader',
  data() {
    return {
      user: null
    };
  },
  created() {
    this.user = JSON.parse(localStorage.getItem('user-info'));
  },
  methods: {
    logout(event) {
      event.preventDefault();
      localStorage.removeItem('user-info');
      this.$router.push({ name: 'MyLogin' });
    }
  }
};
</script>
  
  <style>
  .nav {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: 20px;
    overflow: hidden;
    padding: 15px 40px;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 1000;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    width: auto;
  }
  
  .nav a {
    color: #fff;
    font-size: 20px;
    text-decoration: none;
    padding: 10px;
    transition: color 0.3s;
  }
  
  .nav a:not(:last-child) {
    margin-right: 20px; /* Equal space between links */
  }
  
  .nav a:hover {
    color: red;
  }
  
  .logo1 {
    width: 80px; /* Increased logo size */
    height: auto;
    margin-right: 20px; /* Space between logo and "Home" link */
    display: block;
    margin: 0 auto;
  }
  </style>
  