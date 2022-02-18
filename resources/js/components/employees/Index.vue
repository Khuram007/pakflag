<template>
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Employees</h3>

                </div>
                <div class="col-auto">
                    <a href="javascript:void(0);" class="btn btn-primary me-1"
                       @click="openCreateModal()">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
            </div>
        </div>
        <!--        Employees-->
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-center table-hover datatable">
                                <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Salary</th>
                                    <th>Hourly Rate</th>
                                    <th>Month Deductions</th>
                                    <th>Month Overtime</th>
                                    <th>Month Salary</th>
                                    <th>Month Advance</th>
                                    <th>Created At</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="employee in employees.data"
                                    :key="employee.id">
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="javascript:void(0);"
                                               @click="$router.push({name: 'employee',params: { id: employee.id }})"
                                            >{{employee.name}} <span>{{employee.id}}</span></a>
                                        </h2>
                                    </td>
                                    <td><span class="badge badge-pill bg-success">{{employee.salary}}</span></td>
                                    <td><span class="badge badge-pill bg-info">{{employee.hourly_rate}}</span></td>
                                    <td><span class="badge badge-pill bg-danger">{{getCurrentMonthDeductions(employee.current_salaries)}}</span>
                                    </td>
                                    <td><span class="badge badge-pill bg-success-light">{{getCurrentMonthOverTime(employee.current_salaries)}}</span>
                                        <!--                                    </td>-->
                                    <td><span class="badge badge-pill bg-success">{{getCurrentMonthSalary(employee.salary,employee.hourly_rate,employee.current_salaries,employee.current_advance_salaries)}}</span>
                                    <td><span class="badge badge-pill bg-success-light">{{getCurrentMonthAdvanceSalaries(employee.current_advance_salaries)}}</span>
                                        <!--                                    </td>-->
                                    <td>{{formatDate(employee.created_at)}}</td>
                                    <td class="text-right">
                                        <a :href="`/api/download/salary/${employee.id}`"
                                           class="btn btn-sm btn-white text-info me-2"
                                           target="_blank"
                                        >
                                            <i class="far fa-file-pdf me-1"></i>PDF
                                        </a>
                                        <a href="javascript:void(0);" class="btn btn-sm btn-white text-success me-2"
                                           @click="openSalaryModal(employee)">
                                            <i class="far fa-credit-card me-1"></i> Add Salary
                                        </a>
                                        <a href="javascript:void(0);" class="btn btn-sm btn-white text-success me-2"
                                           @click="openAdvanceSalaryModal(employee)">
                                            <i class="far fa-credit-card me-1"></i> Add Advance
                                        </a>
                                        <a href="javascript:void(0);" class="btn btn-sm btn-white text-success me-2"
                                           @click="openCreateModal(employee)">
                                            <i class="far fa-edit me-1"></i> Edit
                                        </a>
                                        <a href="javascript:void(0);"
                                           class="btn btn-sm btn-white text-danger me-2"
                                           @click="remove(employee.id)"
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
                        :data="employees"
                        @pagination-change-page="getResults"
                        align="right"
                />
            </div>
        </div>

        <!-- Create employee Modal -->
        <div class="modal fade" id="create_update_employee_modal" tabindex="-1" role="dialog"
             aria-labelledby="create_update_employee_modalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-body p-4 px-5">

                        <div class="main-content text-center">
                            <a href="#" class="close-btn" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><span class="icon-close2"></span></span>
                            </a>
                            <h4 class="card-title">{{form.id?'Update':'Create'}} employee</h4>
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
                                        <label>Date of Birth</label>
                                        <input type="datetime-local" class="form-control" v-model="form.dob">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Salary: <small v-show="form.salary">(Hourly:
                                            {{convertSalaryToHourly(form.salary)}})</small></label>
                                        <input type="number" class="form-control" v-model="form.salary">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Designation</label>
                                        <input type="text" class="form-control" v-model="form.designation">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" class="form-control" v-model="form.city">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" v-model="form.address">
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

        <!-- Add Salary Modal -->
        <div class="modal fade" id="add_salary_modal" tabindex="-1" role="dialog"
             aria-labelledby="add_salary_modalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-body p-4 px-5">

                        <div class="main-content text-center">
                            <a href="javascript:void(0);" class="close-btn" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><span class="icon-close2"></span></span>
                            </a>
                            <h4 class="card-title">{{salaryForm.name}}'s Salary</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Deduction</label>
                                        <input type="number" class="form-control" v-model="salaryForm.deduction">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Over Time</label>
                                        <input type="text" class="form-control" v-model="salaryForm.overtime">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="mx-auto">
                                    <button type="button" class="btn btn-secondary" ref="closeSalaryModal"
                                            data-dismiss="modal">Close
                                    </button>
                                    <button type="button" class="btn btn-primary" @click="addSalary()">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Advance Salary Modal -->
        <div class="modal fade" id="add_advance_salary_modal" tabindex="-1" role="dialog"
             aria-labelledby="add_advance_salary_modalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-body p-4 px-5">

                        <div class="main-content text-center">
                            <a href="javascript:void(0);" class="close-btn" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><span class="icon-close2"></span></span>
                            </a>
                            <h4 class="card-title">{{advanceSalaryForm.name}}'s Advance Salary</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Amount</label>
                                        <input type="number" class="form-control" v-model="advanceSalaryForm.amount">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="mx-auto">
                                    <button type="button" class="btn btn-secondary" ref="closeAdvanceSalaryModal"
                                            data-dismiss="modal">Close
                                    </button>
                                    <button type="button" class="btn btn-primary" @click="addAdvanceSalary()">
                                        Save
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
  import DateFormatMixin from '../../mixins/date-format';
  import SalaryMixin from '../../mixins/salary-mixin';
  import Swal from 'sweetalert2';

  export default {
    name: 'Employees',
    mixins: [DateFormatMixin, SalaryMixin],
    data () {
      return {
        form: {
          id: '',
          name: '',
          phone: '',
          email: '',
          designation: '',
          city: '',
          address: '',
          dob: '',
          salary: 0,
        },
        salaryForm: {
          employee_id: '',
          name: '',
          deduction: '',
          overtime: '',
        },
        advanceSalaryForm: {
          employee_id: '',
          name: '',
          amount: ''
        },
      };
    },
    mounted () {
      this.getResults();
    },
    methods: {
      getResults (page = 1) {
        this.$store.dispatch('employees/getEmployees', {
          page,
        });
      },
      openSalaryModal (employee) {
        this.salaryForm.employee_id = employee.id;
        this.salaryForm.name = employee.name;
        $('#add_salary_modal').modal('show');
      },
      openAdvanceSalaryModal (employee) {
        this.advanceSalaryForm.employee_id = employee.id;
        this.advanceSalaryForm.name = employee.name;
        $('#add_advance_salary_modal').modal('show');
      },
      addSalary () {
        axios.post('api/store/salary', this.salaryForm).then(res => {
          Swal.fire(
            'Success',
            'Request has been executed.',
            'success',
          );
          this.getResults();
          this.$refs.closeSalaryModal.click();
          this.reset();
        }).catch(err => {
          Swal.fire(
            'Error',
            err.response.data.message,
            'error',
          );
        });
      },
      addAdvanceSalary () {
        axios.post('api/store/advance/salary', this.advanceSalaryForm).then(res => {
          Swal.fire(
            'Success',
            'Request has been executed.',
            'success',
          );
          this.getResults();
          this.$refs.closeAdvanceSalaryModal.click();
          this.reset();
        }).catch(err => {
          Swal.fire(
            'Error',
            err.response.data.message,
            'error',
          );
        });
      },
      openCreateModal (employee = {}) {
        if (employee) {
          this.form.id = employee.id;
          this.form.name = employee.name;
          this.form.phone = employee.phone;
          this.form.email = employee.email;
          this.form.designation = employee.designation;
          this.form.city = employee.city;
          this.form.address = employee.address;
          this.form.dob = employee.dob;
          this.form.salary = employee.salary;
        }
        $('#create_update_employee_modal').modal('show');
      },
      create () {
        this.$store.dispatch('employees/save', this.form);
        setTimeout(() => {
          this.$refs.closeModal.click();
          this.reset();
        }, 500);
      },
      remove (id) {
        return this.$store.dispatch('employees/delete', { id: id });
      },
      reset () {
        this.form.id = '';
        this.form.name = '';
        this.form.phone = '';
        this.form.email = '';
        this.form.designation = '';
        this.form.city = '';
        this.form.address = '';
        this.form.dob = '';
        this.form.salary = 0;
        this.salaryForm.employee_id = '';
        this.salaryForm.name = '';
        this.salaryForm.deduction = '';
        this.salaryForm.overtime = '';
        this.advanceSalaryForm.employee_id = '';
        this.advanceSalaryForm.name = '';
        this.advanceSalaryForm.amount = '';
      },
    },
    computed: {
      ...mapGetters({
        employees: 'employees/getEmployees',
      }),
    },
  };
</script>

<style scoped>

</style>
