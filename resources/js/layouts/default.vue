
<script>
import NavBar from "../components/NavBar";
import SideBar from "../components/SideBar";
import FooterBar from "../components/FooterBar";
import Child from "../components/Child.vue";

export default {
  name: "MainLayout",
  components: {
    NavBar,
    SideBar,
    FooterBar,
    Child,
  },
};
</script>
<template>
  <div class="main-layout main-wrapper">
    <SideBar />
    <div class="page-wrapper">
      <!-- partial:partials/_navbar.html -->
      <NavBar />
      <!-- partial -->
      <div class="page-content"><child /></div>
      <!-- partial:partials/_footer.html -->
      <FooterBar />
      <!-- partial -->
    </div>
  </div>
</template>

<style>
@import "../assets/css/demo_1/style.css";
</style>    
