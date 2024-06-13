export async function fetchShops() {
    const response = await fetch('/api/shops');
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.json();
  }
  
  export async function fetchPurchases() {
    const response = await fetch('/api/purchases');
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.json();
  }
  
  export async function addPurchase(data) {
    const response = await fetch('/api/purchases', {
      method: 'POST',
      body: data,
    });
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.json();
  }
  
  export async function deletePurchase(id) {
    const response = await fetch(`/api/purchases/${id}`, {
      method: 'DELETE',
    });
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
  }

  export async function fetchExchangeRates() {
    const response = await fetch('http://127.0.0.1:8000/api/exchange-rates');
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return await response.json();
  }
  