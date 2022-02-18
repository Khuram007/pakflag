<template>
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title"><b>Customer: </b>{{customer.name}} - #{{customer.id}}</h3>
                    <p><b>Address: </b>{{customer.address}}, {{customer.city}}, {{customer.state}}, {{customer.country}}</p>
                    <p><b>Total Debits: </b>{{totalDebits || 0}}</p>
                    <p><b>Total Credits: </b>{{totalCredits || 0}}</p>
                </div>
            </div>
        </div>
        <!--List-->
        <div class="row">
            <!--            Payments-->
            <div class="col-sm-12">
                <h3>Payments</h3>
                <div class="card card-table">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-center table-hover datatable">
                                <thead class="thead-light" id="datatable-customers">
                                <tr>
                                    <th>Type</th>
                                    <th>Payment Type</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="payment in payments.data"
                                    :key="payment.id">
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="javascript:void(0);">{{payment.type}}
                                                <span>{{payment.id}}</span></a>
                                        </h2>
                                    </td>
                                    <td>{{payment.payment_type}}</td>
                                    <td>{{payment.amount}}</td>
                                    <td>{{payment.date}}</td>
                                    <td class="text-right">
                                        <a href="javascript:void(0);"
                                           class="btn btn-sm btn-white text-danger me-2"
                                           @click="remove(payment.id)"
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
                        :data="payments"
                        @pagination-change-page="getResults"
                        align="right"
                />
            </div>
            <!--            Invoices-->
            <div class="col-sm-12">
                <h3>Invoices</h3>
                <div class="card card-table">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-center table-hover datatable">
                                <thead class="thead-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Rate</th>
                                    <th>Weight</th>
                                    <th>Delivered Form</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Quantity</th>
                                    <th>Credit</th>
                                    <th>Debit</th>
                                    <th>Balance</th>
                                    <th>Created At</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="invoice in invoices.data"
                                    :key="invoice.id">
                                    <td>{{formatDate(invoice.created_at)}}</td>
                                    <td>
                                        {{invoice.items[0].rate}}
                                    </td>
                                    <td>{{invoice.items[0].weight}}</td>
                                    <td>{{invoice.items[0].delivered_form}}</td>
                                    <td>{{invoice.items[0].type}}</td>
                                    <td>{{invoice.items[0].amount}}</td>
                                    <td>{{invoice.items[0].qty}}</td>
                                    <td>{{invoice.items[0].credit}}</td>
                                    <td>{{invoice.items[0].debit}}</td>
                                    <td>{{invoice.items[0].balance}}</td>
                                    <td>{{formatDate(invoice.items[0].date)}}</td>
                                    <td class="text-right">
                                        <a :href="`/api/download/invoice/${invoice.id}`"
                                           class="btn btn-sm btn-white text-info me-2"
                                           target="_blank"
                                        >
                                            <i class="far fa-file-pdf me-1"></i>PDF
                                        </a>
                                        <a href="javascript:void(0);"
                                           class="btn btn-sm btn-white text-danger me-2"
                                           @click="removeInvoice(invoice.id)"
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
                        :data="invoices"
                        @pagination-change-page="getResultsInvoices()"
                        align="right"
                />
            </div>
        </div>
    </div>
</template>

<script>
  import Swal from 'sweetalert2';
  import DateFormatMixin from '../../mixins/date-format';

  export default {
    name: 'Detail',
    mixins: [DateFormatMixin],
    data () {
      return {
        customer: {},
        totalDebits: 0,
        totalCredits: 0,
        payments: {},
        invoices: {},
      };
    },
    mounted () {
      this.getResults();
      this.getResultsInvoices();
    },
    methods: {
      getResults (page = 1) {
        axios.get(`/api/get/customer/detail/${this.$route.params.id}/?page=${page}`).then(res => {
          this.customer = res.data.customer;
          this.totalDebits = res.data.total_debits;
          this.totalCredits = res.data.total_credits;
          this.payments = res.data.payments;
        });
      },
      getResultsInvoices (allowPagination = true, page = 1) {
        if (this.invoices && allowPagination) {
          if (this.invoices.next_page_url) {
            let url = this.invoices.next_page_url;
            let name = 'page';
            name = name.replace(/[\[]/, '\\\[').replace(/[\]]/, '\\\]');
            let regexS = '[\\?&]' + name + '=([^&#]*)';
            let regex = new RegExp(regexS);
            let results = regex.exec(url);
            page = results == null ? 1 : results[1];
          }
        }
        axios.get(`/api/get/invoices/${this.$route.params.id}/?page=${page}`).then(res => {
          this.invoices = res.data.invoices;
        });
      },
      remove (paymentId) {
        Swal.fire({
          title: 'Are you sure?',
          text: 'You want to delete!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#472399',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
          if (result.isConfirmed) {
            axios.post('/api/delete/payment', {
              id: paymentId,
            }).then(res => {
              Swal.fire(
                'Deleted!',
                'Customer has been deleted.',
                'success',
              );
            });
            this.getResults();
          }
        });
      },
      removeInvoice (invoiceId) {
        Swal.fire({
          title: 'Are you sure?',
          text: 'You want to delete!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#472399',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
          if (result.isConfirmed) {
            axios.post('/api/delete/invoice', {
              id: invoiceId,
            }).then(res => {
              Swal.fire(
                'Deleted!',
                'Customer has been deleted.',
                'success',
              );
            });
            this.getResultsInvoices(false);
          }
        });
      },
    },
  };
</script>

<style scoped>

</style>
