<template>
    <b-card no-body>
        <b-card-header class="border-0">
            <div class="card-header-wrapper">
                <h3 class="mb-0">{{ title }}</h3>
                <base-button
                    size="sm"
                    type="primary"
                    @click="$emit('item-add-click')"
                >
                    Add Food Entry
                </base-button>
            </div>
            <div class="card-header-filter-wrapper">
                <label for="range-picker">Date</label>
                <date-range-picker
                    id="range-picker"
                    ref="picker"
                    opens="right"
                    :autoApply="true"
                    :showDropdowns="true"
                    v-model="dateRange"
                    @update="handleDateRangeUpdate"
                >
                </date-range-picker>
            </div>
        </b-card-header>

        <el-table
            class="table-responsive table"
            header-row-class-name="thead-light"
            :data="currentFoodEntries"
            :empty-text="isLoading? 'Loading food entries ...' : 'No Food Entries'"
        >
            <el-table-column
                label="Name"
                prop="name"
                min-width="185px"
            >
                <template v-slot="{row}">
                    <b-media no-body class="align-items-center">
                        <b-media-body>
                            <span class="font-weight-600 name mb-0 text-sm">{{row.name}}</span>
                        </b-media-body>
                    </b-media>
                </template>
            </el-table-column>

            <el-table-column label="Calorie" prop="calorie" min-width="140px">
            </el-table-column>

            <el-table-column label="Price" prop="price" min-width="140px">
                <template v-slot="{row}">
                    <span>${{row.price}}</span>
                </template>
            </el-table-column>

            <el-table-column label="Taken At" prop="taken_at" min-width="170px">
                <template v-slot="{row}">
                    <span>{{getFormattedTime(row.taken_at)}}</span>
                </template>
            </el-table-column>

            <el-table-column
                label="Taken By"
                prop="taken_by"
                v-if="isAdminTable"
                min-width="185px"
            >
                <template v-slot="{row}">
                    <span>{{row.taken_user.name}}</span>
                </template>
            </el-table-column>

            <el-table-column min-width="180px">
                <template v-slot="{row}">
                    <el-dropdown trigger="click" class="dropdown" :ref="'dropdown' + row.id">
                        <span class="btn btn-sm btn-icon-only text-light">
                            <i class="fas fa-ellipsis-v mt-2"></i>
                        </span>
                        <el-dropdown-menu class="dropdown-menu dropdown-menu-arrow show" slot="dropdown">
                            <b-dropdown-item @click="handleItemUpdateClick(row)">Update</b-dropdown-item>
                            <b-dropdown-item @click="handleItemDeleteClick(row)">Delete</b-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown>
                </template>
            </el-table-column>
        </el-table>

        <b-card-footer class="py-4 d-flex justify-content-end">
            <base-pagination
                v-model="currentPage"
                :per-page="20"
                :total="foodEntries.length"
            ></base-pagination>
        </b-card-footer>
    </b-card>
</template>
<script>
  import { Table, TableColumn, Dropdown, DropdownMenu, DropdownItem} from 'element-ui';
  import format from 'date-fns/format';
  import DateRangePicker from 'vue2-daterange-picker';
    import 'vue2-daterange-picker/dist/vue2-daterange-picker.css';

  export default {
    name: 'FoodTable',
    components: {
      [Table.name]: Table,
      [TableColumn.name]: TableColumn,
      [Dropdown.name]: Dropdown,
      [DropdownItem.name]: DropdownItem,
      [DropdownMenu.name]: DropdownMenu,
      DateRangePicker,
    },
    props: {
        title: {
            type: String,
            default: 'My Food Entries'
        },
        foodEntries: {
            type: Array,
            default: []
        },
        isAdminTable: {
            type: Boolean,
            default: false,
        },
        isLoading: {
            type: Boolean,
            default: false,
        }
    },
    data() {
      return {
        currentPage: 1,
        dateRange: { startDate: null, endDate: null },
      };
    },
    computed: {
        currentFoodEntries() {
            return this.foodEntries.slice((this.currentPage - 1) * 20, this.currentPage * 20);
        }
    },
    watch: {
        foodEntries: {
            handler: function (newValue) {
                const maxPage = Math.ceil(newValue.length / 20.0);
                if (maxPage < this.currentPage) {
                    this.currentPage = maxPage || 1;
                }
            },
            deep: true,
        },
    },
    methods: {
        handleItemUpdateClick(item) {
            this.$refs['dropdown' + item.id].hide();
            this.$emit('item-update-click', item);
        },
        handleItemDeleteClick(item) {
            this.$refs['dropdown' + item.id].hide();
            this.$emit('item-delete-click', item);
        },
        getFormattedTime(date) {
            return format(new Date(date * 1000), 'yyyy-MM-dd HH:mm');
        },
        handleDateRangeUpdate() {
            this.$emit('daterange-update', this.dateRange);
        }
    }
  }
</script>
<style lang="scss" scoped>
::v-deep ul.pagination li:first-child > .page-link {
    border: none;
}

::v-deep .el-table__empty-block {
    text-align: center;
    padding: 12px;
}

::v-deep td {
    vertical-align: middle;
    padding: 12px 24px;
}

.card-header-wrapper {
    display: flex;
    flex-direction: row;
    align-items: center;

    h3 {
        flex: 1;
    }
}

::v-deep .card-header-filter-wrapper {
    margin-top: 10px;
    display: flex;
    align-items: center;

    label {
        margin-right: 10px;
    }

    .vue-daterange-picker {
        width: 200px;
        height: 37px;

        .form-control.reportrange-text {
            height: 100%;
        }
    }
}
</style>
