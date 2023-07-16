<script>
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";

export default {
  name: 'MainComponent',
  components: {FontAwesomeIcon},
};
</script>

<template>
  <div class="container-fluid">
    <h2>Тестовое задание</h2>
    <button type="button" class="btn btn-success me-2">Success</button>
    <button type="button" class="btn btn-info me-2">Info</button>
    <button type="button" class="btn btn-warning me-2">Warning</button>
    <FontAwesomeIcon :icon="['fas', 'coffee']" />
    <FontAwesomeIcon :icon="['fab', 'youtube']"/>
    <FontAwesomeIcon icon="user"/>
    <FontAwesomeIcon icon="phone"/>
    <FontAwesomeIcon icon="pen-to-square"/>
    <button type="button"><FontAwesomeIcon icon="trash" class="me-1" style="color: red"/></button>
    <FontAwesomeIcon icon="plus"/>
    <FontAwesomeIcon icon="fa-solid fa-coffee" size='5x' />
  </div>
</template>

<style scoped>

</style>