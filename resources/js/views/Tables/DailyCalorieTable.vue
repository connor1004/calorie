<template>
    <b-card no-body>
        <b-card-header class="border-0">
            <div class="card-header-wrapper">
                <h3 class="mb-0">Daily Food Consumption</h3>
                <span>
                    <small>Daily Calorie Limit: {{ getUser ? getUser.daily_calorie_limit : '' }}</small>
                </span>
            </div>
        </b-card-header>

        <el-table
            class="table-responsive table"
            header-row-class-name="thead-light"
            :data="currentPageData"
            :empty-text="isLoading? 'Loading data ...' : 'No Data'"
        >
            <el-table-column label="Date"
                             prop="date">
                <template v-slot="{row}">
                    <b-media no-body class="align-items-center">
                        <b-media-body>
                            <span class="font-weight-600 name mb-0 text-sm">{{row.date}}</span>
                        </b-media-body>
                    </b-media>
                </template>
            </el-table-column>
            <el-table-column label="Calorie"
                             prop="calorie">
                <template v-slot="{row}">
                    {{ row.calorie.toFixed(3) }}
                </template>
            </el-table-column>

            <el-table-column label="Status" prop="status">
                <template v-slot="{row}">
                    <badge class="badge-dot mr-4" type="" v-if="getUser">
                        <i :class="`bg-${row.statusType}`"></i>
                        <span class="status" :class="`text-${row.statusType}`">{{row.status}}</span>
                    </badge>
                </template>
            </el-table-column>
        </el-table>

        <b-card-footer class="py-4 d-flex justify-content-end">
            <base-pagination
                v-model="currentPage"
                :per-page="20"
                :total="tableData.length"
            ></base-pagination>
        </b-card-footer>
    </b-card>
</template>
<script>
  import { Table, TableColumn } from 'element-ui';
  import { mapGetters } from 'vuex';

  export default {
    name: 'DailyCalorieTable',
    components: {
      [Table.name]: Table,
      [TableColumn.name]: TableColumn,
    },
    props: {
        tableData: {
            type: Array,
            default: []
        },
        isLoading: {
            type: Boolean,
            default: false,
        }
    },
    data() {
      return {
        currentPage: 1,
      };
    },
    computed: {
        ...mapGetters({
            getUser: 'auth/getUser',
        }),
        currentPageData() {
            return this.tableData.slice((this.currentPage - 1) * 20, this.currentPage * 20);
        },
    },
    watch: {
        tableData: {
            handler: function (newValue) {
                const maxPage = Math.ceil(newValue.length / 20.0);
                if (maxPage < this.currentPage) {
                    this.currentPage = maxPage || 1;
                }
            },
            deep: true,
        },
    },
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
    padding: 12px;
}

.card-header-wrapper {
    display: flex;
    flex-direction: row;
    align-items: center;

    h3 {
        flex: 1;
    }
}
</style>
