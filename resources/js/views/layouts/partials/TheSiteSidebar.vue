<template>
  <div class="sidebar-left">
    <div class="sidebar-body scroll-pane">
      <div class="side-nav">
        <v-collapse accordion>
          <v-collapse-item active-url="/dashboard/basic">
            <router-link
              slot="item-title"
              to="/dashboard/basic">
              <i class="icon-fa icon-fa-dashboard"/>Dashboard
            </router-link>
          </v-collapse-item>
          <!-- <v-collapse-item active-url="/dashboard">
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-dashboard"/>Dashboard
              <span class="icon-fa arrow icon-fa-fw"/>
            </a>

            <router-link to="/dashboard/basic">
              Basic
            </router-link>

            <router-link to="/dashboard/ecommerce">
              Ecommerce
            </router-link>

            <router-link to="/dashboard/finance">
              Finance
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/layouts">
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-th-large"/>Layouts
              <span class="icon-fa arrow icon-fa-fw"/>
            </a>

            <router-link to="/layouts/sidebar">
              Sidebar
            </router-link>

            <router-link to="/layouts/horizontal">
              Horizontal
            </router-link>

            <router-link to="/layouts/icons-sidebar">
              Icon Sidebar
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/basic-ui">
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-star"/>Basic UI
              <span class="icon-fa arrow icon-fa-fw"/>
            </a>

            <router-link to="/basic-ui/buttons">
              Buttons
            </router-link>

            <router-link to="/basic-ui/cards">
              Cards
            </router-link>

            <router-link to="/basic-ui/typography">
              Typography
            </router-link>

            <router-link to="/basic-ui/tables">
              Tables
            </router-link>

            <router-link to="/basic-ui/progress-bars">
              Progress Bars
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/components">
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-puzzle-piece"/>Components
              <span class="icon-fa arrow icon-fa-fw"/>
            </a>

            <router-link to="/components/notifications">
              Notifications
            </router-link>

            <router-link to="/components/sweet-modals">
              Sweet Modals
            </router-link>

            <router-link to="/components/vue-carousel">
              Vue Carousel
            </router-link>

            <router-link to="/components/vue-dropzone">
              Vue Dropzone
            </router-link>

            <router-link to="/components/vue-tables">
              Vue DataTables
            </router-link>

            <router-link to="/components/vue-tabs">
              Vue Tabs
            </router-link>

            <router-link to="/components/vue-collapse">
              Vue Collapse
            </router-link>

            <router-link to="/components/tooltips">
              Vue Tooltips
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/chart">
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-bar-chart"/>Charts
              <span class="icon-fa arrow icon-fa-fw"/>
            </a>

            <router-link to="/charts/chartjs">
              Chart JS
            </router-link>

            <router-link to="/charts/gauges">
              Gauge Charts
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/icons">
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-eye"/>Icons
              <span class="icon-fa arrow icon-fa-fw"/>
            </a>

            <router-link to="/icons/icomoon">
              IcoMoon
            </router-link>

            <router-link to="/icons/meteo">
              Meteo Icons
            </router-link>

            <router-link to="/icons/line">
              Line Icons
            </router-link>

            <router-link to="/icons/fpsline">
              FPS Line
            </router-link>

            <router-link to="/icons/fontawesome">
              Font Awesome
            </router-link>

          </v-collapse-item>

          <v-collapse-item active-url="/forms">
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-rocket"/>Forms
              <span class="icon-fa arrow icon-fa-fw"/>
            </a>

            <router-link to="/forms/general">
              General Elements
            </router-link>

            <router-link to="/forms/advanced">
              Advanced Elements
            </router-link>

            <router-link to="/forms/layouts">
              Form Layouts
            </router-link>

            <router-link to="/forms/vuelidate">
              Vuelidate
            </router-link>

            <router-link to="/forms/vee-validate">
              Vee Validate
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/gallery">
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-image"/>Gallery
              <span class="icon-fa arrow icon-fa-fw"/>
            </a>

            <router-link to="/gallery/image">
              Image Gallery
            </router-link>

            <router-link to="/gallery/video">
              Video Gallery
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/pages">
            <a slot="item-title" href="#"
            >
              <i class="icon-fa icon-fa-file"/>Pages
              <span class="icon-fa arrow icon-fa-fw"/>
            </a>

            <router-link to="/pages/login">
              Login
            </router-link>

            <router-link to="/pages/login-2">
              Login 2
            </router-link>

            <router-link to="/pages/login-3">
              Login 3
            </router-link>

            <router-link to="/pages/register">
              Register
            </router-link>

            <router-link to="/pages/register-2">
              Register 2
            </router-link>

            <router-link to="/pages/register-3">
              Register 3
            </router-link>
          </v-collapse-item> -->

          <v-collapse-item active-url="/users">
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-user"/>Users
              <span class="icon-fa arrow icon-fa-fw"/>
            </a>

            <router-link to="/users/profile">
              Profile
            </router-link>

            <router-link to="/users/all">
              All Users
            </router-link>
          </v-collapse-item>

          <v-collapse-item active-url="/lottery">
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-ticket"/>Lottery
              <span class="icon-fa arrow icon-fa-fw"/>
            </a>

            <router-link to="/lottery/thisWeek">
              This Week
            </router-link>
            <router-link to="/lotteryWinners">
              Lottery Winners
            </router-link>
            <router-link to="/latestLotteryWinners">
              Latest Lottery Winners
            </router-link>
            <!-- <router-link :to="{ name: 'latestLotteryWinners', params: { date: '20-02-2020' }}">
              Latest Winners
            </router-link> -->
          </v-collapse-item>

          <v-collapse-item active-url="/cms">
            <router-link
              slot="item-title"
              to="/cms">
              <i class="icon-fa icon-fa-clipboard"/>CMS
            </router-link>
          </v-collapse-item>

          <!-- <v-collapse-item active-url="/apps">
            <a slot="item-title" href="#">
              <i class="icon-fa icon-fa-adn"/>Apps
              <span class="icon-fa arrow icon-fa-fw"/>
            </a>

            <router-link
              to="/apps/mailbox">
              Mailbox
            </router-link>

            <router-link to="/apps/todos">
              Todos
            </router-link>
          </v-collapse-item> -->

          <!-- <v-collapse-item active-url="/settings">
            <router-link
              slot="item-title"
              to="/settings">
              <i class="icon-fa icon-fa-cogs"/>Settings
            </router-link>
          </v-collapse-item> -->
        </v-collapse>
      </div>
    </div>
  </div>
</template>