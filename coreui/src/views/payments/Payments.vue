<template>
  <CRow>
    <CCol col="12" xl="8">
      <transition name="slide">
      <CCard>
        <CCardHeader>
            Ödemeler
        </CCardHeader>

        <CButton color="primary" @click="addPayment()" class="mb-3 col-2 m-2">Ödeme Ekle</CButton>
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
              <CButton color="primary" @click="showPayment( item.id )">Göster</CButton>
            </td>
          </template>
          <template #düzenle="{item}">
            <td>
              <CButton color="primary" @click="editPayment( item.id )">Düzenle</CButton>
            </td>
          </template>
          <template #sil="{item}">
            <td>
              <CButton v-if="you!=item.id" color="danger" @click="deletePayment( item.id )">Sil</CButton>
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
  name: 'Payments',
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
    paymentLink (id) {
      return `payments/${id.toString()}`
    },
    editLink (id) {
      return `payments/${id.toString()}/edit`
    },
    showPayment ( id ) {
      const paymentLink = this.paymentLink( id );
      this.$router.push({path: paymentLink});
    },
    editPayment ( id ) {
      const editLink = this.editLink( id );
      this.$router.push({path: editLink});
    },
    deletePayment ( id ) {
      let self = this;
      let userId = id;
      axios.post(  '/api/payments/' + id + '?token=' + localStorage.getItem("api_token"), {
        _method: 'DELETE'
      })
      .then(function (response) {
          self.message = 'İşlem Silindi.';
          self.showAlert();
          self.getPayments();
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
    getPayments (){
      let self = this;
      axios.get(  '/api/payments?token=' + localStorage.getItem("api_token"),)
      .then(function (response) {
        self.items = response.data.payments;
      }).catch(function (error) {
        console.log(error);
        self.$router.push({ path: '/login' });
      });
    },
      addPayment(){
          this.$router.push({path: '/payments/create'});
      },
  },
  mounted: function(){
    this.getPayments();
  },
}
</script>
