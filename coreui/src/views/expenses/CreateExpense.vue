<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <h3>
            Gider Ekle
          </h3>
          <CAlert
            :show.sync="dismissCountDown"
            color="primary"
            fade
          >
            ({{dismissCountDown}}) {{ message }}
          </CAlert>

          <div role="group" class="form-group form-row">
            <label for="date" class="col-form-label col-sm-3"> Ücret </label>
            <div class="col-sm-9">
              <CInput type="text" placeholder="Ücret" v-model="amount"></CInput>
            </div>
          </div>

          <div role="group" class="form-group form-row">
            <label for="who_pay_the_money_gokhan" class="col-form-label col-sm-3"> Ödemeyi Yapan </label>
            <div class="col-sm-9">
              <div role="group" class="form-check">
                <input id="who_pay_the_money_gokhan" type="radio" v-model="who_pay_the_money" name="who_pay_the_money" class="form-check-input" value="10">
                <label for="who_pay_the_money_gokhan" class="form-check-label"> Gökhan </label>
              </div>
              <div role="group" class="form-check">
                <input id="who_pay_the_money_yusuf" type="radio" v-model="who_pay_the_money" name="who_pay_the_money" class="form-check-input" value="20">
                <label for="who_pay_the_money_yusuf" class="form-check-label"> Yusuf</label>
              </div>
            </div>
          </div>

          <div role="group" class="form-group form-row">
            <label for="date" class="col-form-label col-sm-3"> Tarih </label>
            <div class="col-sm-9">
              <input id="date" v-model="date" type="date" class="form-control">
            </div>
          </div>

          <div role="group" class="form-group form-row">
            <label for="date" class="col-form-label col-sm-3"> Açıklama </label>
            <div class="col-sm-9">
              <CInput type="text" placeholder="Açıklama" v-model="description"></CInput>
            </div>
          </div>

          <CButton color="primary" @click="store()">Ekle</CButton>
          <CButton color="primary" @click="goBack">Geri</CButton>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import axios from 'axios'
export default {
  name: 'CreateMenu',
  data: () => {
    return {
        who_pay_the_money: '',
        amount: '',
        date: '',
        description: '',
        message: '',
        dismissSecs: 7,
        dismissCountDown: 0,
        showDismissibleAlert: false
    }
  },
  methods: {
    goBack() {
      this.$router.go(-1)
      // this.$router.replace({path: '/users'})
    },
    store() {
        let self = this;
        axios.post(  '/api/expenses/store?token=' + localStorage.getItem("api_token"),
          {
              'who_pay_the_money': self.who_pay_the_money,
              'description': self.description,
              'amount': self.amount,
              'date': self.date
          }
        )
        .then(function (response) {
            self.who_pay_the_money= '';
            self.description= '';
            self.amount= '';
            self.date= '';
            self.message = 'Successfully created note.';
            self.showAlert();
        }).catch(function (error) {
            alert(error);
            if(error.response.data.message == 'The given data was invalid.'){
              self.message = '';
              for (let key in error.response.data.errors) {
                if (error.response.data.errors.hasOwnProperty(key)) {
                  self.message += error.response.data.errors[key][0] + '  ';
                }
              }
              self.showAlert();
            }else{
              console.log(error);
              self.$router.push({ path: 'login' }); 
            }
        });
    },
    countDownChanged (dismissCountDown) {
      this.dismissCountDown = dismissCountDown
    },
    showAlert () {
      this.dismissCountDown = this.dismissSecs
    },
  },
  mounted: function(){

  }
}

</script>
