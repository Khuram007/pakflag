<template>
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title"><b>Employee: </b>{{employee.name}} - #{{employee.id}} since
                        {{formatDate(employee.created_at)}}</h3>
                    <p><b>Phone: </b>{{employee.phone}}</p>
                    <p><b>Email: </b>{{employee.email}}</p>
                    <p><b>Designation: </b>{{employee.designation}}</p>
                    <p><b>Salary: </b>{{employee.salary}}</p>
                    <p><b>Hourly Rate: </b>{{employee.hourly_rate}}</p>
                    <p v-show="employee"><b>Current Salary: </b>{{getCurrentMonthSalary(employee.salary,employee.hourly_rate,employee.current_salaries,employee.current_advance_salaries)}}
                    </p>
                    <p><b>City: </b>{{employee.city}}</p>
                    <p><b>Address: </b>{{employee.address}}</p>
                </div>
            </div>
        </div>
        <!--List-->
        <div class="row">
            <!--Salaries-->
            <div class="col-sm-12">
                <h3>Salaries</h3>
                <div class="card card-table">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-center table-hover datatable">
                                <thead class="thead-light" id="datatable-customers">
                                <tr>
                                    <th>Deduction</th>
                                    <th>Overtime</th>
                                    <th>Created At</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="salary in salaries.data"
                                    :key="salary.id">
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="javascript:void(0);">{{salary.deduction}}
                                                <span>{{salary.id}}</span></a>
                                        </h2>
                                    </td>
                                    <td>{{salary.overtime}}</td>
                                    <td>{{formatDate(salary.created_at)}}</td>
                                    <td class="text-right">
                                        <a href="javascript:void(0);"
                                           class="btn btn-sm btn-white text-danger me-2"
                                           @click="remove(salary.id)"
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
                        :data="salaries"
                        @pagination-change-page="getResults"
                        align="right"
                />
            </div>

            <!--Advance Salaries-->
            <div class="col-sm-12">
                <h3>Advance Salaries</h3>
                <div class="card card-table">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-center table-hover datatable">
                                <thead class="thead-light">
                                <tr>
                                    <th>Created At</th>
                                    <th>Amount</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="salary in advance_salaries.data"
                                    :key="salary.id">
                                    <td>{{formatDate(salary.created_at)}}</td>
                                    <td>{{salary.amount}}</td>
                                    <td class="text-right">
                                        <a href="javascript:void(0);"
                                           class="btn btn-sm btn-white text-danger me-2"
                                           @click="removeAdvanceSalary(salary.id)"
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
                        :data="advance_salaries"
                        @pagination-change-page="getAdvanceResults"
                        align="right"
                />
            </div>
        </div>
    </div>
</template>

<script>
  import Swal from 'sweetalert2';
  import DateFormatMixin from '../../mixins/date-format';
  import SalaryMixin from '../../mixins/salary-mixin';

  export default {
    name: 'Detail',
    mixins: [DateFormatMixin, SalaryMixin],
    data () {
      return {
        employee: {},
        salaries: {},
        advance_salaries: {},
      };
    },
    mounted () {
      this.getResults();
      this.getAdvanceResults();
    },
    methods: {
      getResults (page = 1) {
        axios.get(`/api/get/employee/detail/${this.$route.params.id}/?page=${page}`).then(res => {
          this.employee = res.data.employee;
          this.salaries = res.data.salaries;
        });
      },
      getAdvanceResults (page = 1) {
        axios.get(`/api/get/employee/advance/salary/${this.$route.params.id}/?page=${page}`).then(res => {
          this.advance_salaries = res.data.advance_salaries;
        });
      },
      remove (salaryId) {
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
            axios.post('/api/delete/salary', {
              id: salaryId,
            }).then(res => {
              Swal.fire(
                'Deleted!',
                'Salary has been deleted.',
                'success',
              );
            });
            this.getResults();
          }
        });
      },
      removeAdvanceSalary (salaryId) {
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
            axios.post('/api/delete/advance/salary', {
              id: salaryId,
            }).then(res => {
              Swal.fire(
                'Deleted!',
                'Advance Salary has been deleted.',
                'success',
              );
            });
            this.getAdvanceResults();
          }
        });
      },
    },
  };
</script>

<style scoped>

</style>
