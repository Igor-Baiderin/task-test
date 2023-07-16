<template>
  <div class="text-danger" role="alert" v-if="messageError">
    <div v-for="item in messageError[name]">
      <small>{{item}}</small>
    </div>
  </div>
</template>

<script>
export default {
  name: "MessageValidationError",
  props:[
    'messageError',
    'name'
  ]
}
</script>

<style scoped>

</style>