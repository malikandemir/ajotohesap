<template>
  <CRow>
    <CCol col="12" xl="8">
      <transition name="slide">
      <CCard>
        <CCardHeader>
            Giderler
        </CCardHeader>

        <CButton color="primary" @click="addExpense()" class="mb-3 col-2 m-2">Gider Ekle</CButton>
        <CCardBody>
          <CAlert
            :show.sync="dismissCountDown"
            color="primary"
            fade
          >
            ({{dismissCountDown}}) {{ message }}
          </CAlert>
          <CDataTable
            hover
            striped
            :items="items"
            :fields="fields"
            :items-per-page="5"
            pagination
          >
          <template #status="{item}">
            <td>
              <CBadge :color="getBadge(item.status)">{{ item.status }}</CBadge>
            </td>
          </template>
          <template #göster="{item}">
            <td>
              <CButton color="primary" @click="showExpense( item.id )">Göster</CButton>
            </td>
          </template>
          <template #düzenle="{item}">
            <td>
              <CButton color="primary" @click="editExpense( item.id )">Düzenle</CButton>
            </td>
          </template>
          <template #sil="{item}">
            <td>
              <CButton v-if="you!=item.id" color="danger" @click="deleteExpense( item.id )">Sil</CButton>
            </td>
          </template>
        </CDataTable>
        </CCardBody>
      </CCard>
      </transition>
    </CCol>
  </CRow>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Expenses',
  data: () => {
    return {
      items: [],
      fields: ['id', 'ödemeyi_yapan', 'ücret', 'açıklama', 'tarih', 'göster', 'düzenle', 'sil'],
      currentPage: 1,
      perPage: 10,
      totalRows: 0,
      you: null,
      message: '',
      showMessage: false,
      dismissSecs: 7,
      dismissCountDown: 0,
      showDismissibleAlert: false
    }
  },
  paginationProps: {
    align: 'center',
    doubleArrows: false,
    previousButtonHtml: 'prev',
    nextButtonHtml: 'next'
  },
  methods: {
    getBadge (status) {
      return status === 'Active' ? 'success'
        : status === 'Inactive' ? 'secondary'
          : status === 'Pending' ? 'warning'
            : status === 'Banned' ? 'danger' : 'primary'
    },
    expenseLink (id) {
      return `expenses/${id.toString()}`
    },
    editLink (id) {
      return `expenses/${id.toString()}/edit`
    },
    showExpense ( id ) {
      const expenseLink = this.expenseLink( id );
      this.$router.push({path: expenseLink});
    },
    editExpense ( id ) {
      const editLink = this.editLink( id );
      this.$router.push({path: editLink});
    },
    deleteExpense ( id ) {
      let self = this;
      let userId = id;
      axios.post(  '/api/expenses/' + id + '?token=' + localStorage.getItem("api_token"), {
        _method: 'DELETE'
      })
      .then(function (response) {
          self.message = 'İşlem Silindi.';
          self.showAlert();
          self.getExpenses();
      }).catch(function (error) {
        console.log(error);
        self.$router.push({ path: '/login' });
      });
    },
    countDownChanged (dismissCountDown) {
      this.dismissCountDown = dismissCountDown
    },
    showAlert () {
      this.dismissCountDown = this.dismissSecs
    },
    getExpenses (){
      let self = this;
      axios.get(  '/api/expenses?token=' + localStorage.getItem("api_token"),)
      .then(function (response) {
        self.items = response.data.expenses;
      }).catch(function (error) {
        console.log(error);
        self.$router.push({ path: '/login' });
      });
    },
      addExpense(){
          this.$router.push({path: '/expenses/create'});
      },
  },
  mounted: function(){
    this.getExpenses();
  },
}
</script>
