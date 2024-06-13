<template>
    <div class="modal">
      <div class="modal-content">
        <span class="close" @click="$emit('close')">&times;</span>
        <h2>{{ purchase.id ? 'Редактировать покупку' : 'Добавить покупку' }}</h2>
        <form @submit.prevent="save">
          <label for="shop">Магазин:</label>
          <select v-model="localPurchase.shop_id" required>
            <option v-for="shop in shops" :key="shop.id" :value="shop.id">{{ shop.name }}</option>
          </select>
  
          <label for="date">Дата:</label>
          <input type="date" v-model="localPurchase.date" required>
  
          <label for="amount">Сумма:</label>
          <input type="number" v-model="localPurchase.amount" required>
  
          <label for="currency">Валюта:</label>
          <select v-model="localPurchase.currency" required>
            <option value="USD">USD</option>
            <option value="EUR">EUR</option>
            <option value="RUB">RUB</option>
          </select>
  
          <label for="document">Документ:</label>
          <input type="file" @change="handleFileUpload" accept=".pdf,.jpg,.jpeg" required>
  
          <button type="submit">Сохранить</button>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'AddPurchaseModal',
    props: {
      shops: Array,
      purchase: Object,
    },
    data() {
      return {
        localPurchase: { ...this.purchase }, // Создаем копию объекта purchase
        file: null,
      };
    },
    watch: {
      purchase: {
        immediate: true,
        handler(newValue) {
          this.localPurchase = { ...newValue }; // Обновляем копию при изменении prop
        }
      }
    },
    methods: {
      save() {
        const newPurchase = {
          ...this.localPurchase,
          document: this.file ? this.file.name : this.localPurchase.document,
        };
        this.$emit('save', newPurchase);
      },
      handleFileUpload(event) {
        this.file = event.target.files[0];
      },
    },
  };
  </script>
  
  <style scoped>
  /* Стили для модального окна */
  .modal {
    display: block;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
  }
  
  .modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
    border-radius: 10px;
  }
  
  .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }
  
  .close:hover,
  .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }
  
  form {
    display: flex;
    flex-direction: column;
  }
  
  label {
    margin-top: 10px;
  }
  
  input, select, button {
    margin-top: 5px;
    padding: 10px;
    font-size: 16px;
  }
  
  button {
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
  
  button:hover {
    background-color: #45a049;
  }
  </style>
  