<script>
import MessageValidationError from "@/Components/general/MessageValidationError.vue";
export default {
  name: 'AddExpense',
  components: {
    MessageValidationError,
  },
  props: [
    'arrMessageError'
  ],
  emits: [
    'addExpense',
    'cancelExpense'
  ],
  data() {
    return {
      expense: {
        date: null,
        sum: null,
        comment: "",
      },
    }
  },
  methods: {
    addExpense() {
      this.$emit("addExpense", this.expense)
    },
    cancelExpense() {
      this.$emit("cancelExpense")
    }
  }
}
</script>

<template>
  <div class="tab-pane fade" id="pills-add" role="tabpanel" aria-labelledby="pills-add-tab">
    <form>
      <div class="row">
        <div class="col-12 col-sm-12 col-md-12 pb-3">
          <h4>Добавление расхода:</h4>
        </div>

        <div class="form-group col-xl-3 col-sm-3 mb-4">
          <label for="date">Дата:</label>
          <input class="form-control" name="date" type="date" id="date" v-model="expense.date" required>
          <message-validation-error :messageError="arrMessageError" name="data.name"/>
        </div>

        <div class="form-group col-xl-3 col-sm-3 mb-4">
          <label for="sum">Сумма:</label>
          <input class="form-control" name="sum" id="sum" type="number" v-model="expense.sum">
          <message-validation-error :messageError="arrMessageError" name="data.sum"/>
        </div>

        <div class="form-group col-xl-6 col-sm-6 mb-4">
          <label for="comment">Комментарий:</label>
          <input class="form-control" name="comment" id="comment" type="text" v-model="expense.comment">
          <message-validation-error :messageError="arrMessageError" name="data.comment"/>
        </div>

        <div class="form-group mt-2">
          <a class="btn btn-primary flat mr-4" @click="addExpense">Создать</a>
          <a class="btn btn-default flat" @click="cancelExpense">Отменить</a>
        </div>
      </div>
    </form>
  </div>
</template>

<style scoped>

</style>