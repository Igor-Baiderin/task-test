<script>
import MessageValidationError from "@/Components/general/MessageValidationError.vue";
import moment from "moment";
export default {
  name: 'EditExpense',
  components: {MessageValidationError},
  props: [
    'arrMessageError',
    'oneExpense'
  ],
  emits: [
    'editetExpense',
    'cancelExpense'
  ],
  methods: {
    handOverExpense() {
      this.$emit("editetExpense", this.oneExpense)
    },
    cancelExpense() {
      this.$emit("cancelExpense")
    },
    getRusDate(base) {
      console.log(moment(base).locale('ru').format('DD.MM.YYYY'))
      return moment(base).locale('ru').format('DD.MM.YYYY');
    },

  }
}
</script>

<template>
  <div class="tab-pane fade" id="pills-edit" role="tabpanel" aria-labelledby="pills-edit-tab">
    <form v-if="oneExpense">
      <div class="row">
        <div class="col-12 col-sm-12 col-md-12 pb-3">
          <h4>Редактирование расхода:</h4>
        </div>

        <div class="form-group col-xl-3 col-sm-3 mb-4">
          <label for="date">Дата:</label>
          <input class="form-control" name="date" type="date" id="date" v-model="oneExpense.date" required>
          <input class="form-control" name="text" type="text" id="date" :value="this.getRusDate(oneExpense.date)" required>
          <message-validation-error :messageError="arrMessageError" name="newRecord.name"/>
        </div>

        <div class="form-group col-xl-3 col-sm-3 mb-4">
          <label for="sum">Сумма:</label>
          <input class="form-control" name="sum" id="sum" type="number" v-model="oneExpense.sum">
          <message-validation-error :messageError="arrMessageError" name="newRecord.sum"/>
        </div>

        <div class="form-group col-xl-6 col-sm-6 mb-4">
          <label for="comment">Комментарий:</label>
          <input class="form-control" name="comment" id="comment" type="text" v-model="oneExpense.comment">
          <message-validation-error :messageError="arrMessageError" name="newRecord.comment"/>
        </div>

        <div class="form-group mt-2">
          <a class="btn btn-primary flat mr-4" @click="handOverExpense">Изменить</a>
          <a class="btn btn-default flat" @click="cancelExpense">Отменить</a>
        </div>
      </div>
    </form>
  </div>
</template>

<style scoped>

</style>