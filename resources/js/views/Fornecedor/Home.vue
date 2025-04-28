<template>

    <div>
      <div class="card-header-element">
          <h1>Fornecedor</h1>
          <button class="button success" @click="AbrirModalCreate"><font-awesome-icon icon="plus" /></button>
      </div>
      <TableList v-if="load">
        <thead>
                <tr>
                    <th>RAZÃO SOCIAL</th>
                    <th>CNPJ</th>
                    <th>TELEFONE</th>
                    <th>AÇÕES</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="datas in data">
                    <td>{{datas.razao_social}}</td>
                    <td>{{datas.cnpj}}</td>
                    <td>{{datas.telefone}}</td>
                    <td class="d-flex-row space-around">
                        <button class="button primary" @click="AbrirModalFornecedorServico(datas)"><font-awesome-icon icon="key" /></button>
                        <button class="button primary" @click="AbrirModalShow(datas)"><font-awesome-icon icon="eye" /></button>
                        <button class="button warning" @click="AbrirModalupdate(datas)"><font-awesome-icon icon="pen" /></button>
                        <button class="button danger" @click="HandleDelete(datas.id)"><font-awesome-icon icon="trash-alt" /></button>
                    </td>
                </tr>
            </tbody>
      </TableList>
      <h1 class="text-center" v-else>{{mensagem}}</h1>
      </div>

  <Modal v-if="exibir">
    <div v-if="button_acao == 'create' || button_acao == 'update'">
        <h2 class="mb-15" v-if="button_acao == 'create'">Criar um Novo Fornecedor</h2>
        <h2 class="mb-15" v-if="button_acao == 'update'">Atualizar o Fornecedor {{ this.razao_social }}</h2>
        <Input
            label="Razão Social"
            type="text"
            placeholder="Digite a Razão Social"
            v-model="razao_social"
        />
        <Input
            label="CNPJ"
            type="text"
            placeholder="Digite o CNPJ"
            v-model="cnpj"
        />
        <Input
            label="E-mail"
            type="email"
            placeholder="Digite o E-mail"
            v-model="email"
        />
        <Input
            label="Telefone"
            type="tel"
            placeholder="Digite o Telefone"
            v-model="telefone"
        />
        <Input
            label="CEP"
            type="number"
            placeholder="Digite o CEP apenas numero 00000000"
            v-model="cep_sede"
        />
    </div>

    <div v-if="button_acao == 'visualizar'">
        <h2>Detalhe do Fornecedor: {{ razao_social }}</h2>
        <ul class="p-l-15 list-none">
            <li class="mt-5"><b>Razão Social: </b>{{ razao_social }}</li>
            <li><b>CPNJ: </b>{{ cnpj }}</li>
            <li><b>E-mail: </b>{{ email }}</li>
            <li><b>Telefone: </b>{{ telefone }}</li>
            <li class="mb-5 mt-5">
                <fieldset>
                    <legend>CEP: {{ cep_sede }}</legend>
                    <p><b>Logradouro: </b> {{ logradouro }}</p>
                    <p><b>Bairro: </b> {{ bairro }}</p>
                    <p><b>Localidade: </b> {{ localidade }}, {{ uf }}</p>
                </fieldset>
            </li>
        </ul>
    </div>

    <div v-if="button_acao == 'fornecedorservico'">
        <h2>Vincular o Fornecedor: {{ razao_social }}</h2>
        <div class="overflow-list mt-5">
            <div v-for="servico in dataservico">
                <input type="checkbox" v-model="checkbox" :value="servico.id"> {{ servico.name }}
            </div>
        </div>
        <div>
        <h2 class="fornecedor-vinculos">Serviços Vinculados</h2>
        <div class="overflow-list">
            <ol class="ol-fornecedor" v-for="fornecedorservicos in fornecedorservico">
                <li>
                    {{ fornecedorservicos.name }}
                    <a href="#" @click="HandleDetach(fornecedorservicos.id)">Desvincular</a>
                </li>
            </ol>
        </div>
        
    </div>
    </div>
    <div class="d-flex-row space-around mt-5">
        <button v-if="button_acao == 'create'" class="button success" @click="HandleCreate">Salvar</button>
        <button v-if="button_acao == 'update'" class="button warning m-l-10" @click="HandleUpdate">edita</button>
        <button v-if="button_acao == 'fornecedorservico'" class="button success m-l-10" @click="HandleAttach">Salvar</button>
        <button class="button danger" @click="exibir = false">Fecha</button>
    </div>
  </Modal>
  </template>



  <script>
      import TableList from "@/components/TableList.vue"
      import Modal from '@/components/Modal.vue'
      import Input from '@/components/Input.vue'
      import { HttpGet, HttpPost, HttpDelete, HttpPut } from '@/composables/ServiceApi';
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
                  mensagem:"Carregando ...",
                  button_acao:'',
                  data:[{}],
                  dataservico:[{}],
                  checkbox:[],
                  fornecedorservico:[{}],
                  id:0,
                  razao_social:"",
                  cnpj:"",
                  email:"",
                  telefone:"",
                  cep_sede:"",
                  logradouro:"",
                  bairro:"",
                  localidade:"",
                  uf:""
              }
          },
          methods: {
            limparCampos() {
                this.id = 0
                this.razao_social = "";
                this.cnpj = "";
                this.email = "";
                this.telefone = "";
                this.cep_sede = "";
            },
            preencheCampos(data) {
                this.id = data.id
                this.razao_social = data.razao_social;
                this.cnpj = data.cnpj;
                this.email = data.email;
                this.telefone = data.telefone;
                this.cep_sede = data.cep_sede;
            },
            validacampos() {
                if (this.razao_social == "") {
                    toast.success('campo Razão Social não pode ser nulo');
                    return
                }
            },
            async ViaCep(cep){
                const response = await HttpGet(`viacep/${cep}`);
                this.logradouro = response.data.logradouro,
                this.bairro = response.data.bairro,
                this.localidade = response.data.localidade,
                this.uf = response.data.uf
            },
            async Servico(){
                const response = await HttpGet("servico/index");
                this.dataservico = response.data.data
            },
            async Getfornecedorservicos(id) {
                const response = await HttpGet(`fornecedor/${id}/servicos`)
                this.fornecedorservico = response.data.data
            },
            AbrirModalCreate() {
                this.limparCampos()
                this.exibir = true
                this.button_acao = "create"
            },
            AbrirModalupdate(data) {
                this.limparCampos()
                this.preencheCampos(data)
                this.exibir = true
                this.button_acao = "update"
            },
            AbrirModalShow(data) {
                this.limparCampos()
                this.preencheCampos(data)
                this.ViaCep(data.cep_sede)
                this.exibir = true
                this.button_acao = "visualizar"
            },
            AbrirModalFornecedorServico(data) {
                this.preencheCampos(data)
                this.Servico()
                this.Getfornecedorservicos(data.id)
                this.exibir = true
                this.button_acao = "fornecedorservico"
            },
            async loadfornecedor() {
                const response = await HttpGet("fornecedor/index");
                this.data = response.data.data
                if(this.data.length <= 0) {
                    this.mensagem = "Não Ha dados"
                    return
                }
                this.load = true
            },
           async HandleCreate() {
                this.validacampos()
                const data = {
                    razao_social: this.razao_social,
                    cnpj: this.cnpj,
                    email: this.email,
                    telefone: this.telefone,
                    cep_sede: this.cep_sede,
                }
                const response = await HttpPost("fornecedor/store",data);
                this.exibir = false
                toast.success('Fornecedor criado com sucesso!');
                this.loadfornecedor();
                this.limparCampos()

            },
            async HandleUpdate() {
                const data = {
                    razao_social: this.razao_social,
                    cnpj: this.cnpj,
                    email: this.email,
                    telefone: this.telefone,
                    cep_sede: this.cep_sede,
                }
                const response = await HttpPut(`fornecedor/update/${this.id}`,data);
                this.exibir = false
                toast.success('Fornecedor Atualizado com sucesso!');
                this.loadfornecedor();
                this.limparCampos()
            },
            async HandleDelete(id) {
                const response = await HttpDelete(`fornecedor/destroy/${id}`);
                toast.success('Fornecedor excluído com sucesso!');
                this.loadfornecedor();

            },
           async HandleAttach() {
                const data = {
                    servicos_id: this.checkbox,
                }
                const response = await HttpPost(`fornecedor/attach/${this.id}`,data);
                this.exibir = false
                toast.success('Vinculo realizado com sucesso!');
                this.loadfornecedor();
                this.limparCampos()
           },
           async HandleDetach(idservico) {
                const response = await HttpDelete(`fornecedor/${this.id}/detach/${idservico}`);
                this.exibir = false
                toast.success('Desvinculação realizado com sucesso!');
                this.loadfornecedor();
                this.limparCampos()
           }
          },
        mounted() {
            this.loadfornecedor();
        },
      }
  </script>
