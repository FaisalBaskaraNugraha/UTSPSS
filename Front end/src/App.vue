<template>
  <div id="app" class="app-container">
    <Navbar />
    <main class="main-content container">
      <router-view />
    </main>
    </div>
</template>

<script setup>
import Navbar from './components/Navbar.vue';

</script>

<style>

.app-container {
    min-height: 100vh;
    background-color: #f4f4f4;
}

.main-content {
    padding-top: 1rem;
    padding-bottom: 1rem;
}


h1 {
    font-size: 1.5rem; /* Sesuaikan ukuran heading */
    font-weight: bold;
    margin-bottom: 1rem;
}
</style>