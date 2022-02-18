<template>
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Customers</h3>
                </div>
                <div class="col-auto">
                    <a href="javascript:void(0);" class="btn btn-primary me-1" data-toggle="modal"
                       data-target="#create_update_customer_modal">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
            </div>
        </div>
        <!--List-->
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-center table-hover datatable">
                                <thead class="thead-light" id="datatable-customers">
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Debits</th>
                                    <th>Credits</th>
                                    <th>Created At</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="customer in customers.data"
                                    :key="customer.id">
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="javascript:void(0);"
                                               @click="$router.push({name: 'customer',params: { id: customer.id }})"
                                            >{{customer.name}} <span>{{customer.id}}</span></a>
                                        </h2>
                                    </td>
                                    <td>{{customer.phone}}</td>
                                    <td><span
                                            class="badge badge-pill bg-success-light ">{{customer.total_debits}}</span>
                                    </td>
                                    <td><span class="badge badge-pill bg-danger">{{customer.total_credits}}</span>
                                    </td>
                                    <td>{{formatDate(customer.created_at)}}</td>
                                    <td class="text-right">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-white text-success me-2"
                                           @click="openInvoiceModal(customer.id)">
                                            <i class="fas fa-file-invoice me-1"></i>Add Invoice
                                        </a>
                                        <a href="javascript:void(0);"
                                           class="btn btn-sm btn-white text-success me-2"
                                           @click="openPaymentModal(customer.id,'debit')"
                                        >
                                            <i class="far fa-trash-alt me-1"></i>Add Debit
                                        </a>
                                        <a href="javascript:void(0);" class="btn btn-sm btn-white text-danger me-2"
                                           @click="openPaymentModal(customer.id,'credit')"
                                        >
                                            <i class="far fa-trash-alt me-1"></i>Add Credit
                                        </a>
                                        <a href="javascript:void(0);" class="btn btn-sm btn-white text-success me-2"
                                           @click="edit(customer)"
                                        >
                                            <i class="far fa-edit me-1"></i> Edit
                                        </a>
                                        <a href="javascript:void(0);"
                                           class="btn btn-sm btn-white text-danger me-2"
                                           @click="remove(customer.id)"
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
                        :data="customers"
                        @pagination-change-page="getResults"
                        align="right"
                />
            </div>
        </div>

        <!-- Create Customer Modal -->
        <div class="modal fade" id="create_update_customer_modal" tabindex="-1" role="dialog"
             aria-labelledby="create_update_customer_modalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-body p-4 px-5">

                        <div class="main-content text-center">
                            <a href="#" class="close-btn" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><span class="icon-close2"></span></span>
                            </a>
                            <h4 class="card-title">{{form.id?'Update':'Create'}} Customer</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" v-model="form.name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" v-model="form.email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" class="form-control" v-model="form.phone">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" v-model="form.address">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Country</label>
                                        <input type="text" class="form-control" v-model="form.country">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>State</label>
                                        <input type="text" class="form-control" v-model="form.state">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" class="form-control" v-model="form.city">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="mx-auto">
                                    <button type="button" class="btn btn-secondary" ref="closeModal"
                                            data-dismiss="modal">Close
                                    </button>
                                    <button type="button" class="btn btn-primary" @click="createUpdate()">
                                        {{form.id?'Update':'Save'}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Modal -->
        <div class="modal fade" id="payment_modal" tabindex="-1" role="dialog"
             aria-labelledby="payment_modalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-body p-4 px-5">

                        <div class="main-content text-center">
                            <a href="#" class="close-btn" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><span class="icon-close2"></span></span>
                            </a>
                            <h4 class="card-title">ADD {{paymentForm.type.toUpperCase() || ''}}</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date:</label>
                                        <!--                                        <div class="cal-icon">-->
                                        <input class="form-control " type="datetime-local" v-model="paymentForm.date">
                                        <!--                                        </div>-->
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Payment Type:</label>
                                        <select v-model="paymentForm.payment_type" class="form-control">
                                            <option value="cash">Cash</option>
                                            <option value="cheque">Cheque</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Amount</label>
                                        <input type="number" class="form-control" v-model="paymentForm.amount">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="mx-auto">
                                    <button type="button" class="btn btn-secondary" ref="closeModal"
                                            data-dismiss="modal">Close
                                    </button>
                                    <button type="button" class="btn btn-primary" @click="createPayment()">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice Modal -->
        <div class="modal fade" id="invoice_modal" tabindex="-1" role="dialog"
             aria-labelledby="invoice_modalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-body p-4 px-5">
                        <div class="main-content text-center">
                            <a href="#" class="close-btn" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><span class="icon-close2"></span></span>
                            </a>
                            <h4 class="card-title">Add Invoice</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Date:</label>
                                        <!--                                        <div class="cal-icon">-->
                                        <input class="form-control " type="datetime-local" v-model="invoiceForm.date">
                                        <!--                                        </div>-->
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Rate</label>
                                        <input type="number" class="form-control" v-model="invoiceForm.rate">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Weight</label>
                                        <input type="text" class="form-control" v-model="invoiceForm.weight">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Purchased/Delivered Form</label>
                                        <input type="text" class="form-control" v-model="invoiceForm.delivered_form">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Material Type</label>
                                        <input type="text" class="form-control" v-model="invoiceForm.type">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Amount Paid</label>
                                        <input type="number" class="form-control" v-model="invoiceForm.amount"
                                               :on-change="updateBalance()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Quantity</label>
                                        <input type="number" class="form-control" v-model="invoiceForm.qty">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Credit</label>
                                        <input type="number" class="form-control" v-model="invoiceForm.credit"
                                               :on-change="updateBalance()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Debit</label>
                                        <input type="number" class="form-control" v-model="invoiceForm.debit"
                                               :on-change="updateBalance()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Balance</label>
                                        <input type="number" class="form-control" v-model="invoiceForm.balance"
                                               readonly>
                                    </div>
                                </div>
                                <div class="col-md-5"></div>
                                <div class="col-md-5"></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary" @click="addToCart()">
                                            <i class="fas fa-plus-circle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive mt-4">
                                <table class="table table-center table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Rate</th>
                                        <th>Weight</th>
                                        <th>Purchased/Delivered Form</th>
                                        <th>Material Type</th>
                                        <th>Amount Paid</th>
                                        <th>Quantity</th>
                                        <th>Credit</th>
                                        <th>Debit</th>
                                        <th>Balance</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(c,i) in cart"
                                        :key="i">
                                        <td>{{i+1}}</td>
                                        <td>{{c.rate}}</td>
                                        <td>{{c.weight}}</td>
                                        <td>{{c.delivered_form}}</td>
                                        <td>{{c.type}}</td>
                                        <td>{{c.amount}}</td>
                                        <td>{{c.qty}}</td>
                                        <td>{{c.credit}}</td>
                                        <td>{{c.debit}}</td>
                                        <td>{{c.balance}}</td>
                                        <td>{{c.date}}</td>
                                        <td class="add-remove text-end">
                                            <i class="fas fa-minus-circle" @click="removeCartItem(i)"></i>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive mt-4">
                                <table class="table table-stripped table-center table-hover">
                                    <thead></thead>
                                    <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-end">Total</td>
                                        <td class="text-end">{{getCartSum}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 mt-4">
                                <div class="mx-auto">
                                    <button type="button" class="btn btn-secondary" ref="closeModal"
                                            data-dismiss="modal">Close
                                    </button>
                                    <button type="button" class="btn btn-primary" @click="storeInvoice()">
                                        Save
                                    </button>
                                    <button type="button" class="btn btn-danger" @click="storeInvoice(true)">
                                        Save & Print
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
  import Swal from 'sweetalert2';
  import { mapGetters } from 'vuex';
  import DateFormatMixin from '../../mixins/date-format';

  export default {
    name: 'Customers',
    mixins: [DateFormatMixin],
    data () {
      return {
        customerId: '',
        form: {
          id: '',
          name: '',
          email: '',
          phone: '',
          country: '',
          state: '',
          city: '',
          address: '',
        },
        paymentForm: {
          customer_id: '',
          type: '',
          payment_type: 'cash',
          date: null,
          amount: null,
        },
        cart: [],
        invoiceForm: {
          date: '',
          weight: '',
          rate: '',
          delivered_form: '',
          type: '',
          amount: '',
          qty: '',
          credit: '',
          debit: '',
          balance: '',
        },
      };
    },
    mounted () {
      this.getResults();
    },
    methods: {
      updateBalance () {
        this.invoiceForm.balance = (+this.invoiceForm.amount || 0) + (+this.invoiceForm.debit || 0)
          - (+this.invoiceForm.credit || 0);
      },
      storeInvoice (print = false) {
        axios.post(`/api/store/invoice/${this.customerId}`, {
          customer_id: this.customerId,
          print: print,
          cart: this.cart,
        }).then(res => {
          Swal.fire(
            'Success',
            'Request has been executed.',
            'success',
          );
          $('#invoice_modal').modal('hide');
          if (print) {
            window.open(`/api/download/invoice/${res.data.invoice_id}`, '_blank');
          }
          this.reset();
        }).catch(error => {
          Swal.fire(
            'Error',
            error.response.data.message,
            'error',
          );
        });
      },
      openInvoiceModal (customerId) {
        this.customerId = customerId;
        $('#invoice_modal').modal('show');
      },
      removeCartItem (index) {
        this.cart?.splice(index, 1);
      },
      addToCart () {
        if (!this.invoiceForm.date || !this.invoiceForm.rate || !this.invoiceForm.weight
          || !this.invoiceForm.delivered_form || !this.invoiceForm.type || !this.invoiceForm.amount) {
          Swal.fire(
            'Error',
            'All fields are required.',
            'error',
          );
        } else {
          this.cart.push({
            date: this.invoiceForm.date,
            rate: this.invoiceForm.rate,
            weight: this.invoiceForm.weight,
            delivered_form: this.invoiceForm.delivered_form,
            type: this.invoiceForm.type,
            amount: this.invoiceForm.amount,
            qty: this.invoiceForm.qty,
            credit: this.invoiceForm.credit,
            debit: this.invoiceForm.debit,
            balance: this.invoiceForm.balance,
          });
          this.invoiceForm.date = '';
          this.invoiceForm.weight = '';
          this.invoiceForm.rate = '';
          this.invoiceForm.delivered_form = '';
          this.invoiceForm.type = '';
          this.invoiceForm.amount = '';
          this.invoiceForm.qty = '';
          this.invoiceForm.credit = '';
          this.invoiceForm.debit = '';
          this.invoiceForm.balance = '';
        }
      },
      createPayment () {
        axios.post('/api/store/payment', this.paymentForm).then(res => {
          Swal.fire(
            'Success',
            'Request has been executed.',
            'success',
          );
          this.getResults();
          $('#payment_modal').modal('hide');
          this.reset();
        }).catch(error => {
          Swal.fire(
            'Error',
            error.response.data.message,
            'error',
          );
        });
      },
      openPaymentModal (customerId, type) {
        this.paymentForm.customer_id = customerId;
        this.paymentForm.type = type;
        $('#payment_modal').modal('show');
      },
      getResults (page = 1) {
        this.$store.dispatch('customers/getCustomers', {
          page,
        });
      },
      createUpdate () {
        this.$store.dispatch('customers/createUpdate', this.form);
        setTimeout(() => {
          this.$refs.closeModal.click();
          this.reset();
        }, 500);
      },
      edit (data) {
        this.form.id = data.id;
        this.form.name = data.name;
        this.form.email = data.email;
        this.form.phone = data.phone;
        this.form.address = data.address;
        this.form.country = data.country;
        this.form.state = data.state;
        this.form.city = data.city;
        $('#create_update_customer_modal').modal('show');
      },
      remove (id) {
        return this.$store.dispatch('customers/delete', { id: id });
      },
      reset () {
        this.customerId = '';
        this.form.id = '';
        this.form.name = '';
        this.form.email = '';
        this.form.phone = '';
        this.form.country = '';
        this.form.state = '';
        this.form.city = '';
        this.form.address = '';
        this.paymentForm.customer_id = '';
        this.paymentForm.type = '';
        this.paymentForm.payment_type = 'cash';
        this.paymentForm.date = null;
        this.paymentForm.amount = null;
        this.cart = [];
        this.invoiceForm.date = '';
        this.invoiceForm.weight = '';
        this.invoiceForm.rate = '';
        this.invoiceForm.delivered_form = '';
        this.invoiceForm.type = '';
        this.invoiceForm.amount = '';
        this.invoiceForm.qty = '';
        this.invoiceForm.credit = '';
        this.invoiceForm.debit = '';
        this.invoiceForm.balance = '';
      },
    },
    computed: {
      ...mapGetters({
        customers: 'customers/getAllCustomers',
      }),
      getCartSum () {
        let total = 0;
        this.cart?.forEach(c => total += +c.amount);
        return total;
      },
    },
  };
</script>

<style scoped>

</style>
