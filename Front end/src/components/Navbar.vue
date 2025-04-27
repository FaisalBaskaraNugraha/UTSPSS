<template>
    <nav class="navbar">
      <div class="navbar-container container">
        <router-link to="/" class="navbar-brand">Inventory App</router-link>
        <ul class="navbar-nav">
          <li><router-link to="/items">Items</router-link></li>
          <li><router-link to="/categories">Categories</router-link></li>
          <li><router-link to="/suppliers">Suppliers</router-link></li>
          <li class="dropdown">
             <span class="dropdown-toggle">Reports</span>
             <ul class="dropdown-menu">
                 <li><router-link to="/reports/stock-summary">Stock Summary</router-link></li>
                 <li><router-link to="/reports/low-stock">Low Stock</router-link></li>
                 </ul>
          </li>
          </ul>
      </div>
    </nav>
  </template>
  
  <script setup>

  </script>
  
  <style scoped>
  /* Styling khusus navbar menggunakan CSS biasa */
  .navbar {
    background-color: #3b82f6; /* blue-600 */
    color: white;
    padding: 1rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* shadow-md */
  }
  
  .navbar-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
  }
  
  .navbar-brand {
    font-size: 1.25rem; /* text-xl */
    font-weight: bold;
    color: white;
    text-decoration: none;
  }
  
  .navbar-brand:hover {
      color: #bfdbfe; /* blue-200 */
  }
  
  .navbar-nav {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    gap: 1rem; /* space-x-4 */
  }
  
  .navbar-nav li {
      position: relative; /* For dropdown */
  }
  
  .navbar-nav a {
    color: white;
    text-decoration: none;
  }
  
  .navbar-nav a:hover {
      color: #bfdbfe; /* blue-200 */
  }
  
  /* Dropdown styles */
  .dropdown {
      position: relative;
  }
  
  .dropdown-toggle {
      cursor: pointer;
  }
  
  .dropdown-toggle:hover {
      color: #bfdbfe; /* blue-200 */
  }
  
  .dropdown-menu {
      position: absolute;
      top: 100%; /* Position below the toggle */
      right: 0; /* Align to the right */
      background-color: white;
      color: #333; /* gray-800 */
      margin-top: 0.5rem; /* mt-2 */
      padding: 0.25rem 0; /* py-1 */
      border-radius: 0.25rem; /* rounded */
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* shadow-lg */
      width: 10rem; /* w-40 */
      list-style: none;
      z-index: 10; /* Ensure it's above other content */
      display: none; /* Hidden by default */
  }
  
  .dropdown:hover .dropdown-menu {
      display: block; /* Show on hover */
  }
  
  .dropdown-menu li {
      margin: 0;
  }
  
  .dropdown-menu a {
      display: block; /* block */
      padding: 0.5rem 1rem; /* px-4 py-2 */
      color: #333; /* text-gray-800 */
      text-decoration: none;
  }
  
  .dropdown-menu a:hover {
      background-color: #f3f4f6; /* hover:bg-gray-100 */
  }
  </style>