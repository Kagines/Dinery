<template>
  <div>
    <MyHeader />
    <div class="container">
      <h1 class="heading">Analytics Overview</h1>
      <div class="data-cards">
        <div class="card">
          <h2>Total Restaurants</h2>
          <p>{{ analyticsData.totalRestaurants }}</p>
        </div>
        <div class="card">
          <h2>Total Users</h2>
          <p>{{ analyticsData.totalUsers }}</p>
        </div>
        <div class="card">
          <h2>Average Restaurant Age (Days)</h2>
          <p>{{ analyticsData.averageRestaurantAge }}</p>
        </div>
        <div class="card">
          <h2>Average Time Since Last Login (Days)</h2>
          <p>{{ analyticsData.averageLastLogin }}</p>
        </div>
      </div>
      <div class="chart-container">
        <h2>Analytics Chart</h2>
        <canvas id="myChart"></canvas>
      </div>
    </div>
  </div>
</template>

<script>
import MyHeader from './MyHeader.vue';
import axios from 'axios';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

export default {
  name: 'MyAnalytics',
  components: {
    MyHeader
  },
  data() {
    return {
      analyticsData: {}
    };
  },
  async mounted() {
    try {
      const response = await axios.get('http://localhost:8080/analytics');
      this.analyticsData = response.data;
      this.renderChart();
    } catch (error) {
      console.error("Error fetching analytics data:", error);
    }
  },
  methods: {
    renderChart() {
      const ctx = document.getElementById('myChart').getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['Total Restaurants', 'Total Users', 'Average Restaurant Age', 'Average Last Login'],
          datasets: [{
            label: 'Analytics Data',
            data: [
              this.analyticsData.totalRestaurants,
              this.analyticsData.totalUsers,
              this.analyticsData.averageRestaurantAge,
              this.analyticsData.averageLastLogin
            ],
            backgroundColor: [
              '#4CAF50',
              '#FFC107',
              '#2196F3',
              '#F44336'
            ]
          }]
        },
        options: {
          responsive: true,
          scales: {
            x: {
              beginAtZero: true
            }
          }
        }
      });
    }
  }
};
</script>

<style scoped>
.container {
  max-width: 800px;
  margin: 50px auto;
  padding: 20px;
  background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
  border-radius: 10px; /* Curved edges */
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Drop shadow */
}

.heading {
  text-align: center;
}

.data-cards {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  margin-bottom: 20px;
}

.card {
  flex: 1;
  min-width: 200px;
  padding: 15px;
  margin: 10px;
  background-color: #f4f4f4;
  border-radius: 8px;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
  text-align: center;
}

.card h2 {
  margin: 0;
  font-size: 1.2em;
}

.card p {
  font-size: 1.5em;
  margin: 10px 0 0;
}

.chart-container {
  margin-top: 20px;
}

#myChart {
  max-width: 100%;
}
</style>
