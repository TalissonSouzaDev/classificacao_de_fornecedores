import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import './bootstrap';
import '../css/app.css';
import Toast, { POSITION } from 'vue-toastification';
import 'vue-toastification/dist/index.css';
import fontAwesome from './plugins/font-awesome';

createApp(App).use(router).use(fontAwesome).use(Toast, {
    position: POSITION.TOP_RIGHT,  // Posição do toast
    timeout: 5000,                 // Tempo do toast
    closeOnClick: true,            // Fechar ao clicar
    pauseOnHover: true,            // Pausar ao passar o mouse
    draggable: true,               // Habilitar arrastar
  }).mount('#app')
