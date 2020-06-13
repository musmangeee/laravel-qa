<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Lottery Winners</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Lottery</a></li>
        <li class="breadcrumb-item active">Latest Lottery Winners</li>
      </ol>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h6>All Users</h6>
            <div class="card-actions" />
          </div>
          <div class="card-body">
            <table-component
            ref="weeklylottery"
              :data="getLotteryWinners"
              sort-by="user_name"
              sort-order="desc"
              table-class="table"
            >
              <table-column :sortable="false" :filterable="false" label="Lottery Numbers">
                <template slot-scope="row">
                  <!-- <div>
                    <router-link
                      v-b-popover.hover="'View Profile'"
                      :to="{ name: 'viewprofile', params: { userId: row.id }}"
                      class="user-color"
                    > -->
                    {{ row.lottery_number.lottery_number }}
                    <!-- </router-link>
                  </div> -->
                </template>
              </table-column>
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
              <table-column :sortable="false" :filterable="false" label="Winner Status">
                <template slot-scope="row">
                  <span v-if="row.is_winner_status == 1" class="badge badge-success">
                    Jackpot Winner
                  </span>
                  <span v-else-if="row.is_winner_status == 2" class="badge badge-info">
                    Five Numbers Winner
                  </span>
                  <span v-else-if="row.is_winner_status == 3" class="badge badge-dark">
                    Four Numbers Winner
                  </span>
                  <span v-else-if="row.is_winner_status == 4" class="badge badge-light">
                    Three Numbers Winner
                  </span>                   
                </template>
              </table-column>
              <table-column show="total_amount" label="Winning Amount"/>
              <table-column
                show="created_at"
                label="Date"
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
    </div>
  </div>
</template>

<script type="text/babel">
import { TableComponent, TableColumn } from 'vue-table-component'
export default {
  components: {
    TableComponent,
    TableColumn
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
      Draw: 'Draw',
      date: ''
    }
  },
  // mounted(){
  //   this.checkThisWeek();
  // },
  methods: {
    // async checkThisWeek(){
    //   this.date = this.$route.params.date
    //   if(this.date){
    //     this.$refs.weeklylottery.refresh()
    //   }

    // },
    async getLotteryWinners ({ page, filter, sort }) {
      try {
        const response = await axios.get(`/api/admin/lottery/getWinnersList?page=${page}&filter=${filter}&sortcol=${sort.fieldName}&sort=${sort.order}&latest=${1}`)

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


  }
}
</script>
