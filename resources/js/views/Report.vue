<template>
  <div v-if="getUser && getUser.role == 'admin'">

    <base-header class="pb-6 pb-8 pt-5 pt-md-8 bg-gradient-success">
      <!-- Card stats -->
      <b-row>
        <b-col xl="4" md="6">
          <stats-card title="Last 7 Days"
                      type="gradient-red"
                      :sub-title="last7DaysCount + ' entries'"
                      icon="ni ni-active-40"
                      class="mb-4">

            <template slot="footer">
              <span class="text-nowrap">Including Today</span>
            </template>
          </stats-card>
        </b-col>
        <b-col xl="4" md="6">
          <stats-card title="Previous 7 Days"
                      type="gradient-orange"
                      :sub-title="previous7DaysCount + ' entries'"
                      icon="ni ni-chart-pie-35"
                      class="mb-4">

            <template slot="footer">
              <span class="text-nowrap">{{getPrevious7DayText}}</span>
            </template>
          </stats-card>
        </b-col>
        <b-col xl="4" md="6">
          <stats-card title="Average Calories Per User"
                      type="gradient-green"
                      :sub-title="last7DaysAverage"
                      icon="ni ni-money-coins"
                      class="mb-4">

            <template slot="footer">
              <span class="text-nowrap">Last 7 Days</span>
            </template>
          </stats-card>

        </b-col>
      </b-row>
    </base-header>
  </div>
</template>
<script>
  import BaseProgress from '../components/BaseProgress';
  import StatsCard from '../components/Cards/StatsCard';
  import { mapGetters } from 'vuex';
  import axios from "../axios";
  import format from 'date-fns/format';
  import subDays from 'date-fns/subDays';

  export default {
    components: {
      BaseProgress,
      StatsCard,
    },
    data() {
      return {
        last7DaysCount: '',
        previous7DaysCount: '',
        last7DaysAverage: '',
      };
    },
    computed: {
      ...mapGetters({
        getUser: 'auth/getUser',
      }),
      getPrevious7DayText() {
        return format(subDays(new Date(), 14), 'MM/dd/yyyy') +
          ' - ' + format(subDays(new Date(), 7), 'MM/dd/yyyy');
      }
    },
    methods: {
      async loadReport() {
        try {
          const resp = await axios.get('/api/report');
          if (resp.status == 200) {
            this.last7DaysCount = resp.data.data.last_7_days_count;
            this.previous7DaysCount = resp.data.data.previous_7_days_count;
            this.last7DaysAverage = resp.data.data.last_7_days_average.toFixed(3);
          }
        } catch (e) {
          console.log('----> ERROR in loadReport:', e);
        }
      }
    },
    mounted() {
      this.loadReport();
    },
    watch: {
      getUser(newVal) {
        if (newVal && newVal.role != 'admin') {
          this.$router.replace({
            name: 'My Food Entries',
          });
        }
      },
    }
  };
</script>
<style>
</style>
