<template>
<MyHeader />
<h1>Hello User, Welcome on Add Restaurant Page</h1>
<form class="add">
      <div class="input-group">
        <input type="text" v-model="restaurant.name" class="input" placeholder="Enter Name" required>
      </div>
      <div class="input-group">
        <input type="text" v-model="restaurant.address" class="input" placeholder="Enter Address" required>
      </div>
      <div class="input-group">
        <input type="text" v-model="restaurant.contact" class="input" placeholder="Enter Contact" required>
      </div>
      <button type="submit" v-on:click="addRestaurant">Add new Restaurant</button>
    </form>
</template>

<script>
import MyHeader from './MyHeader.vue';
import axios from 'axios';

export default {
    name:'MyAddRest',
    components:{
      MyHeader
    },

    data(){
      return{
        restaurant :{
          name:'',
          address:'',
          contact:''
        }
      }
    },
    methods:{
      async addRestaurant(event){
        event.preventDefault()
        console.warn(this.restaurant)
        const result=await axios.post('http://localhost:3000/restaurant',{
          name:this.restaurant.name,
          address:this.restaurant.address,
          contact:this.restaurant.contact
        });
        if(result.status===201){
          this.$router.push({name:'MyHome'})
        }
        console.warn("result",result)
      }

    },

    mounted(){
      let user=localStorage.getItem('user-info');
      if(!user){
        this.$router.push({name:'MySignUp'})
      }
    }
}
</script>
