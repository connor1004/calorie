<template>
  <div>
    <base-header class="pb-6 pb-8 pt-5 pt-md-8 bg-gradient-success">
      <!-- Card stats -->
      
    </base-header>
    <b-container fluid class="mt--7">
      <b-row>
        <b-col>
          <daily-calorie-table
            :tableData="dailyCaloriesData"
            :isLoading="isLoading"
          />
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>
<script>
  import DailyCalorieTable from "./Tables/DailyCalorieTable";
  import axios from "../axios";
  import format from 'date-fns/format';
  import { mapGetters } from 'vuex';

  export default {
    name: 'DailyFoodConsumption',
    components: {
      DailyCalorieTable,
    },
    data() {
      return {
        tableData: [],
        isLoading: false,
      };
    },
    computed: {
      ...mapGetters({
        getUser: 'auth/getUser',
      }),
      dailyCaloriesData() {
        const limit = this.getUser ? this.getUser.daily_calorie_limit: 2100.000;

        return this.tableData.map(item => {
          if (item.calorie > limit) {
            item.status = 'Exceeded the limit';
            item.statusType = 'danger';
          } else if (item.calorie == limit) {
            item.status = 'Reached the limit';
            item.statusType = 'warning';
          } else {
            item.status = 'Safe';
            item.statusType = 'success';
          }
          return item;
        });
      }
    },
    methods: {
      async loadTableData() {
        this.isLoading = true;

        try {
          const resp = await axios.get('/api/food-entries');
          if (resp.status == 200) {
            const foodEntries = resp.data.data;
            const data = {};

            for (let item of foodEntries) {
              const date = format(new Date(item.taken_at * 1000), 'yyyy-MM-dd');

              if (data[date]) {
                data[date].calorie += parseFloat(item.calorie);
              } else {
                data[date] = {
                  date,
                  calorie: parseFloat(item.calorie),
                };
              }
            }

            this.tableData = Object.values(data).sort((a, b) => a.date > b.date ? -1 : 1);
          }
        } catch (e) {
          console.log('----> ERROR in loadMyFoodEntries:', e);
        }

        this.isLoading = false;
      },
    },
    mounted() {
      this.loadTableData();
    }
  };
</script>
<style>
</style>
