<template>
    <div class="modal">
      <form @submit.prevent="addPurchase">
        <div>
          <label for="shop">Магазин</label>
          <select v-model="shopId" required>
            <option v-for="shop in shops" :key="shop.id" :value="shop.id">{{ shop.name }}</option>
          </select>
        </div>
        <div>
          <label for="date">Дата</label>
          <input type="date" v-model="date" required>
        </div>
        <div>
          <label for="amount">Сумма</label>
          <input type="number" v-model="amount" required>
        </div>
        <div>
          <label for="currency">Валюта</label>
          <select v-model="currency" required>
            <option value="USD">USD</option>
            <option value="EUR">EUR</option>
            <option value="RUB">Руб</option>
          </select>
        </div>
        <div>
          <label for="document">Документ</label>
          <input type="file" @change="handleFileUpload" required>
        </div>
        <button type="submit">Добавить покупку</button>
        <button type="button" @click="$emit('close')">Отмена</button>
      </form>
    </div>
  </template>
  
  <script>
  import { fetchShops, addPurchase } from '../api';
  
  export default {
    name: 'AddPurchase',
    data() {
      return {
        shops: [],
        shopId: '',
        date: '',
        amount: '',
        currency: 'USD',
        document: null,
      };
    },
    created() {
      this.loadShops();
    },
    methods: {
      async loadShops() {
        try {
          this.shops = await fetchShops();
        } catch (error) {
          console.error('Error fetching shops:', error);
        }
      },
      handleFileUpload(event) {
        this.document = event.target.files[0];
      },
      async addPurchase() {
        const formData = new FormData();
        formData.append('shop_id', this.shopId);
        formData.append('date', this.date);
        formData.append('amount', this.amount);
        formData.append('currency', this.currency);
        formData.append('document', this.document);
  
        try {
          await addPurchase(formData);
          this.$emit('purchase-added');
          this.$emit('close');
        } catch (error) {
          console.error('Error adding purchase:', error);
        }
      },
    },
  };
  </script>
  
  <style src="../assets/styles.css"></style>
  