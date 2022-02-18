<template>
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Tasks</h3>
                </div>
                <div class="col-auto">
                    <a href="javascript:void(0);" class="btn btn-primary me-1" data-toggle="modal"
                       data-target="#create_update_task_modal">
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
                                    <th>Title</th>
                                    <th>Deadline</th>
                                    <th>Created At</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="task in tasks.data"
                                    :key="task.id">
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="javascript:void(0);">{{task.title}} <span>{{task.id}}</span></a>
                                        </h2>
                                    </td>
                                    <td>{{convertDateWithTimezone(task.created_at)}}</td>
                                    <td>{{formatDate(task.created_at)}}</td>
                                    <td class="text-right">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-white text-success me-2"
                                           @click="edit(task)"
                                        >
                                            <i class="far fa-edit me-1"></i> Edit
                                        </a>
                                        <a href="javascript:void(0);"
                                           class="btn btn-sm btn-white text-danger me-2"
                                           @click="remove(task.id)"
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
                        :data="tasks"
                        @pagination-change-page="getResults"
                        align="right"
                />
            </div>
        </div>

        <!-- Create Task Modal -->
        <div class="modal fade" id="create_update_task_modal" tabindex="-1" role="dialog"
             aria-labelledby="create_update_task_modalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-body p-4 px-5">

                        <div class="main-content text-center">
                            <a href="#" class="close-btn" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><span class="icon-close2"></span></span>
                            </a>
                            <h4 class="card-title">{{form.id?'Update':'Create'}} Task</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" v-model="form.title">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Deadline</label>
                                        <input type="datetime-local" class="form-control" v-model="form.deadline">
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

    </div>
</template>

<script>
  import Swal from 'sweetalert2';
  import { mapGetters } from 'vuex';
  import moment from 'moment';
  import momentTz from 'moment-timezone';
  import DateFormatMixin from '../../mixins/date-format';

  export default {
    name: 'Tasks',
    mixins: [DateFormatMixin],
    data () {
      return {
        timezone: momentTz.tz.guess(),
        form: {
          id: '',
          title: '',
          deadline: '',
        },
      };
    },
    mounted () {
      this.getResults();
    },
    methods: {
      getResults (page = 1) {
        this.$store.dispatch('tasks/getTasks', {
          page,
        });
      },
      convertDateWithTimezone (date) {
        return moment(date).tz(this.timezone).format('dddd, MMMM Do YYYY, h:mm:ss a') + ' ' +
          moment.tz(this.timezone).format('z');
      },
      createUpdate () {
        this.$store.dispatch('tasks/createUpdate', this.form);
        setTimeout(() => {
          this.$refs.closeModal.click();
          this.reset();
        }, 500);
      },
      edit (data) {
        this.form.id = data.id;
        this.form.title = data.title;
        this.form.deadline = data.deadline;
        $('#create_update_task_modal').modal('show');
      },
      remove (id) {
        return this.$store.dispatch('tasks/delete', { id: id });
      },
      reset () {
        this.form.id = '';
        this.form.title = '';
        this.form.deadline = '';
      },
    },
    computed: {
      ...mapGetters({
        tasks: 'tasks/getAllTasks',
      }),
    },
  };
</script>

<style scoped>

</style>
