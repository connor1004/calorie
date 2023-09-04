<template>
  <div v-if="getUser && getUser.role == 'admin'">
    <base-header class="pb-6 pb-8 pt-5 pt-md-8 bg-gradient-success">
      <!-- Card stats -->
      
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
            :isAdminTable="true"
            title="All Food Entries"
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
      :isAdmin="true"
      :users="users"
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
    name: 'AllFoodEntries',
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
        users: []
      };
    },
    computed: {
      ...mapGetters({
        getUser: 'auth/getUser',
      }),
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
          const resp = await axios.get('/api/food-entries/all', { params });
          if (resp.status == 200) {
            this.foodEntries = resp.data.data;
          }
        } catch (e) {
          console.log('----> ERROR in loadMyFoodEntries:', e);
        }

        this.isLoading = false;
      },
      async loadUsers() {
        try {
          const resp = await axios.get('/api/all-users');
          if (resp.status == 200) {
            this.users = resp.data.data;
          }
        } catch (e) {
          console.log('----> ERROR in loadUsers:', e);
        }
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
        this.showEntryModal = false;
      },
      async handleDeleteClick() {
        this.showConfirmModal = false;

        try {
          const response = await axios.delete('api/food-entries/' + this.selectedItem.id);

          if (response.status == 204) {
            this.loadMyFoodEntries();
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
      this.loadUsers();
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
