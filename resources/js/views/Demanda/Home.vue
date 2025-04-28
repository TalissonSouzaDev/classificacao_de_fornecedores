<template>

    <div>
      <div class="card-header-element">
          <h1>Demandas</h1>
          <button class="button success" @click="AbrirModalCreate"><font-awesome-icon icon="plus" /></button>
      </div>
      <TableList v-if="load">
        <thead>
                <tr>
                    <th>DEMANDA</th>
                    <th>CEP</th>
                    <th>CRIAÇÃO</th>
                    <th>SERVIÇO</th>
                    <th>AÇÕES</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="datas in data">
                    <td>{{datas.name}}</td>
                    <td>{{datas.cep_demanda}}</td>
                    <td>{{datas.data_criacao}}</td>
                    <td>{{datas.servico.name}}</td>
                    <td class="d-flex-row space-around">
                        <button class="button primary" @click="AbrirModalShow(datas)"><font-awesome-icon icon="building" /></button>
                        <button class="button primary" @click="AbrirModalShow(datas)"><font-awesome-icon icon="eye" /></button>
                    </td>
                </tr>
            </tbody>
      </TableList>
      <h1 class="text-center" v-else>Carregando ...</h1>
      </div>

  <Modal v-if="exibir">
    <div v-if="button_acao == 'create' || button_acao == 'update'">
        <h2>Criar um Novo Demanda</h2>
        <Input
            label="Nome da Demanda"
            type="text"
            placeholder="Digite o nome da Demanda"
            v-model="name"
        />
        <Input
            label="Digite o cep"
            type="number"
            placeholder="Digite o cep"
            v-model="cep_demanda"
        />
        <select v-model="servico_id">
            <option value="">Escolha um serviço</option>
            <option v-for="servicosopcao in servicos" :value="servicosopcao.id">
                {{ servicosopcao.name }} {{ servicosopcao.id }}
            </option>
        </select>
    </div>

    <div v-if="button_acao == 'visualizar'">
        <h2>Detalhe do Demanda: {{ name }}</h2>
        <ul class="p-l-15 list-none">
            <li class="mt-5"><b>Demanda:</b>{{ name }}</li>
            <li><b>Data e Hora de Criação:</b> {{ data_criacao }}</li>
            <li><b>Tipo do Serviço:</b> {{ servico.name }}</li>
            <li class="mb-5 mt-5">
                <fieldset>
                    <legend>CEP: {{ cep_demanda }}</legend>
                    <p><b>Logradouro: </b> {{ logradouro }}</p>
                    <p><b>Bairro: </b> {{ bairro }}</p>
                    <p><b>Localidade: </b> {{ localidade }}, {{ uf }}</p>
                </fieldset>
            </li>
        </ul>
    </div>
    <div class="d-flex-row space-around mt-5">
        <button v-if="button_acao == 'create'" class="button success m-l-10" @click="HandleCreate">Salvar</button>
        <button class="button danger" @click="exibir = false">Fecha</button>
    </div>
  </Modal>
  </template>



  <script>
      import TableList from "@/components/TableList.vue"
      import Modal from '@/components/Modal.vue'
      import Input from '@/components/Input.vue'
      import { HttpGet, HttpPost } from '@/composables/ServiceApi';
      import { useToast } from 'vue-toastification';


      const toast = useToast();

      export default {
          components: {
              TableList,
              Modal,
              Input
          },
          data() {
              return {
                  exibir:false,
                  load:false,
                  button_acao:'',
                  data:[{}],
                  servico:[],
                  servicos:[{}],
                  id:0,
                  name:"",
                  cep_demanda:"",
                  datacriacao:"",
                  servico_id:"",
                  logradouro:"",
                  bairro:"",
                  localidade:"",
                  uf:""
              }
          },
          methods: {
            limparCampos() {
                this.id = 0
                this.name = "";
                this.cep_demanda = "";
                this.servico = [],
                this.servico_id = ""
            },
            preencheCampos(data) {
                this.id = data.id
                this.name = data.name;
                this.cep_demanda = data.cep_demanda;
                this.data_criacao = data.data_criacao
                this.servico = data.servico
            },
            async ViaCep(cep){
                const response = await HttpGet(`viacep/${cep}`);
                this.logradouro = response.data.logradouro,
                this.bairro = response.data.bairro,
                this.localidade = response.data.localidade,
                this.uf = response.data.uf
            },
            async loadServico() {
                const response = await HttpGet("servico/index");
                this.servicos = response.data.data
            },
            validacampos() {
                if (this.name == "") {
                    toast.success('campo name não pode ser nulo');
                    return
                }
            },
            AbrirModalCreate() {
                this.limparCampos()
                this.loadServico()
                this.exibir = true
                this.button_acao = "create"
            },
            AbrirModalShow(data) {
                this.limparCampos()
                this.preencheCampos(data)
                this.ViaCep(data.cep_demanda)
                this.exibir = true
                this.button_acao = "visualizar"
            },
            async loaddemanda() {
                const response = await HttpGet("demanda/index");
                this.data = response.data.data
                this.load = true
            },
           async HandleCreate() {
                this.validacampos()
                const data = {
                    name: this.name,
                    cep_demanda: this.cep_demanda,
                    servico_id: this.servico_id
                }
                const response = await HttpPost("demanda/store",data);
                this.exibir = false
                toast.success('Demanda criado com sucesso!');
                this.loaddemanda();
                this.limparCampos()

            },
          },
        mounted() {
            this.loaddemanda();
        },
      }
  </script>
