<template>

    <div>
      <div class="card-header-element">
          <h1>Serviços</h1>
          <button class="button success" @click="AbrirModalCreate"><font-awesome-icon icon="plus" /></button>
      </div>
      <TableList v-if="load">
        <thead>
                <tr>
                    <th>SERVIÇO</th>
                    <th>DESCRIÇÃO</th>
                    <th>AÇÕES</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="datas in data">
                    <td>{{datas.name}}</td>
                    <td>{{datas.description}}</td>
                    <td class="d-flex-row space-around">
                        <button class="button primary" @click="AbrirModalShow(datas)"><font-awesome-icon icon="eye" /></button>
                        <button class="button warning" @click="AbrirModalupdate(datas)"><font-awesome-icon icon="pen" /></button>
                        <button class="button danger" @click="HandleDelete(datas.id)"><font-awesome-icon icon="trash-alt" /></button>
                    </td>
                </tr>
            </tbody>
      </TableList>
      <h1 class="text-center" v-else>Carregando ...</h1>
      </div>

  <Modal v-if="exibir">
    <div v-if="button_acao == 'create' || button_acao == 'update'">
        <h2>Criar um Novo Serviço</h2>
        <Input
            label="Nome do Serviço"
            type="text"
            placeholder="Digite o nome do serviço"
            v-model="name"
        />
        <Input
            label="Descrição"
            type="text"
            placeholder="Digite a descrição"
            v-model="description"
        />
    </div>

    <div v-if="button_acao == 'visualizar'">
        <h2>Detalhe do serviço: {{ name }}</h2>
        <ul class="p-l-15">
            <li class="mb-5 mt-5">{{ name }}</li>
            <li>{{ description }}</li>
        </ul>
    </div>
    <div class="d-flex-row space-around mt-5">
        <button v-if="button_acao == 'create'" class="button success m-l-10" @click="HandleCreate">Salvar</button>
        <button v-if="button_acao == 'update'" class="button warning m-l-10" @click="HandleUpdate">edita</button>
        <button class="button danger" @click="exibir = false"><font-awesome-icon icon="coffee" />Fecha</button>
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
                  button_acao:'',
                  data:[{}],
                  id:0,
                  name:"",
                  description:"",
              }
          },
          methods: {
            limparCampos() {
                this.id = 0
                this.name = "";
                this.description = "";
            },
            preencheCampos(data) {
                this.id = data.id
                this.name = data.name;
                this.description = data.description;
            },
            validacampos() {
                if (this.name == "") {
                    toast.success('campo name não pode ser nulo');
                    return
                }
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
                this.exibir = true
                this.button_acao = "visualizar"
            },
            async loadServico() {
                const response = await HttpGet("servico/index");
                this.data = response.data.data
                this.load = true
            },
           async HandleCreate() {
                this.validacampos()
                const data = {
                    name: this.name,
                    description: this.description
                }
                const response = await HttpPost("servico/store",data);
                this.exibir = false
                toast.success('Serviço criado com sucesso!');
                this.loadServico();
                this.limparCampos()

            },
            async HandleUpdate() {
                const data = {
                    name: this.name,
                    description: this.description
                }
                const response = await HttpPut(`servico/update/${this.id}`,data);
                this.exibir = false
                toast.success('Serviço Atualizado com sucesso!');
                this.loadServico();
                this.limparCampos()
            },
            async HandleDelete(id) {
                const response = await HttpDelete(`servico/destroy/${id}`);
                toast.success('Serviço excluído com sucesso!');
                this.loadServico();

            }
          },
        mounted() {
            this.loadServico();
        },
      }
  </script>
