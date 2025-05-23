import { createRouter, createWebHistory } from 'vue-router'
import FornecedorHome from '../views/Fornecedor/Home.vue'
import DemandaHome from '../views/Demanda/Home.vue'
import ServicoHome from '../views/Servico/Home.vue'
import ClassificacaoHome from '../views/Classificacao/Home.vue'

const routes = [
  { path: '/', redirect: '/demanda' },
  { path: '/fornecedor', component: FornecedorHome },
  { path: '/demanda', component: DemandaHome },
  { path: '/servico', component: ServicoHome },
  { path: '/classificacao/:iddemanda', component: ClassificacaoHome },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
