<template>
  <div>
    <MyHeader />
    <div class="review-container">
      <h1 v-if="restaurant.name">Reviews for {{ restaurant.name }}</h1>
      <div v-if="reviews.length" class="reviews-section">
        <ul class="review-list">
          <li v-for="review in reviews" :key="review.id" class="review-item">
            <div class="review-box">
              <h3 class="review-title">{{ review.title || 'No Title' }}</h3>
              <p class="review-comments">{{ review.comments || 'No Comments' }}</p>
              <p class="rating">Rating: {{ renderStars(review.rating || 0) }}</p>
              <p class="review-meta">by {{ review.name || 'anonymous' }} on {{ formatDate(review.date) }}</p>
            </div>
          </li>
        </ul>
      </div>
      <div v-else>
        <p>No reviews yet. Be the first to review!</p>
      </div>
      <div class="add-review">
        <h2>Add Review</h2>
        <form @submit.prevent="submitReview">
          <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" v-model="newReview.title" required />
          </div>
          <div class="form-group">
            <label for="comments">Comments:</label>
            <textarea id="comments" v-model="newReview.comments" required></textarea>
          </div>
          <div class="form-group">
            <label for="rating">Rating:</label>
            <div class="rating-input">
              <span v-for="star in 5" :key="star" @click="newReview.rating = star" class="star" :class="{ filled: newReview.rating >= star }">&#9733;</span>
            </div>
          </div>
          <button type="submit">Submit Review</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import MyHeader from './MyHeader.vue';
import axios from 'axios';

export default {
  name: 'MyReviewPage',
  components: {
    MyHeader
  },
  data() {
    return {
      restaurant: {},
      reviews: [],
      newReview: {
        title: '',
        comments: '',
        rating: null,
        name: '', // This will be set to the logged-in user's name
        date: new Date().toISOString().split('T')[0] // Current date in YYYY-MM-DD format
      },
    };
  },
  methods: {
    async fetchRestaurant() {
      const restaurantId = this.$route.params.id;
      try {
        const response = await axios.get(`http://localhost:8080/restaurants/${restaurantId}`);
        this.restaurant = response.data;
        console.log('Fetched restaurant:', this.restaurant); // Debug log
      } catch (error) {
        console.error('Error fetching restaurant:', error);
      }
    },
    async fetchReviews() {
      const restaurantId = this.$route.params.id;
      try {
        const response = await axios.get(`http://localhost:8080/reviews?restaurantId=${restaurantId}`);
        this.reviews = response.data;
        console.log('Fetched reviews:', this.reviews); // Debug log
      } catch (error) {
        console.error('Error fetching reviews:', error);
      }
    },
    async submitReview() {
      const restaurantId = this.$route.params.id;
      const newReview = { ...this.newReview, restaurantId };
      try {
        // Fetch user info from local storage
        const user = localStorage.getItem('user-info');
        if (user) {
          const userInfo = JSON.parse(user);
          newReview.name = userInfo.name; // Set user name from local storage
        } else {
          console.error('User not logged in.');
          return;
        }
        
        const response = await axios.post('http://localhost:8080/reviews', newReview);
        if (response.status === 201) {
          this.reviews.push(response.data);
          this.newReview = { title: '', comments: '', rating: null, name: '', date: new Date().toISOString().split('T')[0] };
        } else {
          console.error('Error adding review:', response.status, response.data);
        }
      } catch (error) {
        console.error('Error adding review:', error);
      }
    },
    formatDate(date) {
      if (!date) return 'Invalid Date';
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(date).toLocaleDateString(undefined, options);
    },
    renderStars(rating) {
      return '★'.repeat(rating) + '☆'.repeat(5 - rating);
    },
  },
  async mounted() {
    await this.fetchRestaurant();
    await this.fetchReviews();
  },
};
</script>


<style scoped>
.review-container {
  padding: 20px;
  background: rgba(255, 255, 255, 0.8);
  margin: 50px 20px;
  border-radius: 10px;
  max-width: 800px;
  margin-left: auto;
  margin-right: auto;
}

h1, h2 {
  color: #333;
  text-align: center;
  font-size: 2em;
  margin-bottom: 20px;
}

.reviews-section {
  margin-top: 30px;
}

.review-list {
  list-style-type: none;
  padding: 0;
}

.review-item {
  margin-bottom: 20px;
}

.review-box {
  background-color: #f9f9f9;
  border: 1px solid #ddd;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.review-title {
  margin-top: 0;
  font-size: 1.5em;
  font-weight: bold;
  color: #333;
}

.review-comments {
  font-size: 1em;
  color: #555;
}

.rating {
  font-weight: bold;
  color: #ffa500;
  margin: 10px 0;
}

.rating-input {
  display: flex;
  justify-content: center;
}

.star {
  font-size: 1.5em;
  cursor: pointer;
}

.star.filled {
  color: #ffa500;
}

.review-meta {
  color: #777;
  font-size: 0.9em;
  margin-top: 10px;
}

.add-review {
  margin-top: 40px;
}

form {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.form-group {
  margin-bottom: 15px;
  width: 100%;
  max-width: 500px;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

input, textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 1em;
}

textarea {
  height: 100px;
}

button {
  padding: 10px 20px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 1em;
}

button:hover {
  opacity: 0.8;
}
</style>
