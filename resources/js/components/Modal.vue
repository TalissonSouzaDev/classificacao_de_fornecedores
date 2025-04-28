<template>
    <div class="modal-overlay">
      <div class="modal">
        <slot></slot>
      </div>
    </div>
  </template>

<script>
  export default {
    name: "Modal"
  }
</script>
