<template>
    <div>
      <button @click="switchCurrency('all')">All</button>
      <button @click="switchCurrency('USD')">USD</button>
      <button @click="switchCurrency('EUR')">EUR</button>
      <button @click="switchCurrency('RUB')">RUB</button>
    </div>
  </template>
  
  <script>
  export default {
    name: 'CurrencySwitcher',
    methods: {
      switchCurrency(currency) {
        this.$emit('currency-changed', currency);
      },
    },
  };
  </script>
  