<template>
    <div>
      <Header></Header>
      <main>
        <router-view />
      </main>
    </div>
</template>


<script>
    import Header from "./components/Header.vue"
    import Footer from "./components/Footer.vue"
    export default {
        components: {
            Header,
            Footer
        }
    } 
</script>