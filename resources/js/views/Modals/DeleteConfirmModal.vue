<template>
  <b-modal v-model="showModal" centered>
    <template v-slot:modal-title>
      Confirm
    </template>
    Do you really want to delete the food entry?
    <template v-slot:modal-footer>
      <button class="btn btn-danger btn-sm" @click="handleDelete">Yes</button>
      <button class="btn btn-secondary btn-sm" @click="handleClose">No</button>
    </template>
  </b-modal>
</template>

<script>
export default {
  name: 'DeleteConfirmModal',
  props: {
    value: {
      type: Boolean,
      default: false,
    },
  },
  computed: {
    showModal: {
      get() {
        return this.value;
      },
      set(newVal) {
        this.$emit('input', newVal);
      }
    }
  },
  methods: {
    handleDelete() {
      this.$emit('delete-click');
    },
    handleClose() {
      this.$emit('cancel-click');
    }
  }
}
</script>