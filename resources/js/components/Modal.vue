<template>
    <div class="modal-backdrop" @click.self="close">
      <div class="modal-content">
        <span class="close-btn" @click="close">&times;</span>
      </div>
    </div>
  </template>
  
  <script>
  const emit = defineEmits(['close'])
  
  function close() {
    emit('close')
  }
  export default {
    name: "Modal"
 }
  </script>
  
  <style scoped>
  .modal-backdrop {
    position: fixed;
    top: 0; left: 0;
    width: 100vw; height: 100vh;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  .modal-content {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    width: 400px;
    position: relative;
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
  }
  
  .close-btn {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 24px;
    cursor: pointer;
  }
  </style>