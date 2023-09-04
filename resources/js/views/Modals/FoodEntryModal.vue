<template>
  <b-modal v-model="showEntryModal" centered size="lg">
    <template v-slot:modal-title>
      {{ title }}
    </template>
    <form ref="form" @submit.stop.prevent="handleSubmit">
      <b-row>
        <b-col md="12">
          <b-form-group
            label="Name"
            label-for="name"
            :invalid-feedback="nameInvalidFeedback"
            :state="nameState"
          >
            <b-form-input
              id="name"
              v-model="name"
              type="text"
            ></b-form-input>
          </b-form-group>
        </b-col>
        <b-col md="6">
          <b-form-group
            label="Calorie"
            label-for="calorie"
            :state="calorieState"
            :invalid-feedback="calorieInvalidFeedback"
          >
            <b-form-input
              id="calorie"
              v-model="calorie"
              type="number"
            ></b-form-input>
          </b-form-group>
        </b-col>
        <b-col md="6">
          <b-form-group
            label="Price(USD)"
            label-for="price"
            :state="priceState"
            :invalid-feedback="priceInvalidFeedback"
          >
            <b-form-input
              id="price"
              v-model="price"
              type="number"
            ></b-form-input>
          </b-form-group>
        </b-col>
      </b-row>
      <b-form-group
        :state="takenAtState"
        label="Taken At"
        :invalid-feedback="takenAtInvalidFeedback"
      >
        <b-row>
          <b-col>
            <b-form-input
              id="date"
              v-model="takenAtDate"
              placeholder="Enter date"
              type="date"
            >
            </b-form-input>
          </b-col>
          <b-col>
            <b-form-input
              id="time"
              v-model="takenAtTime"
              placeholder="Enter time"
              type="time"
            ></b-form-input>
          </b-col>
        </b-row>
      </b-form-group>
      <b-form-group
        v-if="isAdmin"
        :state="takenByState"
        label="Taken By"
        label-for="taken-by"
        :invalid-feedback="takenByInvalidFeedback"
      >
        <b-form-select
          id="taken-by"
          v-model="takenBy"
          :options="users"
          text-field="name"
          value-field="id"
        ></b-form-select>
      </b-form-group>
    </form>
    <template v-slot:modal-footer>
      <b-button variant="success" @click="handleSubmit">
        {{ isSaving ? 'Saving ...' : 'Save' }}
      </b-button>
      <b-button variant="secondary" @click="closeModal">Cancel</b-button>
    </template>
  </b-modal>
</template>

<script>
import { mapGetters } from 'vuex';
import format from 'date-fns/format';
import subYears from 'date-fns/subYears';
import axios from '../../axios';
import parse from 'date-fns/parse';

export default {
  name: 'FoodEntryModal',
  props: {
    title: {
      type: String,
      default: 'Add Food Entry',
    },
    value: {
      type: Boolean,
      default: false,
    },
    isAdmin: {
      type: Boolean,
      default: false,
    },
    users: {
      type: Array,
      default: () => [],
    },
    item: {
      type: Object,
      default: () => null,
    },
  },
  data() {
    return {
      name: '',
      calorie: '',
      price: '',
      takenAtDate: format(new Date(), 'yyyy-MM-dd'),
      takenAtTime: format(new Date(), 'HH:mm'),
      takenBy: this.getUser ? this.getUser.id : '',
      nameState: null,
      nameInvalidFeedback: '',
      calorieState: null,
      calorieInvalidFeedback: '',
      priceState: null,
      priceInvalidFeedback: '',
      takenAtState: null,
      takenAtInvalidFeedback: '',
      takenByState: null,
      takenByInvalidFeedback: '',
      isSaving: false,
    };
  },
  computed: {
    ...mapGetters({
      getUser: 'auth/getUser'
    }),
    takenAt() {
      if (!this.takenAtDate || !this.takenAtTime) {
        return null;
      } else {
        return parse(
          this.takenAtDate + ' ' + this.takenAtTime + ':00',
          'yyyy-MM-dd HH:mm:ss',
          new Date()
        );
      }
    },
    showEntryModal: {
      get() {
        return this.value;
      },
      set(newVal) {
        this.$emit('input', newVal);
      }
    }
  },
  mounted() {

  },
  methods: {
    async handleSubmit() {
      if (this.isSaving) {
        return;
      }
      // Exit when the form isn't valid
      if (!this.checkFormValidity()) {
        return;
      }
      
      this.isSaving = true;

      const data = {
        name: this.name,
        calorie: this.calorie,
        price: this.price,
        taken_at: Math.floor(this.takenAt.getTime() / 1000),
        taken_by: this.takenBy,
      };

      try {
        let response;
        if (this.item) {
          response = await axios.put('api/food-entries/' + this.item.id, data);
        } else {
          response = await axios.post('api/food-entries', data);
        }

        if (response.status == 200) {
          this.$emit('save-item');
        }
      } catch (e) {
        console.log('---> ERROR IN saving food entry:', e);
        // if (e.status == 422) {
        //   const errors = e.data.errors;
        //   if (errors.period) {
        //     this.addPeriodState = false;
        //     this.addPeriodInvalidFeedback = errors.period.join(" ");
        //   } else {
        //     this.addPeriodState = true;
        //     this.addPeriodInvalidFeedback = "";
        //   }
        // }
      }
      this.isSaving = false;
    },
    checkFormValidity() {
      this.nameState = null;
      this.nameInvalidFeedback = '';
      this.calorieState = null;
      this.calorieInvalidFeedback = '';
      this.priceState = null;
      this.priceInvalidFeedback = '';
      this.takenAtState = null;
      this.takenAtInvalidFeedback = '';
      this.takenByState = null;
      this.takenByInvalidFeedback = '';

      let isValid = true;
      if (this.name.trim().length == 0) {
        this.nameState = false;
        this.nameInvalidFeedback = "Please enter the food entry name";
        isValid = false;
      }

      if (!this.calorie || (parseFloat(this.calorie) || 0) <= 0) {
        this.calorieState = false;
        this.calorieInvalidFeedback = "Please enter the valid calorie value."
        isValid = false;
      }

      if (!this.price || (parseFloat(this.price) || 0) <= 0) {
        this.priceState = false;
        this.priceInvalidFeedback = "Please enter the valid price."
        isValid = false;
      }

      if (!this.takenAtDate) {
        this.takenAtState = false;
        this.takenAtInvalidFeedback = "Please enter the date when the food was taken.";
        isValid = false;
      }

      if (!this.takenAtTime) {
        this.takenAtState = false;
        this.takenAtInvalidFeedback = "Please enter the time when the food was taken.";
        isValid = false;
      }

      if (this.takenAt) {
        if (this.takenAt > new Date() || this.takenAt < subYears(new Date(), 10)) {
          this.takenAtState = false;
          this.takenAtInvalidFeedback = "Please enter the valid date and time.";
          isValid = false;
        }
      }

      if (!this.takenBy) {
        this.takenByState = false;
        this.takenByInvalidFeedback = "Please select the user who took the food.";
        isValid = false;
      }
      return isValid;
    },
    closeModal() {
      this.$emit('close-modal');
    }
  },
  watch: {
    showEntryModal(newVal) {
      if (!newVal) {
        return;
      }

      this.nameState = null;
      this.nameInvalidFeedback = '';
      this.calorieState = null;
      this.calorieInvalidFeedback = '';
      this.priceState = null;
      this.priceInvalidFeedback = '';
      this.takenAtState = null;
      this.takenAtInvalidFeedback = '';
      this.takenByState = null;
      this.takenByInvalidFeedback = '';

      if (this.item) {
        this.name = this.item.name;
        this.calorie = this.item.calorie;
        this.price = this.item.price;
        this.takenAtDate = format(new Date(this.item.taken_at * 1000), 'yyyy-MM-dd');
        this.takenAtTime = format(new Date(this.item.taken_at * 1000), 'HH:mm');
        this.takenBy = this.item.taken_by;
      } else {
        this.name = '';
        this.calorie = '';
        this.price = '';
        this.takenAtDate = format(new Date(), 'yyyy-MM-dd');
        this.takenAtTime = format(new Date(), 'HH:mm');
        this.takenBy = this.getUser ? this.getUser.id : '';
      }
    }
  }
}
</script>

<style lang="scss" scoped>

</style>