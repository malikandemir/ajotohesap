<template>
  <CRow>
    <CCol col="12" xl="8">
      <transition name="slide">
      <CCard>
        <CCardHeader>
            Gelirler
        </CCardHeader>

        <CButton color="primary" @click="addIncome()" class="mb-3 col-2 m-2">Gelir Ekle</CButton>
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
              <CButton color="primary" @click="showIncome( item.id )">Göster</CButton>
            </td>
          </template>
          <template #düzenle="{item}">
            <td>
              <CButton color="primary" @click="editIncome( item.id )">Düzenle</CButton>
            </td>
          </template>
          <template #sil="{item}">
            <td>
              <CButton v-if="you!=item.id" color="danger" @click="deleteIncome( item.id )">Sil</CButton>
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
  name: 'Incomes',
  data: () => {
    return {
      items: [],
      fields: ['id', 'ücreti_alan', 'ücret', 'açıklama', 'tarih', 'işi_yapan', 'göster', 'düzenle', 'sil'],
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
    incomeLink (id) {
      return `incomes/${id.toString()}`
    },
    editLink (id) {
      return `incomes/${id.toString()}/edit`
    },
    showIncome ( id ) {
      const incomeLink = this.incomeLink( id );
      this.$router.push({path: incomeLink});
    },
    editIncome ( id ) {
      const editLink = this.editLink( id );
      this.$router.push({path: editLink});
    },
    deleteIncome ( id ) {
      let self = this;
      let userId = id;
      axios.post(  '/api/incomes/' + id + '?token=' + localStorage.getItem("api_token"), {
        _method: 'DELETE'
      })
      .then(function (response) {
          self.message = 'İşlem Silindi.';
          self.showAlert();
          self.getIncomes();
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
    getIncomes (){
      let self = this;
      axios.get(  '/api/incomes?token=' + localStorage.getItem("api_token"),)
      .then(function (response) {
        self.items = response.data.incomes;
      }).catch(function (error) {
        console.log(error);
        self.$router.push({ path: '/login' });
      });
    },
      addIncome(){
          this.$router.push({path: '/incomes/create'});
      },
  },
  mounted: function(){
    this.getIncomes();
  },
}
</script>
