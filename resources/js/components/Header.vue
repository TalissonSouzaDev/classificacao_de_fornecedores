<template>
    <nav class="header">
        <ul class="header-menu list-none d-flex-row">
            <li><router-link to="/demanda">Demanda</router-link></li>
            <li><router-link to="/fornecedor">Fornecedor</router-link></li>
            <li><router-link to="/servico">Serviço</router-link></li>
        </ul>
    </nav>
</template>

<script>
 export default {
    name: "Header"
 }
</script>
