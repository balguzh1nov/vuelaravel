<template>
    <div>
      <input type="text" v-model="search" placeholder="поиск" />
      <div class="currency-switcher">
        <button @click="setCurrency('all')" :class="{ active: currency === 'all' }">all</button>
        <button @click="setCurrency('USD')" :class="{ active: currency === 'USD' }">USD</button>
        <button @click="setCurrency('EUR')" :class="{ active: currency === 'EUR' }">EUR</button>
        <button @click="setCurrency('RUB')" :class="{ active: currency === 'RUB' }">РУБ</button>
      </div>
      <table>
        <thead>
          <tr>
            <th>Магазин</th>
            <th>Дата</th>
            <th>Сумма</th>
            <th>Документ</th>
            <th>Действие</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="purchase in filteredPurchases" :key="purchase.id">
            <td>
              <router-link v-if="purchase.shop" :to="{ name: 'PurchasesByShop', params: { shopId: purchase.shop.id } }">
                {{ purchase.shop.name }}
              </router-link>
              <span v-else>Unknown Shop</span>
            </td>
            <td>{{ purchase.date }}</td>
            <td>{{ formatCurrency(convertCurrency(purchase.amount, purchase.currency), displayCurrency) }}</td>
            <td><a :href="purchase.document" target="_blank">{{ getFileName(purchase.document) }}</a></td>
            <td>
              <button @click="editPurchase(purchase)">✏️</button>
              <button @click="deletePurchase(purchase.id)">🗑️</button>
            </td>
          </tr>
        </tbody>
      </table>
      <button @click="openAddPurchaseModal" class="add-button">Добавить</button>
      
      <AddPurchaseModal 
        v-if="showAddPurchaseModal" 
        @close="closeAddPurchaseModal" 
        @save="savePurchase"
        :shops="shops"
        :purchase="currentPurchase"
      />
    </div>
  </template>
  
  <script>
  import AddPurchaseModal from './AddPurchaseModal.vue';
  
  export default {
    name: 'PurchaseList',
    components: {
      AddPurchaseModal,
    },
    data() {
      return {
        purchases: [],
        search: '',
        currency: 'all',
        exchangeRates: {},
        showAddPurchaseModal: false,
        shops: [],
        currentPurchase: {}, // текущая покупка для редактирования
      };
    },
    computed: {
      filteredPurchases() {
        return this.purchases.filter(purchase => 
          purchase.shop && purchase.shop.name.toLowerCase().includes(this.search.toLowerCase())
        );
      },
      displayCurrency() {
        return this.currency === 'all' ? '' : this.currency;
      },
    },
    methods: {
      async fetchPurchases() {
        try {
          const response = await fetch('http://127.0.0.1:8000/api/purchases');
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          const data = await response.json();
          this.purchases = data;
        } catch (error) {
          console.error('Error fetching purchases:', error);
        }
      },
      async fetchExchangeRates() {
        try {
          const response = await fetch('http://127.0.0.1:8000/api/exchange-rates');
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          const data = await response.json();
          this.exchangeRates = data.rates;
        } catch (error) {
          console.error('Error fetching exchange rates:', error);
        }
      },
      async fetchShops() {
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
      convertCurrency(amount, currency) {
        if (this.currency === 'all' || this.currency === currency) {
          return amount;
        }
        const rate = this.exchangeRates[`${currency}_${this.currency}`];
        if (!rate) {
          console.warn(`Exchange rate for ${currency} to ${this.currency} not found.`);
          return amount;
        }
        return (amount * rate).toFixed(2);
      },
      formatCurrency(amount, currency) {
        return currency ? `${amount} ${currency}` : amount;
      },
      setCurrency(currency) {
        this.currency = currency;
      },
      editPurchase(purchase) {
        this.currentPurchase = { ...purchase }; // Копируем текущую покупку для редактирования
        this.openAddPurchaseModal();
      },
      async deletePurchase(id) {
        try {
          const response = await fetch(`http://127.0.0.1:8000/api/purchases/${id}`, {
            method: 'DELETE',
          });
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          this.purchases = this.purchases.filter(purchase => purchase.id !== id);
        } catch (error) {
          console.error('Error deleting purchase:', error);
        }
      },
      openAddPurchaseModal() {
        this.showAddPurchaseModal = true;
      },
      closeAddPurchaseModal() {
        this.showAddPurchaseModal = false;
        this.currentPurchase = {}; // Очистка текущей покупки
      },
      async savePurchase(purchase) {
        try {
          const method = purchase.id ? 'PUT' : 'POST';
          const url = purchase.id ? `http://127.0.0.1:8000/api/purchases/${purchase.id}` : 'http://127.0.0.1:8000/api/purchases';
          const response = await fetch(url, {
            method,
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(purchase),
          });
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          const savedPurchase = await response.json();
          if (purchase.id) {
            this.purchases = this.purchases.map(p => (p.id === savedPurchase.id ? savedPurchase : p));
          } else {
            this.purchases.push(savedPurchase);
          }
          this.closeAddPurchaseModal();
        } catch (error) {
          console.error('Error saving purchase:', error);
        }
      },
      getFileName(path) {
        return path.split('/').pop();
      },
    },
    async mounted() {
      await this.fetchPurchases();
      await this.fetchExchangeRates();
      await this.fetchShops();
    },
  };
  </script>
  
  <style scoped>
  table {
    width: 100%;
    border-collapse: collapse;
  }
  
  th, td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }
  
  th {
    background-color: #f2f2f2;
  }
  
  tr:hover {
    background-color: #f5f5f5;
  }
  
  .currency-switcher {
    margin: 10px 0;
  }
  
  .currency-switcher button {
    margin-right: 10px;
    padding: 5px 10px;
    cursor: pointer;
  }
  
  .currency-switcher .active {
    font-weight: bold;
  }
  
  .add-button {
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
  
  .add-button:hover {
    background-color: #45a049;
  }
  
  input[type="text"] {
    padding: 5px;
    width: 200px;
    margin-bottom: 10px;
  }
  </style>
  