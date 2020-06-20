<template>
  <div class="main-content page-profile">
    <div class="page-header">
      <h3 class="page-title">User Wallet</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Home</a>
        </li>
        <li class="breadcrumb-item">
          <a href="/withdraw-requests">Withdraw Requests</a>
        </li>
        <li class="breadcrumb-item active">{{form.username}}</li>
      </ol>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <div class="card-header">
              <b>{{form.username}}</b>
            </div>
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-10">
                  <label for="inputUserName">Total Balance:</label>
                  <input
                    :disabled= "true"
                    id="inputUserName"
                    class="form-control"
                    placeholder="Total Balance"
                    v-model.trim="form.userWallet.total_balance"
                  />
                </div>
                  
              </div>
              <div class="form-row">
                <div class="form-group col-md-10">
                  <label for="inputUserName">Withdraw Amount:</label>
                  <input
                    id="inputUserName"
                    class="form-control"
                    placeholder="Total Balance"
                    v-model.trim="form.withdraw_amount"
                  />
                </div>
                  
              </div>

              <button 
              @click.prevent="proceed"
              :disabled="form.withdraw_amount > form.userWallet.total_balance ? true : false"
              class="btn btn-primary"
              >Proceed</button>
              <b-button type="button" @click.prevent="cancel">Cancel</b-button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { Tabs, Tab } from "vue-tabs-component";

export default {
  components: {
    tabs: Tabs,
    tab: Tab
  },
  data() {
    return {
      form:{
        username: "",
        userWallet: [],
        withdraw_amount: '',
        requestId: ''
      }
    };
  },

  mounted() {
    this.getUserData();
  },
  methods: {
    async proceed() {
      try {
        let response = await window.axios.post(
          "/api/admin/withdraw-requests/proceed",
          { data: this.form }
        );
        window.toastr["success"]("Replied Successful", "Success");
        this.$router.push("/withdraw-requests");
      } catch (error) {
        if (error) {
          window.toastr["error"](
            response.data.ResponseHeader.ResponseMessage,
            "Error"
          );
        }
      }
    },
    async getUserData() {
      let withdrawId = this.$route.params.withdrawId;
      try {
        const response = await axios.get(`/api/admin/withdraw-requests/edit/${withdrawId}`);
        this.form.username = response.data.user.user_name;
        this.form.userWallet = response.data.user_wallet;
        this.form.withdraw_amount = response.data.amount;
        this.form.requestId = this.$route.params.withdrawId;
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    async cancel() {
      this.$router.push("/withdraw-requests");
    }
  }
};
</script>
