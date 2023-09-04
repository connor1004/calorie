<template>
  <div>
    <base-header class="pb-6 pb-8 pt-5 pt-md-8 bg-gradient-success warning-header">
      <!-- Card stats -->
      <b-alert show v-if="errorMessage" variant="danger" v-html="errorMessage">
      </b-alert>
      
    </base-header>
    <b-container fluid class="mt--7">
      <b-row>
        <b-col>
          <food-table
            :foodEntries="foodEntries"
            @item-add-click="handleItemAddClick"
            @item-update-click="handleItemUpdateClick"
            @item-delete-click="handleItemDeleteClick"
            @daterange-update="handleDaterangeUpdate"
            :isLoading="isLoading"
          />
        </b-col>
      </b-row>
    </b-container>

    <food-entry-modal
      :title="modalTitle"
      v-model="showEntryModal"
      :item="selectedItem"
      @save-item="handleSaveItem"
      @close-modal="showEntryModal = false"
    />

    <delete-confirm-modal
      v-model="showConfirmModal"
      @delete-click="handleDeleteClick"
      @cancel-click="showConfirmModal = false"
    />
  </div>
</template>
<script>
  import FoodTable from "./Tables/FoodTable";
  import axios from "../axios";
  import FoodEntryModal from './Modals/FoodEntryModal';
  import DeleteConfirmModal from './Modals/DeleteConfirmModal';
  import addDays from 'date-fns/addDays';
  import set from 'date-fns/set';
  import { mapGetters } from 'vuex';

  export default {
    components: {
      FoodTable,
      FoodEntryModal,
      DeleteConfirmModal,
    },
    data() {
      return {
        foodEntries: [],
        isLoading: false,
        modalTitle: '',
        showEntryModal: false,
        selectedItem: null,
        showConfirmModal: false,
        dateRange: { startDate: null, endDate: null },
        calorieConsumption: 0,
        moneySpent: 0,
        timer: 0,
      };
    },
    computed: {
      ...mapGetters({
        getUser: 'auth/getUser',
      }),
      errorMessage() {
        const dailyLimit = this.getUser ? this.getUser.daily_calorie_limit : 2100;
        const errors = [];

        if (this.calorieConsumption == dailyLimit) {
          errors.push('The daily threshold limit of calories was reached today.');
        } else if (this.calorieConsumption > dailyLimit) {
          errors.push('The daily threshold limit of calories was exceeded today.');
        }

        if (this.moneySpent >= 1000) {
          errors.push('They monthly threshold limit of money was reached.')
        }

        return errors.join('<br/>');
      }
    },
    methods: {
      async loadMyFoodEntries() {
        this.isLoading = true;

        const params = {};
        if (this.dateRange.startDate) {
          const startDate = set(
            this.dateRange.startDate,
            { hours: 0, minutes: 0, seconds: 0, milliseconds: 0}
          );
          params.start = Math.floor(startDate.getTime() / 1000);
        }

        if (this.dateRange.endDate) {
          const endDate = set(
            addDays(this.dateRange.endDate, 1),
            { hours: 0, minutes: 0, seconds: 0, milliseconds: 0}
          );
          params.end = Math.floor(endDate.getTime() / 1000);
        }

        try {
          const resp = await axios.get('/api/food-entries', { params });
          if (resp.status == 200) {
            this.foodEntries = resp.data.data;
          }
        } catch (e) {
          console.log('----> ERROR in loadMyFoodEntries:', e);
        }

        this.isLoading = false;
      },
      async loadUserStats() {

        try {
          const resp = await axios.get('/api/user-stats', {
            params: {
              timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
            }
          });
          if (resp.status == 200) {
            this.calorieConsumption = parseFloat(resp.data.data.calorie_consumption);
            this.moneySpent = parseFloat(resp.data.data.money_spent);
          }
        } catch (e) {
          console.log('----> ERROR in loadMyFoodEntries:', e);
        }

        this.isLoading = false;
      },
      handleItemAddClick() {
        this.selectedItem = null;
        this.modalTitle = "Add Food Entry";
        this.showEntryModal = true;
      },
      handleItemUpdateClick(item) {
        this.selectedItem = item;
        this.modalTitle = "Update Food Entry";
        this.showEntryModal = true;
      },
      handleItemDeleteClick(item) {
        this.selectedItem = item;
        this.showConfirmModal = true;
      },
      handleSaveItem() {
        this.loadMyFoodEntries();
        this.loadUserStats();
        this.showEntryModal = false;
      },
      async handleDeleteClick() {
        this.showConfirmModal = false;

        try {
          const response = await axios.delete('api/food-entries/' + this.selectedItem.id);

          if (response.status == 204) {
            this.loadMyFoodEntries();
            this.loadUserStats();
          }
        } catch (e) {
          console.log('----> ERROR in deleting a food entry:', e);
        }
      },
      handleDaterangeUpdate(dateRange) {
        this.dateRange = dateRange;
        this.loadMyFoodEntries();
      }
    },
    mounted() {
      this.loadMyFoodEntries();
      this.loadUserStats();

      this.timer = setInterval(this.loadUserStats, 5000);
    },
    beforeDestroy() {
      clearInterval(this.timer);
    }
  };
</script>
<style lang="scss" scoped>
.warning-header ::v-deep .header-body {
  background-color: white;
  border-radius: 0.375rem;
}
</style>
