<template>
  <div class="main-content page-profile">
    <div class="page-header">
      <h3 class="page-title">User Profile</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Home</a>
        </li>
        <li class="breadcrumb-item">
          <a href="#">Users</a>
        </li>
        <li class="breadcrumb-item active">{{username}}</li>
      </ol>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <tabs class="tabs-default">
              <tab id="profile" name="Profile">
                <div class="row">
                  <div class="col-sm-3">
                    <div class="avatar-container">
                      <img
                        src="/assets/img/user-icon-placeholder.png"
                        alt="Admin Avatar"
                        class="img-fluid"
                      />
                    </div>
                  </div>
                  <div class="col-sm-9">
                    <h4>{{username}}</h4>
                    <p class="detail-row">
                      <i class="icon-fa icon-fa-envelope" />
                      {{email}}
                    </p>
                    <p class="detail-row">
                      <i class="icon-fa icon-fa-money" />
                      {{userWallet.available_balance}}
                    </p>
                    <p class="detail-row">
                      <i class="icon-fa icon-fa-calendar" />
                      {{created_at}}
                    </p>
                  </div>
                </div>
              </tab>
              <tab id="profile-messages" name="Lottery Numbers">
                <ul class="media-list activity-list">
                  <div class="row col-12 header">
                    <div class="col-6"><h3>Lottery Number</h3></div>
                    <div class="col-6"><h3>Winning Date</h3></div>
                  </div>
                  <li class="row col-12 media" v-for="lottery in lotteryNumbers" :key="lottery.id">
                    <div class="col-6">{{ lottery.lottery_number }}</div>
                    <div class="col-6">{{ lottery.created_at }}</div>
                  </li>
                </ul>
              </tab>
              <tab id="winning-numbers" name="Winning Numbers">
                <ul class="media-list activity-list">
                  <div class="row col-12 header">
                    <div class="col-4">
                      <h3>Lottery Number</h3>
                    </div>
                    <div class="col-4">
                      <h3>Winning Amount</h3>
                    </div>
                    <div class="col-4">
                      <h3>Winning Date</h3>
                    </div>
                  </div>
                  <li class="row col-12 media" v-for="win in winningNumbers" :key="win.id">
                    <div class="col-4">{{ win.lottery_number.lottery_number }}</div>
                    <div class="col-4">{{ win.total_amount }}</div>
                    <div class="col-4">{{ win.created_at }}</div>
                  </li>
                  <div class="row col-12">
                    <div class="col-4">
                      <b>Winning Amount</b>
                    </div>
                    <div class="col-4">
                      <b>{{ winningAmount }}</b>
                    </div>
                    <div class="col-4"></div>
                  </div>
                </ul>
              </tab>
            </tabs>
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
      email: "",
      username: "",
      lotteryNumbers: [],
      userWallet: [],
      winningNumbers: [],
      created_at: "",
      winningAmount: ""
    };
  },

  mounted() {
    this.getUserData();
  },
  methods: {
    async submit() {
      try {
        // let response = await window.axios.post(
        //   "/api/admin/contact-us/reply",
        //   { data: this.form }
        // );
        alert("Email service is not active yet");
        window.toastr["success"]("Replied Successful", "Success");
        this.$router.push("/contact-us");
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
      let userId = this.$route.params.userId;
      try {
        const response = await axios.get(`/api/admin/users/edit/${userId}`);
        this.email = response.data.email;
        this.created_at = response.data.created_at;
        this.lotteryNumbers = response.data.lottery_numbers;
        this.username = response.data.user_name;
        this.userWallet = response.data.user_wallet;
        this.winningNumbers = response.data.winning_numbers;
        this.winningAmount = response.data.winning_amount;
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    async cancel() {
      this.$router.push("/contact-us");
    }
  }
};
</script>
