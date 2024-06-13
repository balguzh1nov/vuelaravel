<template>
  <div>
    <h1>Добро пожаловать на страницу покупок!</h1>
    <p>Вы можете перейти к списку магазинов или покупок.</p>
    <router-link to="/shops">Список магазинов</router-link>
    <router-link to="/purchases">Список покупок</router-link>
  </div>
</template>

<script>
export default {
  name: 'HomePage',
};
</script>

<style scoped>
h1 {
  font-size: 24px;
  margin-bottom: 20px;
}
p {
  font-size: 18px;
  margin-bottom: 20px;
}
a {
  display: block;
  margin-bottom: 10px;
  color: blue;
}
a:hover {
  text-decoration: underline;
}
</style>
