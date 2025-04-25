import { createRouter, createWebHistory } from 'vue-router'
import TarefasList from '../views/TarefasList.vue'
import FornecedorHome from '../views/Fornecedor/Home.vue'

const routes = [
  { path: '/', redirect: '/tarefas' },
  { path: '/tarefas', component: TarefasList },
  { path: '/fornecedor', component: FornecedorHome },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router