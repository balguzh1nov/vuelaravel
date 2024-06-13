<template>
    <div>
      <h1>Shops</h1>
      <ul>
        <li v-for="shop in shops" :key="shop.id">
          <router-link :to="{ name: 'Purchases', params: { shopId: shop.id }}">{{ shop.name }}</router-link>
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        shops: [],
      };
    },
    async created() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/shops');
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        const data = await response.json();
        this.shops = data;
      } catch (error) {
        console.error('Error fetching shops:', error);
      }
    },
  };
  </script>
  