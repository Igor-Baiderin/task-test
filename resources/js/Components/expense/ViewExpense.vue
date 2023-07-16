<script>
import moment from "moment";
import Paginate from "vuejs-paginate-next";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import {library} from '@fortawesome/fontawesome-svg-core'
import {fas} from '@fortawesome/free-solid-svg-icons'
import {fab} from '@fortawesome/free-brands-svg-icons'
library.add(fas, fab)

export default {
  name: 'ViewExpense',
  props: [
    'expenses',
  ],
  emits: [
    'editExpense',
    'deleteExpense'
  ],
  data() {
    return {
      page: 1,
      search: '',
      pagination_offset: 0,
      selectedPaginate: 10,
      optionPaginate: [
        {
          value: 10,
          out: '10'
        },
        {
          value: 25,
          out: '25'
        },
        {
          value: 50,
          out: '50'
        },
        {
          value: -1,
          out: 'Все'
        },
      ]
    }
  },
  methods: {
    getRusDate(base) {
      return moment(base).locale('ru').format('DD.MM.YYYY');
    },
    changePage(page_num) {
      this.page = page_num
      this.pagination_offset = this.selectedPaginate * (page_num - 1)
    },
    editExpense(index) {
      this.$emit("editExpense", this.expenses[index])
    },
    deleteExpense(deleteExpense, index) {
      // id объекта для удаления
      this.$emit('deleteExpense', deleteExpense)
      this.expenses.splice(index, 1)
    }
  },
  computed: {
    pagesCount() {
      return Math.ceil(this.searchHanlder.length / this.selectedPaginate)
    },
    listExpenses() {
      if (this.selectedPaginate < 0) {
        return this.searchHanlder
      } else {
        return this.searchHanlder.filter((expenses, index) => {
          return index >= this.pagination_offset && index < (this.pagination_offset + this.selectedPaginate)
        })
      }
    },
    searchHanlder() {
      return this.expenses.filter(elem => {
        return elem.comment.toLowerCase().includes(this.search.toLowerCase())
      });
    },
  },
  components: {FontAwesomeIcon, Paginate},
}
</script>

<template>
  <div class="tab-pane fade  show active" id="pills-view" role="tabpanel" aria-labelledby="pills-view-tab">
    <div class="row col-12 m-0 d-flex justify-content-between">
      <div class="form-group col-4 d-flex align-items-center pl-0">
        <span>Отображать</span>
        <select v-model="selectedPaginate" class="form-control m-2" style="width: 100px;">
          <option :value="item.value" v-for="item in optionPaginate" :key="item.id">{{ item.out }}</option>
        </select>
      </div>
      <div class="form-group col-6 col-md-4 col-sm-4 d-flex align-items-center pr-0 ">
        <span class="me-2"><FontAwesomeIcon icon="magnifying-glass"/></span>
        <input v-model="search" type="search" class="form-control input-sm" placeholder="Искать">
      </div>
    </div>
    <div class="row m-1">
      <div class="d-flex flex-row align-items-center">
        <div class="d-flex flex-column col-2">
          <h5>Дата</h5>
        </div>
        <div class="d-flex flex-column col-2">
          <h5>Сумма</h5>
        </div>
        <div class="d-flex flex-column col-6">
          <h5>Комментарий</h5>
        </div>
        <div class="d-flex justify-content-end col-2">
          <h5>Действие</h5>
        </div>
      </div>

      <div class="card p-0" v-for="(item, index) in listExpenses" :key="item.id">
        <div class="card-footer d-flex flex-row align-items-center">
          <div class="d-flex flex-column col-2">
            <p>{{ getRusDate(item.date) }}</p>
          </div>
          <div class="d-flex flex-column col-2">
            <p>{{ item.sum }}</p>
          </div>
          <div class="d-flex flex-column col-6">
            <p>{{ item.comment }}</p>
          </div>
          <div class="d-flex justify-content-end col-2">
            <a class="ms-2" @click="editExpense(index)" title="Редактировать">
              <FontAwesomeIcon icon="pen-to-square"/>
            </a>
            <a class="ms-2" @click="deleteExpense(item, index)" title="Удалить">
              <FontAwesomeIcon icon="trash"/>
            </a>
          </div>
        </div>
      </div>
      <div class="mt-3">
        <template v-if="this.selectedPaginate > 0 && pagesCount > 1">
          <paginate
            v-model="page"
            :page-range="3"
            :margin-pages="2"
            :page-count="pagesCount"
            :click-handler="changePage"
            :prev-text="'Пред.'"
            :next-text="'След'"
            :container-class="'pagination w-100 justify-content-center flex-wrap'"
          >
          </paginate>
        </template>
      </div>
    </div>
  </div>
</template>

<style scoped>
</style>