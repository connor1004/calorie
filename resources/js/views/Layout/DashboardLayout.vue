<template>
  <div class="wrapper">
    <notifications></notifications>
    <side-bar>
      <template slot="links">
        <sidebar-item
          :link="{
            name: 'My Food Entries',
            path: '/dashboard',
            icon: 'ni ni-tv-2 text-primary',
          }"
        >
        </sidebar-item>

        <sidebar-item
          :link="{
            name: 'Daily Food Consumption',
            path: '/daily-food-consumption',
            icon: 'ni ni-planet text-blue'
          }"
        >
        </sidebar-item>
      </template>

      <template
        slot="links-after"
        v-if="this.getUser && this.getUser.role == 'admin'"
      >
        <hr class="my-3">
        <h6 class="navbar-heading p-0 text-muted">Admin</h6>

        <b-nav class="navbar-nav mb-md-3">
          <sidebar-item
            :link="{
              name: 'All Food Entries',
              path: '/all-food-entries',
              icon: 'ni ni-tv-2 text-primary',
            }"
          >
          </sidebar-item>

          <sidebar-item
            :link="{
              name: 'Report',
              path: '/report',
              icon: 'ni ni-planet text-blue'
            }"
          >
          </sidebar-item>
        </b-nav>
      </template>
    </side-bar>
    <div class="main-content">
      <dashboard-navbar :type="$route.meta.navbarType"></dashboard-navbar>

      <div @click="$sidebar.displaySidebar(false)">
        <fade-transition :duration="200" origin="center top" mode="out-in">
          <!-- your content here -->
          <router-view></router-view>
        </fade-transition>
      </div>
      <content-footer v-if="!$route.meta.hideFooter"></content-footer>
    </div>
  </div>
</template>
<script>
  /* eslint-disable no-new */
  import PerfectScrollbar from 'perfect-scrollbar';
  import 'perfect-scrollbar/css/perfect-scrollbar.css';

  function hasElement(className) {
    return document.getElementsByClassName(className).length > 0;
  }

  function initScrollbar(className) {
    if (hasElement(className)) {
      new PerfectScrollbar(`.${className}`);
    } else {
      // try to init it later in case this component is loaded async
      setTimeout(() => {
        initScrollbar(className);
      }, 100);
    }
  }

  import DashboardNavbar from './DashboardNavbar.vue';
  import ContentFooter from './ContentFooter.vue';
  import DashboardContent from './Content.vue';
  import { FadeTransition } from 'vue2-transitions';
  import { mapGetters, mapActions } from 'vuex';

  export default {
    components: {
      DashboardNavbar,
      ContentFooter,
      DashboardContent,
      FadeTransition
    },
    computed: {
      ...mapGetters({
        getUser: 'auth/getUser',
      }),
    },
    methods: {
      ...mapActions({
        getUserInfo: 'auth/getUserInfo',
      }),
      initScrollbar() {
        let isWindows = navigator.platform.startsWith('Win');
        if (isWindows) {
          initScrollbar('sidenav');
        }
      }
    },
    mounted() {
      this.initScrollbar()
      if (!this.getUser) {
        this.getUserInfo();
      }
    }
  };
</script>
<style lang="scss">
</style>
