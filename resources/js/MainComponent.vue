<script>
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import ViewExpense from "@/Components/expense/ViewExpense.vue";
import AddExpense from "@/Components/expense/AddExpense.vue";
import EditExpense from "@/Components/expense/EditExpense.vue";
import {ref, reactive, onBeforeUpdate} from 'vue'

export default {
  name: 'MainComponent',
  created() {
    this.getExpenses();
  },
  data() {
    return {
      expenses: [],
      EditForm: [],
      nameTab: 'Расходы',
      oneExpense: null,
      arrMessageError: null
    }
  },
  components: {
    FontAwesomeIcon,
    AddExpense,
    EditExpense,
    ViewExpense,
  },
  methods: {
    cancelExpense() {
      this.getExpenses()
      this.oneExpense = null
      // здесь тоже по ссылкам махнется поэтому грузим по новой из БД
      this.arrMessageError = null;
      this.$refs.viewTab.click()
    },
    deleteExpense(id) {
      this.delete(id)
    },
    copyToEditExpense(Expense) {
      this.oneExpense = Expense;
      console.log(this.oneExpense)
      this.$refs.editTab.click()
    },
    getExpenses() {
      axios.get('/api/expense')
        .then((response) => (this.expenses = response.data.expenses))
    },
    create(newRecord) {
      axios.post('/api/expense',
        {
          newRecord: newRecord,
          headers: {
            'Content-Type': 'multipart/form-data',
          }
        }
      ).then(response => (
        this.getExpenses(),
          this.$refs.viewTab.click(),
          this.arrMessageError = null
      )).catch((error) => (
        this.arrMessageError = error.response.data.errors
      ));
    },
    update(editExpense) {
      axios.patch('/api/expense/' + editExpense.id,
        {
          editExpense: editExpense,
          headers: {
            'Content-Type': 'multipart/form-data',
            'method': 'patch'
          }
        }
      ).then(response => (
        this.getExpenses(),
          this.$refs.viewTab.click(),
          this.oneExpense = null,
          this.arrMessageError = null
      ))
        .catch(error => (
          this.arrMessageError = error.response.data.errors
        ));
    },
    delete(Expense) {
      axios.delete('/api/expense/' + Expense.id,
        {
          headers: {
            'Content-Type': 'multipart/form-data',
            'method': 'destroy'
          }
        }
      ).then(function (response) {
        console.log('SUCCESS!!');
      }).catch(function (error) {
        console.log(error);
      });
    }
  }
};
</script>

<template>
  <div class="container">
    <h2>Тестовое задание</h2>
    <!--    <FontAwesomeIcon :icon="['fas', 'coffee']" />-->
    <!--    <FontAwesomeIcon :icon="['fab', 'youtube']"/>-->
    <div class="col-12 col-sm-12 col-md-12">
      <div class="row">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" ref="viewTab" id="pills-view-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-view"
                    type="button" role="tab" aria-controls="pills-view" aria-selected="true">Расходы
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-add-tab" data-bs-toggle="pill" data-bs-target="#pills-add"
                    type="button" role="tab" aria-controls="pills-add" aria-selected="false">Новая запись
            </button>
          </li>
          <li class="nav-item" role="presentation" v-show="oneExpense">
            <button class="nav-link" id="pills-edit-tab" ref="editTab" data-bs-toggle="pill"
                    data-bs-target="#pills-edit"
                    type="button" role="tab" aria-controls="pills-edit" aria-selected="false">Редактирование
            </button>
          </li>
        </ul>
        <div class="tab-content p-0" id="pills-tabContent">
          <view-expense
            :expenses='expenses'
            @editExpense="copyToEditExpense"
            @deleteExpense="deleteExpense"
          />
          <add-expense
            :arrMessageError='arrMessageError'
            @addExpense='create'
            @cancelExpense='cancelExpense'
          />
          <edit-expense
            v-show="oneExpense"
            :oneExpense="oneExpense"
            :arrMessageError='arrMessageError'
            @editetExpense='update'
            @cancelExpense='cancelExpense'
          />
        </div>
      </div>
    </div>


  </div>
</template>

<style scoped>

</style>