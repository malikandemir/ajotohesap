<template>
  <div>
    <CCardBody>
      <CRow>
        <CCol sm="3" class="m-1">
          <button square="" @click="addIncome()" type="button" class="btn btn-warning btn-lg btn-block">Gelir Ekle</button>
        </CCol>
        <CCol sm="3" class="m-1">
          <button square="" @click="addExpense()" type="button" class="btn btn-warning btn-lg btn-block">Gider Ekle</button>
        </CCol>
        <CCol sm="3" class="m-1">
          <button square="" @click="addPayment()" type="button" class="btn btn-warning btn-lg btn-block">Ödeme Ekle</button>
        </CCol>
        <CCol sm="3" class="m-1">
          <button square="" @click="incomes()" type="button" class="btn btn-info btn-lg btn-block">Gelirler</button>
        </CCol>
        <CCol sm="3" class="m-1">
          <button square="" @click="expenses()" type="button" class="btn btn-info btn-lg btn-block">Giderler</button>
        </CCol>
        <CCol sm="3" class="m-1">
          <button square="" @click="payments()" type="button" class="btn btn-info btn-lg btn-block">Ödemeler</button>
        </CCol>
      </CRow>
    </CCardBody>

    <div class="row">
      <div class="col-md-3">
        <div class="card card-accent-success">
          <header class="card-header"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" role="img" class="c-icon">
            <path d="M0.75 3h22.5v1.5h-22.5v-1.5z"></path><path d="M0.75 7.125h22.5v1.5h-22.5v-1.5z"></path>
            <path d="M0.75 11.25h22.5v1.5h-22.5v-1.5z"></path><path d="M0.75 15.375h22.5v1.5h-22.5v-1.5z">
          </path><path d="M4.5 19.5h15v1.5h-15v-1.5z"></path></svg> <strong> Hesap </strong></header>
          <div class="card-body">
            <table  class="table">
              <thead>
              <tr>
                <th  class="" style="vertical-align: middle; overflow: hidden;">Kişi</th>
                <th  class="" style="vertical-align: middle; overflow: hidden;">Alınan Para</th>
                <th  class="" style="vertical-align: middle; overflow: hidden;">Harcanan Para</th>
                <th  class="" style="vertical-align: middle; overflow: hidden;">Ödenen Para</th>
                <th  class="" style="vertical-align: middle; overflow: hidden;">Toplam</th>
            </tr></thead><tbody  class="position-relative">
            <tr>
              <td  class=""> Gökhan : </td>
              <td  class=""> {{gokhan_income  }} TL </td>
              <td  class=""> {{gokhan_expense  }} TL </td>
              <td  class=""> {{gokhan_payment }} TL </td>
              <td  class=""> {{gokhan_income - gokhan_expense + (yusuf_payment - gokhan_payment) }} TL </td>
            </tr>
            <tr>
              <td  class=""> Yusuf : </td>
              <td  class=""> {{yusuf_income  }} TL </td>
              <td  class=""> {{yusuf_expense  }} TL </td>
              <td  class=""> {{yusuf_payment }} TL </td>
              <td  class=""> {{yusuf_income - yusuf_expense  + (gokhan_payment - yusuf_payment)}} TL </td>
            </tr>
            <tr>
              <td  class="" colspan="4"> Gökhan Alacak: </td>
              <td  class=""> {{  ( (this.yusuf_income - yusuf_expense) - (this.gokhan_income - gokhan_expense)) /2  +  (gokhan_payment - yusuf_payment) }} TL  </td>
            </tr>
            <tr>
              <td  class="" colspan="4"> Yusuf Alacak:  </td>
              <td  class=""> {{ ((this.gokhan_income - gokhan_expense) - (this.yusuf_income - yusuf_expense))/2 + (yusuf_payment  - gokhan_payment)}} TL </td>
            </tr>
            </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card card-accent-success">
          <header class="card-header"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" role="img" class="c-icon">
            <path d="M0.75 3h22.5v1.5h-22.5v-1.5z"></path><path d="M0.75 7.125h22.5v1.5h-22.5v-1.5z"></path>
            <path d="M0.75 11.25h22.5v1.5h-22.5v-1.5z"></path><path d="M0.75 15.375h22.5v1.5h-22.5v-1.5z">
          </path><path d="M4.5 19.5h15v1.5h-15v-1.5z"></path></svg> <strong> Ödemeler </strong></header>
          <table  class="table">
            <thead>
            <tr>
              <th  class="" style="vertical-align: middle; overflow: hidden;">
                Açıklama</th><th  class="" style="vertical-align: middle; overflow: hidden;">Tutar</th>
            </tr></thead><tbody  class="position-relative">
          <tr>
            <td  class=""> Gökhan'ın Yusuf'a Ödediği : </td>
            <td  class=""> {{gokhan_payment}} TL </td>
          </tr>
          <tr>
            <td  class=""> Yusuf'un Gökhan'a Ödediği: </td>
            <td  class=""> {{yusuf_payment}} TL </td>
          </tr>
          </tbody>
          </table>
        </div>
      </div>
        <div class="col-md-3">
          <div class="card card-accent-success">
            <header class="card-header"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" role="img" class="c-icon">
              <path d="M0.75 3h22.5v1.5h-22.5v-1.5z"></path><path d="M0.75 7.125h22.5v1.5h-22.5v-1.5z"></path>
              <path d="M0.75 11.25h22.5v1.5h-22.5v-1.5z"></path><path d="M0.75 15.375h22.5v1.5h-22.5v-1.5z">
            </path><path d="M4.5 19.5h15v1.5h-15v-1.5z"></path></svg> <strong> Gelir </strong></header>
            <table  class="table">
              <thead>
              <tr>
                <th  class="" style="vertical-align: middle; overflow: hidden;">
                  Açıklama</th><th  class="" style="vertical-align: middle; overflow: hidden;">Tutar</th>
              </tr></thead><tbody  class="position-relative">
            <tr>
              <td  class=""> Günlük Gelir : </td>
              <td  class=""> {{daily_income}} TL </td>
            </tr>
            <tr>
              <td  class=""> Haftalık Gelir: </td>
              <td  class=""> {{weekly_income}} TL </td>
            </tr>
            <tr>
              <td  class=""> Aylık Gelir: </td>
              <td  class=""> {{monthly_income}} TL </td>
            </tr>
            <tr>
              <td  class=""> Yıllık Gelir: </td>
              <td  class=""> {{yearly_income}} TL </td>
            </tr>
            <tr>
              <td  class=""> Tüm Gelir: </td>
              <td  class=""> {{all_income}} TL </td>
            </tr>
            <tr>
              <td  class=""> Gökhan Aldığı Para: </td>
              <td  class=""> {{gokhan_income}} TL </td>
            </tr>
            <tr>
              <td  class=""> Yusuf Aldığı Para: </td>
              <td  class=""> {{yusuf_income}} TL </td>
            </tr>
            </tbody>
            </table>
            </div>
          </div>
        </div>
      <div class="col-md-3">
        <div class="card card-accent-danger">
          <header class="card-header"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" role="img" class="c-icon">
            <path d="M0.75 3h22.5v1.5h-22.5v-1.5z"></path><path d="M0.75 7.125h22.5v1.5h-22.5v-1.5z"></path>
            <path d="M0.75 11.25h22.5v1.5h-22.5v-1.5z"></path><path d="M0.75 15.375h22.5v1.5h-22.5v-1.5z">
          </path><path d="M4.5 19.5h15v1.5h-15v-1.5z"></path></svg> <strong> Gider </strong> </header>
          <table  class="table">
            <thead>
            <tr>
              <th  class="" style="vertical-align: middle; overflow: hidden;">
                Açıklama</th><th  class="" style="vertical-align: middle; overflow: hidden;">Tutar</th>
            </tr></thead><tbody  class="position-relative">
          <tr>
            <td  class=""> Günlük Gider : </td>
            <td  class=""> {{daily_expense}} TL </td>
          </tr>
          <tr>
            <td  class=""> Haftalık Gider: </td>
            <td  class=""> {{weekly_expense}} TL </td>
          </tr>
          <tr>
            <td  class=""> Aylık Gider: </td>
            <td  class=""> {{monthly_expense}} TL </td>
          </tr>
          <tr>
            <td  class=""> Yıllık Gider: </td>
            <td  class=""> {{yearly_expense}} TL </td>
          </tr>
          <tr>
            <td  class=""> Tüm Gider: </td>
            <td  class=""> {{all_expense}} TL </td>
          </tr>
          <tr>
            <td  class=""> Gökhan Ödediği Para: </td>
            <td  class=""> {{gokhan_expense}} TL </td>
          </tr>
          <tr>
            <td  class=""> Yusuf Ödediği Para: </td>
            <td  class=""> {{yusuf_expense}} TL </td>
          </tr>
          </tbody>
          </table>
        </div>
      </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Dashboard',
  components: {
  },
  data () {
    return {
      tableFields: [
        { key: 'avatar', label: '', _classes: 'text-center' },
        { key: 'user' },
        { key: 'country', _classes: 'text-center' },
        { key: 'usage' },
        { key: 'payment', label: 'Payment method', _classes: 'text-center' },
        { key: 'activity' },
      ],
      daily_expense:0,
      weekly_expense:0,
      monthly_expense:0,
      yearly_expense:0,
      all_expense:0,
      gokhan_expense:0,
      yusuf_expense:0,
        daily_income:0,
        weekly_income:0,
        monthly_income:0,
        yearly_income:0,
        all_income:0,
        gokhan_income:0,
        yusuf_income:0,
        gokhan_payment:0,
        yusuf_payment:0,
    }
  },
  methods: {

      addExpense(){
          this.$router.push({path: '/expenses/create'});
      },
      addIncome(){
          this.$router.push({path: '/incomes/create'});
      },
      addPayment(){
          this.$router.push({path: '/payments/create'});
      },
      expenses(){
          this.$router.push({path: '/expenses/'});
      },
      incomes(){
          this.$router.push({path: '/expenses/'});
      },
      payments(){
          this.$router.push({path: '/payments/'});
      },
      getExpenseReport(){
          let self = this;
          axios.get(  '/api/expenses/report?token=' + localStorage.getItem("api_token"))
              .then(function (response) {
                  self.daily_expense = response.data.daily_expense;
                  self.weekly_expense = response.data.weekly_expense;
                  self.monthly_expense = response.data.monthly_expense;
                  self.yearly_expense = response.data.yearly_expense;
                  self.all_expense = response.data.all_expense;
                  self.gokhan_expense = response.data.gokhan_expense;
                  self.yusuf_expense = response.data.yusuf_expense;
              }).catch(function (error) {
              console.log(error);
              self.$router.push({ path: '/login' });
          });
      },
      getIncomeReport(){
          let self = this;
          axios.get(  '/api/incomes/report?token=' + localStorage.getItem("api_token"))
              .then(function (response) {
                  self.daily_income = response.data.daily_income;
                  self.weekly_income = response.data.weekly_income;
                  self.monthly_income = response.data.monthly_income;
                  self.yearly_income = response.data.yearly_income;
                  self.all_income = response.data.all_income;
                  self.gokhan_income = response.data.gokhan_income;
                  self.yusuf_income = response.data.yusuf_income;
              }).catch(function (error) {
              console.log(error);
              self.$router.push({ path: '/login' });
          });
      },
      getPaymentReport(){
          let self = this;
          axios.get(  '/api/payments/report?token=' + localStorage.getItem("api_token"))
              .then(function (response) {
                  self.gokhan_payment = response.data.gokhan_payment;
                  self.yusuf_payment = response.data.yusuf_payment;
              }).catch(function (error) {
              console.log(error);
              self.$router.push({ path: '/login' });
          });
      },
  },
    mounted: function(){
        this.getExpenseReport();
        this.getIncomeReport();
        this.getPaymentReport();
    }
}
</script>
