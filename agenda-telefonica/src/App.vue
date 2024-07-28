<script setup>
import { RouterLink, RouterView } from 'vue-router'
import NavBarComponent from './components/NavBarComponent.vue';
</script>

<template>
  <nav>
    <NavBarComponent />
  </nav>
  <RouterView />
</template>

<style scoped>

</style>
