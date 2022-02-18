<template>
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Received Amount
                        <a href="/api/download/received/amount"
                           class="btn btn-sm btn-white text-info me-2"
                           target="_blank"
                        >
                            <i class="far fa-file-pdf me-1"></i>PDF
                        </a>
                    </h3>
                </div>
                <div class="col-auto">
                    <a href="javascript:void(0);" class="btn btn-primary me-1"
                       @click="openCreateModal()">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-center table-hover datatable">
                                <thead class="thead-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Created At</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="amount in receivedAmount.data"
                                    :key="amount.id">
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="javascript:void(0);">{{formatDate(amount.date)}}<span>{{amount.id}}</span></a>
                                        </h2>
                                    </td>
                                    <td>{{amount.description.substring(0,20)+'...'}}</td>
                                    <td>{{amount.amount}}</td>
                                    <td>{{formatDate(amount.created_at)}}</td>
                                    <td class="text-right">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-white text-success me-2"
                                           @click="openCreateModal(amount)">
                                            <i class="far fa-edit me-1"></i> Edit
                                        </a>
                                        <a href="javascript:void(0);"
                                           class="btn btn-sm btn-white text-danger me-2"
                                           @click="remove(amount.id)"
                                        >
                                            <i class="far fa-trash-alt me-1"></i>Delete
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <pagination
                        :data="receivedAmount"
                        @pagination-change-page="getResults"
                        align="right"
                />
            </div>
        </div>

        <!-- Create Received amount Modal -->
        <div class="modal fade" id="create_update_amount_modal" tabindex="-1" role="dialog"
             aria-labelledby="create_update_amount_modalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-body p-4 px-5">

                        <div class="main-content text-center">
                            <a href="#" class="close-btn" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><span class="icon-close2"></span></span>
                            </a>
                            <h4 class="card-title">{{form.id?'Update':'Create'}} Received Amount</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="datetime-local" class="form-control" v-model="form.date">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Amount</label>
                                        <input type="number" class="form-control" v-model="form.amount">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea rows="2" class="form-control" v-model="form.description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="mx-auto">
                                    <button type="button" class="btn btn-secondary" ref="closeModal"
                                            data-dismiss="modal">Close
                                    </button>
                                    <button type="button" class="btn btn-primary" @click="create()">
                                        {{form.id?'Update':'Save'}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  import { mapGetters } from 'vuex';
  import moment from 'moment';
  import DateFormatMixin from '../../mixins/date-format';

  export default {
    name: 'ReceivedAmount',
    mixins: [DateFormatMixin],
    data () {
      return {
        form: {
          id: '',
          description: '',
          date: '',
          amount: '',
        },
      };
    },
    mounted () {
      this.getResults();
    },
    methods: {
      getResults (page = 1) {
        // axios.get('api/get/received/amount?page=' + page).then(res => {
        this.$store.dispatch('receivedAmount/getAmount', {
          page,
        });
        // })
      },
      openCreateModal (expense = {}) {
        if (expense) {
          this.form.id = expense.id;
          this.form.amount = expense.amount;
          this.form.date = expense.date;
          this.form.description = expense.description;
        }
        $('#create_update_amount_modal').modal('show');
      },
      create () {
        this.$store.dispatch('receivedAmount/save', this.form);
        setTimeout(() => {
          this.$refs.closeModal.click();
          this.reset();
        }, 500);
      },
      remove (id) {
        return this.$store.dispatch('receivedAmount/delete', { id: id });
      },
      reset () {
        this.form.id = '';
        this.form.description = '';
        this.form.date = '';
        this.form.amount = '';
      },
    },
    computed: {
      ...mapGetters({
        receivedAmount: 'receivedAmount/getAmount',
      }),
    },
  };
</script>

<style scoped>

</style>
