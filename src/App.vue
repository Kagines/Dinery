<template>
  <router-view />
</template>

<script>

export default {
  name: 'App',
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}

.signup-container, .login-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 100vh; /* Ensures full viewport height */
  background-color: #f5f5f5; /* Light background for contrast */
}

body {
  padding:0;
  margin:0;
}

.logo {
  width: 200px; /* Adjust logo size as needed */
  margin-bottom: 20px;
}

.register-form, .login, .add, .update{
  display: flex;
  flex-direction: column;
  width: 400px; /* Adjust form width as needed */
  padding: 20px;
  border-radius: 5px;
  background-color: #fff; /* White background for form */
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
}

.input-group {
  margin-bottom: 15px;
}

.input {
  width: 100%;
  padding: 10px 5px;
  border: 1px solid skyblue;
  border-radius: 3px;
  font-size: 16px;
  transition: border-color 0.2s ease-in-out; /* Smoother border transitions */
}

.input:focus {
  border-color: #3399ff; /* Blue border on focus */
}

.error-message {
  color: red; /* Error message styling */
  font-size: 12px;
  visibility: hidden; /* Initially hidden */
}

.error-message.active {
  visibility: visible; /* Display error message on validation failure */
}

button {
  background-color: #3399ff; /* Blue button color */
  color: #fff; /* White button text */
  padding: 10px 20px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
  transition: background-color 0.2s ease-in-out;
}

button:hover {
  background-color: #2eafff; /* Darker blue on hover */
}
</style>
