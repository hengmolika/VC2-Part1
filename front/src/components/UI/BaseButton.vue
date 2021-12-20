<template>
    <button >
        <slot></slot>
    </button>
</template>
<script>
export default {
    
}
</script>

<style scoped>
button {
  padding: 0.5rem 1.5rem;
  font-family: inherit;
  color: white;
  cursor: pointer;
  border-radius: 0.3rem;
  outline: none;
}


.flat {
  background-color: transparent;
  color: var(--main-color);
  border: none;
}

.flat:hover,
.flat:active {
  background-color: #edd2ff;
}
</style>