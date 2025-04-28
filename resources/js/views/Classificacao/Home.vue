<template>

    <div>
      <div class="card-header-element">
          <h1>Classificacao de fornecedor para demanda {{ iddemanda }}</h1>
      </div>
      <TableList v-if="load">
        <thead>
                <tr>
                    <th>POSIÇÃO</th>
                    <th>FORNECEDOR</th>
                    <th>TELEFONE</th>
                    <th>EMAIL</th>
                    <th>DISTANCIA</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="datas in data">
                    <td>{{datas.name}}</td>
                    <td>{{datas.description}}</td>
                </tr>
            </tbody>
      </TableList>
      <h1 class="text-center" v-else>Carregando ...</h1>
      </div>

  </template>



  <script>
      import TableList from "@/components/TableList.vue"
      import { HttpGet } from '@/composables/ServiceApi';
      import { useRoute } from 'vue-router';


      const route = useRoute();

      export default {
          components: {
              TableList,
          },
          data() {
              return {
                  load:false,
                  data:[{}],
                  iddemanda:""
              }
          },
          methods: {
            preencheCampos(data) {
                this.id = data.id
                this.name = data.name;
                this.description = data.description;
            },
            async loadServico() {
                const response = await HttpGet("servico/index");
                this.data = response.data.data
                this.load = true
            },
          },
        mounted() {
            const idDemanda = route.params.idDemanda
            this.loadServico();
            this.iddemanda = idDemanda
        },
      }
  </script>
