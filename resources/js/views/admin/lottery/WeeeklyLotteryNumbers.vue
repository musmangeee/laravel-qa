<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">This Week Lottery Numbers</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Lottery</a></li>
        <li class="breadcrumb-item active">This Week Lottery Numbers</li>
      </ol>
      <!-- <div class="page-actions">
        <a href="#" class="btn btn-primary">
          <i class="icon-fa icon-fa-plus"/> New User
        </a>
        <button class="btn btn-danger">
          <i class="icon-fa icon-fa-trash"/> Delete
        </button>
      </div> -->
    </div>
    <div class="row">
      <div class="col-sm-8">
        <div class="card">
          <div class="card-header">
            <h6>All Users</h6>
            <div class="card-actions" />
          </div>
          <div class="card-body">
            <table-component
            ref="weeklylottery"
              :data="getWeeklyLotteryNumbers"
              sort-by="user_name"
              sort-order="desc"
              table-class="table"
            >
              <table-column show="lottery_number" label="Lottery Numbers"/>
              <table-column :sortable="false" :filterable="false" label="User Name">
                <template slot-scope="row">
                  <!-- <div>
                    <router-link
                      v-b-popover.hover="'View Profile'"
                      :to="{ name: 'viewprofile', params: { userId: row.id }}"
                      class="user-color"
                    > -->
                    {{ row.user.user_name }}
                    <!-- </router-link>
                  </div> -->
                </template>
              </table-column>
              <table-column
                show="created_at"
                label="Registered On"
                data-type="date:YYYY-MM-DD h:i:s"
              />
              <!-- <table-column
                :sortable="false"
                :filterable="false"
                label=""
              >
                <template slot-scope="row">
                  <div class="table__actions">
                    <router-link to="/admin/users/profile">
                      <a class="btn btn-default btn-sm">
                        <i class="icon-fa icon-fa-search"/> View
                      </a>
                    </router-link>
                    <a
                      class="btn btn-default btn-sm"
                      data-delete
                      data-confirmation="notie"
                      @click="deleteUser(row.id)"
                    >
                      <i class="icon-fa icon-fa-trash"/> Delete
                    </a>
                  </div>
                </template>
              </table-column> -->
            </table-component>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="card">
          <div class="card-header">
            <h6>Draw Lottery Winner</h6>
            <div class="card-actions" />
          </div>
          <div class="card-body">
            <!-- <pulse-loader :loading="loading" :color="color" :size="size"></pulse-loader> -->
            <!-- <ring-loader :loading="loading" :color="color1" :size="size"></ring-loader> -->
            <!-- <bounce-loader :loading="loading" :color="color" :size="size"></bounce-loader> -->
            <!-- <beat-loader :loading="loading" :color="color" :size="size"></beat-loader> -->
            <!-- <clip-loader :loading="loading" :color="color1" :size="size"></clip-loader> -->
            <!-- <dot-loader :loading="loading" :color="color" :size="size"></dot-loader> -->
            <!-- <fade-loader :loading="loading" :color="color" :size="size"></fade-loader> -->
            <grid-loader :loading="loading" :color="color1" :size="size"></grid-loader>
            <!-- <moon-loader :loading="loading" :color="color" :size="size"></moon-loader>
            <pacman-loader :loading="loading" :color="color" :size="size"></pacman-loader>
            <rise-loader :loading="loading" :color="color1" :size="size"></rise-loader>
            <rotate-loader :loading="loading" :color="color" :size="size"></rotate-loader>
            <scale-loader :loading="loading" :color="color" :size="size"></scale-loader>
            <skew-loader :loading="loading" :color="color1" :size="size"></skew-loader>
            <square-loader :loading="loading" :color="color" :size="size"></square-loader>
            <sync-loader :loading="loading" :color="color" :size="size"></sync-loader> -->
            <div v-if="loading == false">
              <h4 v-if="winner_number != ''">Jackpot winner number for this week is: {{winner_number}}</h4> 

            </div>

            <button
                @click.prevent="submit"
                class="btn btn-primary"
              >{{Draw}}</button>
            <button  v-if="winner_number != ''"
                @click.prevent="proceed"
                class="btn btn-success"
              >Accept & Proceed</button>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script type="text/babel">
import { TableComponent, TableColumn } from 'vue-table-component'
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
import RingLoader from 'vue-spinner/src/RingLoader.vue'
import BounceLoader from 'vue-spinner/src/BounceLoader.vue'
import BeatLoader from 'vue-spinner/src/BeatLoader.vue'
import ClipLoader from 'vue-spinner/src/ClipLoader.vue'
import DotLoader from 'vue-spinner/src/DotLoader.vue'
import FadeLoader from 'vue-spinner/src/FadeLoader.vue'
import GridLoader from 'vue-spinner/src/GridLoader.vue'
import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
import PacmanLoader from 'vue-spinner/src/PacmanLoader.vue'
import RiseLoader from 'vue-spinner/src/RiseLoader.vue'
import RotateLoader from 'vue-spinner/src/RotateLoader.vue'
import ScaleLoader from 'vue-spinner/src/ScaleLoader.vue'
import SkewLoader from 'vue-spinner/src/SkewLoader.vue'
import SquareLoader from 'vue-spinner/src/SquareLoader.vue'
import SyncLoader from 'vue-spinner/src/SyncLoader.vue'
export default {
  components: {
    TableComponent,
    TableColumn,
    PulseLoader,
    RingLoader,
    BounceLoader,
    BeatLoader,
    ClipLoader,
    DotLoader,
    FadeLoader,
    GridLoader,
    MoonLoader,
    PacmanLoader,
    RiseLoader,
    RotateLoader,
    ScaleLoader,
    SkewLoader,
    SquareLoader,
    SyncLoader
  },
  data () {
    return {
      users: [],
      color: '#5bc0de',
      color1: '#5bc0de',
      size: '45px',
      margin: '2px',
      radius: '2px',
      loading: false,
      winner_number: '',
      Draw: 'Draw'
    }
  },
  methods: {
    async getWeeklyLotteryNumbers ({ page, filter, sort }) {
      try {
        const response = await axios.get(`/api/admin/lottery/get?page=${page}&filter=${filter}&sortcol=${sort.fieldName}&sort=${sort.order}`)

        return {
          data: response.data.data,
          pagination: {
            totalPages: response.data.last_page,
            currentPage: page,
            count: response.data.count
          }
        }
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    deleteUser (id) {
      let self = this
      window.notie.confirm({
        text: 'Are you sure?',
        cancelCallback: function () {
          window.toastr['info']('Cancel')
        },
        submitCallback: function () {
          self.deleteUserData(id)
        }
      })
    },
    async deleteUserData (id) {
      try {
        let response = await window.axios.delete('/api/admin/users/' + id)
        this.users = response.data
        window.toastr['success']('User Deleted', 'Success')
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    async submit () {
      this.loading = true
        let response = await window.axios.get('/api/admin/lottery/getJackpotWinner')
      setTimeout(() => this.loading = false, 5000, this.winner_number = response.data.data, 10000);
        window.toastr['success']('JackPot Winner', 'Success')
        this.Draw = 'Re-Draw'
    },
    async proceed () {
      try {
        let response = await window.axios.post(`/api/admin/lottery/getLotteryWinners?jackpot=${this.winner_number}`)
        this.users = response.data
        window.toastr['success']('User Deleted', 'Success')
        this.$refs.weeklylottery.refresh()
        // var currentDateWithFormat = new Date().toJSON().slice(0,10);
        // console.log(currentDateWithFormat);
        this.$router.push('/latestLotteryWinners')

      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    }

  }
}
</script>
