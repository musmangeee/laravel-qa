<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Withdraw Requests</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Withdraw</a></li>
        <li class="breadcrumb-item active">Withdraw Requests</li>
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
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h6>All Requests</h6>
            <div class="card-actions" />
          </div>
          <div class="card-body">
            <table-component
              :data="getWithdrawRequests"
              sort-by="is_proceed"
              sort-order="asc"
              table-class="table"
            >
              <table-column :sortable="false" :filterable="false" label="Requester Name">
                <template slot-scope="row">
                  <div>
                    <router-link
                      v-b-popover.hover="'View Profile'"
                      :to="{ name: 'userprofile', params: { userId: row.user_id }}"
                      class="user-color"
                    >
                    {{ row.user.user_name }}
                    </router-link>
                  </div>
                </template>
              </table-column>
              <table-column :sortable="false" :filterable="false" label="Email">
                <template slot-scope="row">
                    {{ row.user.email }}
                </template>
              </table-column>
              <table-column :sortable="false" :filterable="false" label="User Balance">
                <template slot-scope="row">
                    {{ row.user_wallet.total_balance }}
                </template>
              </table-column>
              <table-column show="amount" label="Withdraw Amount"/>
              <table-column
                show="created_at"
                label="Requested On"
                data-type="date:YYYY-MM-DD h:i:s"
              />
              <table-column
                :sortable="false"
                :filterable="false"
                label=""
              >
                <template slot-scope="row">
                  <div class="table__actions">
                    <router-link v-if="row.is_proceed != 1" :to="{ name: 'UserWallet', params: { withdrawId: row.id }}">
                      <a class="btn btn-default btn-sm">
                        <i class="icon-fa icon-fa-money"/> Process Request
                      </a>
                    </router-link>
                      <a v-else class="btn btn-default btn-sm">
                         Already Processed
                      </a>
                    <!-- <a
                      class="btn btn-default btn-sm"
                      data-delete
                      data-confirmation="notie"
                      @click="deleteUser(row.id)"
                    >
                      <i class="icon-fa icon-fa-trash"/> Delete
                    </a> -->
                  </div>
                </template>
              </table-column>
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
      users: []
    }
  },
  methods: {
    async getWithdrawRequests ({ page, filter, sort }) {
      try {
        const response = await axios.get(`/api/admin/withdraw-requests/get?page=${page}&filter=${filter}&sortcol=${sort.fieldName}&sort=${sort.order}`)

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
    }
  }
}
</script>
