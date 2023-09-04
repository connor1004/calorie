<template>
    <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
        <div class="container-fluid">

            <!--Toggler-->
            <navbar-toggle-button @click.native="showSidebar">
                
            </navbar-toggle-button>
            <router-link class="navbar-brand" to="/">
                <span class="font-weight-bolder text-success">Calorie</span>
            </router-link>

            <slot name="mobile-right">
                <ul class="nav align-items-center d-md-none">
                    <base-dropdown class="nav-item" menu-on-right tag="li" title-tag="a">
                        <a slot="title-container" class="nav-link" href="#" role="button">
                            <div class="media align-items-center">
                              <span class="avatar avatar-sm rounded-circle">
                                <img alt="Image placeholder" :src="profileImg">
                              </span>
                            </div>
                        </a>

                        <a href="#!" class="dropdown-item">
                            <i class="ni ni-user-run"></i>
                            <span>Logout</span>
                        </a>
                    </base-dropdown>
                </ul>
            </slot>
            <slot></slot>
            <div v-show="$sidebar.showSidebar" class="navbar-collapse collapse show" id="sidenav-collapse-main">

                <div class="navbar-collapse-header d-md-none">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <router-link to="/">
                                <span class="font-weight-bolder text-success">Calorie</span>
                            </router-link>
                        </div>
                        <div class="col-6 collapse-close">
                            <navbar-toggle-button @click.native="closeSidebar"></navbar-toggle-button>
                        </div>
                    </div>
                </div>

                <ul class="navbar-nav">
                    <slot name="links">
                    </slot>
                </ul>
                <!--Divider-->
                <hr class="my-3" v-if="this.getUser && this.getUser.role == 'admin'">
                <!--Heading-->
                <h6
                  class="navbar-heading text-muted"
                  v-if="this.getUser && this.getUser.role == 'admin'"
                >
                  Admin
                </h6>
                <!--Navigation-->
                <ul
                  class="navbar-nav mb-md-3"
                  v-if="this.getUser && this.getUser.role == 'admin'"
                >
                    <li class="nav-item">
                        <router-link
                            to="/all-food-entries"
                            class="nav-link"
                            @click.native="closeSidebar"
                        >
                            <i class="ni ni-spaceship"></i> All Food Entries
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link
                            to="/report"
                            class="nav-link"
                            @click.native="closeSidebar"
                        >
                            <i class="ni ni-palette"></i> Report
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
<script>
  import NavbarToggleButton from '../NavbarToggleButton';
  import profileImg from '../../../img/profile.png';
  import { mapGetters } from 'vuex';

  export default {
    name: 'sidebar',
    components: {
      NavbarToggleButton
    },
    data() {
      return {
        profileImg,
      };
    },
    computed: {
      ...mapGetters({
        getUser: 'auth/getUser',
      }),
    },
    props: {
      autoClose: {
        type: Boolean,
        default: true,
        description: 'Whether sidebar should autoclose on mobile when clicking an item'
      }
    },
    provide() {
      return {
        autoClose: this.autoClose
      };
    },
    methods: {
      closeSidebar() {
        this.$sidebar.displaySidebar(false)
      },
      showSidebar() {
        this.$sidebar.displaySidebar(true)
      }
    },
    beforeDestroy() {
      if (this.$sidebar.showSidebar) {
        this.$sidebar.showSidebar = false;
      }
    }
  };
</script>
<style>
.navbar-brand span {
  font-size: 2em;
}
</style>