// src/plugins/font-awesome.js
import { library } from '@fortawesome/fontawesome-svg-core';
import { faHome,faKey,faPlus, faTrashAlt, faPen, faEye,faBuilding  } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

// Adicione os ícones que você quer usar ao library
library.add(faHome,faPlus, faTrashAlt, faPen, faEye,faKey,faBuilding );

// Registre o componente FontAwesomeIcon globalmente
export default {
  install: (app) => {
    app.component('font-awesome-icon', FontAwesomeIcon);
  },
};
