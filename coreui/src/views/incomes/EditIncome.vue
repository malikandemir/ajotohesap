<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <CForm>
            <template slot="header">
              Edit User id:  {{ $route.params.id }}
            </template>
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
              <label for="who_take_the_money_gokhan" class="col-form-label col-sm-3"> Tahsilatı Kim Yaptı </label>
              <div class="col-sm-9">
                <div role="group" class="form-check">
                  <input id="who_take_the_moneygokhan" type="radio" v-model="who_take_the_money" name="who_take_the_money" class="form-check-input" value="10">
                  <label for="job_done_by_gokhan" class="form-check-label"> Gökhan </label>
                </div>
                <div role="group" class="form-check">
                  <input id="who_take_the_money_yusuf" type="radio" v-model="who_take_the_money" name="who_take_the_money" class="form-check-input" value="20">
                  <label for="who_take_the_money_yusuf" class="form-check-label"> Yusuf</label>
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

            <div role="group" class="form-group form-row">
              <label for="job_done_by_gokhan" class="col-form-label col-sm-3"> İşi Yapan </label>
              <div class="col-sm-9">
                <div role="group" class="form-check">
                  <input id="job_done_by_gokhan" type="radio" v-model="job_done_by" name="job_done_by" class="form-check-input" value="10">
                  <label for="job_done_by_gokhan" class="form-check-label"> Gökhan </label>
                </div>
                <div role="group" class="form-check">
                  <input id="job_done_by_yusuf" type="radio" v-model="job_done_by" name="job_done_by" class="form-check-input" value="20">
                  <label for="job_done_by_yusuf" class="form-check-label"> Yusuf</label>
                </div>
              </div>
            </div>

            <CButton color="primary" @click="update()">Save</CButton>
            <CButton color="primary" @click="goBack">Back</CButton>
          </CForm>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import axios from 'axios'
export default {
  name: 'EditIncome',
  props: {
    caption: {
      type: String,
      default: 'User id'
    },
  },
  data: () => {
    return {
        job_done_by: '',
        who_take_the_money: '',
        amount: '',
        date: '',
        description : '',
        showMessage: false,
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
    update() {
        let self = this;
        axios.post(  '/api/incomes/' + self.$route.params.id + '?token=' + localStorage.getItem("api_token"),
        {
            _method: 'PUT',
            job_done_by : self.job_done_by,
            who_take_the_money: self.who_take_the_money,
            amount: self.amount,
            date: self.date,
            description: self.description,
        })
        .then(function (response) {
            self.message = 'Başarıyla Güncellendi.';
            self.showAlert();
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
  },
  mounted: function(){
    let self = this;
    axios.get(  '/api/incomes/' + self.$route.params.id + '/edit?token=' + localStorage.getItem("api_token"))
    .then(function (response) {
        self.job_done_by = response.data.job_done_by;
        self.who_take_the_money = response.data.who_take_the_money;
        self.amount = response.data.amount;
        self.date = response.data.date;
        self.description = response.data.description;
    }).catch(function (error) {
        console.log(error);
        self.$router.push({ path: '/login' });
    });
  }
}


</script>
