<template>

    <div>
      <div class="card-header-element">
          <h1>Classificacao de fornecedor para demanda {{ demanda.name }}</h1>
      </div>
      <TableList v-if="load">
        <thead>
                <tr>
                    <th>POSIÇÃO</th>
                    <th>JUSTIFICATIVA</th>
                    <th>FORNECEDOR</th>
                    <th>TELEFONE</th>
                    <th>EMAIL</th>
                    <th>DISTANCIA</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(datas, index) in data" :key="index">
                    <td>{{ datas.posicao }}</td>
                    <td>{{ datas.justificativa }}</td>
                    <td>{{datas.fornecedor.razao_social}}</td>
                    <td>{{datas.fornecedor.telefone}}</td>
                    <td>{{datas.fornecedor.email}}</td>
                    <td>{{datas.distancia_km}}</td>
                </tr>
            </tbody>
      </TableList>
      <h1 class="text-center" v-else>⚠️ {{mensagens}}</h1>
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
                  data:[],
                  demanda:[],
                  mensagens:"Carregando ...",
                  namedemanda:"",
                  iddemanda:""
              }
          },
          methods: {
            preencheCampos(data) {
                this.id = data.id
                this.name = data.name;
                this.description = data.description;
            },
            async loadclassificacao() {
                const response = await HttpGet(`demanda/${this.iddemanda}/classificacao`);
                this.data = response.data.data
                if (this.data.length <= 0) {
                    this.mensagens = "Não ha Forncedor para essa demanda"
                    return
                }
                this.load = true
            },
            async loadDemanda() {
                const response = await HttpGet(`demanda/${this.iddemanda}`);
                this.demanda = response.data.data
            },
          },
        mounted() {
            this.iddemanda = this.$route.params.iddemanda
            this.loadclassificacao();
            this.loadDemanda()
        },
      }
  </script>
