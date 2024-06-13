<template>
    <div>
      <h2>{{ isEdit ? 'Редактировать' : 'Добавить' }} покупку</h2>
      <form @submit.prevent="submitForm">
        <div>
          <label for="shop">Магазин:</label>
          <input type="text" id="shop" v-model="purchase.shop" required />
        </div>
        <div>
          <label for="date">Дата:</label>
          <input type="date" id="date" v-model="purchase.date" required />
        </div>
        <div>
          <label for="amount">Сумма:</label>
          <input type="number" id="amount" v-model="purchase.amount" required />
          <select v-model="purchase.currency">
            <option value="USD">USD</option>
            <option value="EUR">EUR</option>
            <option value="RUB">RUB</option>
          </select>
        </div>
        <div>
          <label for="document">Документ:</label>
          <input type="file" id="document" @change="handleFileUpload" accept=".pdf,.jpg" />
        </div>
        <button type="submit">{{ isEdit ? 'Сохранить' : 'Добавить' }}</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    name: 'PurchaseForm',
    props: {
      purchaseData: {
        type: Object,
        default: () => ({
          shop: '',
          date: '',
          amount: 0,
          currency: 'USD',
          document: null
        })
      },
      isEdit: {
        type: Boolean,
        default: false
      }
    },
    data() {
      return {
        purchase: { ...this.purchaseData },
        documentFile: null
      };
    },
    methods: {
      handleFileUpload(event) {
        this.documentFile = event.target.files[0];
      },
      async submitForm() {
        const formData = new FormData();
        formData.append('shop', this.purchase.shop);
        formData.append('date', this.purchase.date);
        formData.append('amount', this.purchase.amount);
        formData.append('currency', this.purchase.currency);
        if (this.documentFile) {
          formData.append('document', this.documentFile);
        }
  
        try {
          if (this.isEdit) {
            await this.$http.put(`/api/purchases/${this.purchase.id}`, formData);
          } else {
            await this.$http.post('/api/purchases', formData);
          }
          this.$emit('form-submitted');
        } catch (error) {
          console.error('Error submitting form:', error);
        }
      }
    }
  };
  </script>
  
  <style scoped>
  /* ваши стили */
  </style>
  