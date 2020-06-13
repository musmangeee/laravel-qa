<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">CMS Pages</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard">
            <a>Home</a>
          </router-link>
        </li>
        <li class="breadcrumb-item active">CMS</li>
      </ol>
      <div class="page-actions">
        <router-link to="/Cms/add">
          <a href="/Cms/add" class="btn btn-primary">
            <i class="icon-fa icon-fa-plus"/> New CMS Page
          </a>
        </router-link>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 hide">
        <div class="card">
          <div class="card-body">
            <table-component  ref="allUsers" :data="getCms" sort-by="row.id" sort-order="desc" table-class="table">

              <table-column show="title_english" label="Title"/>
              <table-column show="slug" label="Slug"/>


              <table-column  :sortable="false" :filterable="false" label>
                <template slot-scope="row">
                  <div class="table__actions">
                    <router-link :to="{ name: 'editcms', params: { cmsId: row.id }}"><a v-b-popover.hover="'EDIT'"
                                                                                        class="btn btn-default btn-sm">
                      <i class="icon-fa icon-fa-pencil"/>
                    </a>
                    </router-link>
                    <router-link :to="{ name: 'viewslug', params: { testSlug: row.slug }}"><a v-b-popover.hover="'Review'"
                                                                                              class="btn btn-default btn-sm">
                      <i class="icon-fa icon-fa-eye"/>
                    </a>
                    </router-link>

                    <a v-b-popover.hover="'DELETE'"
                       class="btn btn-default btn-sm"
                       data-delete
                       data-confirmation="notie"
                       @click="destroyCms(row.id)"

                    >
                      <i class="icon-fa icon-fa-trash"/>
                    </a>
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

<script src="https://vuejs.org/js/vue.min.js"></script>
<script type="text/babel">

import { TableComponent, TableColumn } from "vue-table-component";
import Vue from "vue";
import Ls from "../../../services/ls"
import BootstrapVue from "bootstrap-vue";
// import "bootstrap/dist/css/bootstrap.css";

import { SweetModal, SweetModalTab } from "sweet-modal-vue";
import { Tabs, Tab } from "vue-tabs-component";

Vue.use(BootstrapVue);

export default {
  components: {
    TableComponent,
    TableColumn,
    SweetModal,
    SweetModalTab,
    tabs: Tabs,
    tab: Tab
  },

  filters: {
    tagged: function(value) {
      var elements = "";
      if (!value) return "";
      value = value.split(",");
      value.forEach(function(element) {
        elements += '<span class="tags-frontend">' + element + "</span>";
      });
      return elements;
    }
  },
  data() {
    return {
      Read: "",
      Write: "",
      Delete: "",
      auth_user: [],
      page_html_content: "",
      title_english: "",
      keywords: [],
      modelopen: "",
      testSlug: "",
      propertyupdateid: "",
      status: [],
      users: [],
      green: "green",
      form: {
        status: [],
        selectedstatus: "",
        selectedtype: "",
        submitBtn: "Update",
        id: ""
      }
    };
  },
  validations: {
    form: {
      selectedstatus: {}
    }
  },
 
  methods: {

    async pushtoCMS(slug) {
      this.$router.push({ path: `ViewCms/${slug}` });
    },
    async getCms({ page, filter, sort }) {
      try {
        const response = await axios.get(
          `/api/admin/cms/get?page=${page}&filter=${filter}`
        );
        return {
          data: response.data.data,
          pagination: {
            totalPages: response.data.last_page,
            currentPage: page,
            count: response.data.count
          }
        };
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },

    onImageLoadFailure(event) {
      event.target.src = this.imagelink + "no_uploaded.png";
    },
    destroyCms(id) {
      let self = this;
      window.notie.confirm({
        text: "Are you sure?",
        cancelCallback: function() {},
        submitCallback: function() {
          self.destroyCmsData(id);
        }
      });
    },
    async destroyCmsData(id) {
      try {
        let response = await window.axios.delete("/api/admin/cms/" + id);
        this.cms = response.data;
        window.toastr["success"]("CMS Page Deleted", "Success");
        this.$refs.allUsers.refresh();
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    openprmodel(id) {
      this.propertyupdateid = id;
      this.$refs.dark_html_modal_status.open();
    }
  }
};
</script>
