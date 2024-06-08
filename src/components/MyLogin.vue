<template>
  <div class="login-container">
    <img class="logo" src="../assets/Dinery Logo.png" alt="Dinery Logo">
    <h1>Login</h1>
    <form class="login">
      <div class="input-group">
        <input type="email" v-model= "email" class="input" placeholder="Enter Email" required>
        <span class="error-message"></span> </div>
      <div class="input-group">
        <input type="password" v-model= "password" class="input" placeholder="Enter Password" required>
        <span class="error-message"></span> </div>
      <button class="button" type="submit" v-on:click=login>Login</button>
      <p>
      <router-link to="/sign-up">Sign Up</router-link>
    </p>
    </form>
  </div>
</template>

<script>
import axios from 'axios'

export default {
    name:'MyLogin',
    data(){
        return{
            email:'',
            password:''
        }
    },
   methods: {
  async login(event) {
    event.preventDefault(); // Prevent default form submission

    const email = this.email; // Store email in a variable for better readability
    const password = this.password; // Store password in a variable for better readability

    try {
      const response = await axios.get(
        `http://localhost:3000/users?email=${email}&password=${password}`
      );

      // Handle successful login (expected status code is likely 200)
      if (response.status === 200 && response.data.length>0) {

                localStorage.setItem("user-info",JSON.stringify(response.data[0]))
                this.$router.push({name:'MyHome'})
            
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
 mounted(){
      let user=localStorage.getItem('user-info');
      if(user){
        this.$router.push({name:'MyHome'})
      }
    }

};
</script>
