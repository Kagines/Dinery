<template>
  <div class="signup-container">
    <img class="logo" src="../assets/Dinery Logo.png" alt="Dinery Logo">
    <h1>Sign Up</h1>
    <form class="register-form">
      <div class="input-group">
        <input type="text" v-model= "name" class="input" placeholder="Enter Name" required>
        <span class="error-message"></span> </div>
      <div class="input-group">
        <input type="email" v-model= "email" class="input" placeholder="Enter Email" required>
        <span class="error-message"></span> </div>
      <div class="input-group">
        <input type="password" v-model= "password" class="input" placeholder="Enter Password" required>
        <span class="error-message"></span> </div>
      <button class="button" type="submit" v-on:click="signUp">Sign Up</button>
      <p>
      <router-link to="/login">Login</router-link>
    </p>
    </form>
  </div>
</template>
<script>
import axios from 'axios'

export default{
    name: 'MySignUp',
    data(){
        return{
            name:'',
            email:'',
            password:''
        }
    },
    methods:{
        async signUp(event){
          event.preventDefault();
            let result= await axios.post("http://localhost:3000/users",{
                name:this.name,
                email:this.email,
                password:this.password
            });

            console.log(result);
            if(result.status==201)
            {
                localStorage.setItem("user-info",JSON.stringify(result.data))
                this.$router.push({name:'MyHome'})
            }
        }
    },
    mounted(){
      let user=localStorage.getItem('user-info');
      if(user){
        this.$router.push({name:'MyHome'})
      }
    }
}
</script>

<style>

</style>
