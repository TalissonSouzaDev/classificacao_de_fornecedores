<template>
    <div class="d-flex-column input">
        <label :for="label">{{ label }}</label>
        <input
            :type="type"
            :placeholder="placeholder"
            :value="modelValue"
             @input="$emit('update:modelValue', $event.target.value)"
            >
    </div>
</template>

<script>
 export default {
    name: "Input",
    props: {
    label: String,
    type: String,
    placeholder: String,
    modelValue: String
  }
 }
</script>
