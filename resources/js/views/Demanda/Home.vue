<template>
    <div class="m-50 mb-15">
      <h1>Demanda</h1>
      <TableList/>
    </div>
</template>



<script>
    import Header from "../../components/Header.vue"
    import TableList from "../../components/TableList.vue"
   
    export default {
        components: {
            Header,
            TableList,
        }
    } 
</script>