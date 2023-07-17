<script>
import MessageValidationError from "@/Components/general/MessageValidationError.vue";
import VueDatePicker from '@vuepic/vue-datepicker';
import moment from "moment";

export default {
  name: 'EditExpense',
  components: {VueDatePicker, MessageValidationError},
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
      console.log(this.oneExpense)
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

        <div class="form-group mb-4">
          <VueDatePicker v-model="oneExpense.date" inline auto-apply/>
          <message-validation-error :messageError="arrMessageError" name="newRecord.name"/>
        </div>

        <div class="form-group mb-4" style="max-width: 100px;">
          <label for="sum">Сумма:</label>
          <input class="form-control" name="sum" id="sum" type="number" v-model="oneExpense.sum">
          <message-validation-error :messageError="arrMessageError" name="newRecord.sum"/>
        </div>

        <div class="form-group mb-4">
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