import Swal from 'sweetalert2';

export default {
  namespaced: true,
  state: {
    tasks: {
      data: {},
    }
  },
  mutations: {
    SET_TASKS: (state, tasks) => {
      state.tasks = tasks;
    },
  },
  getters: {
    getAllTasks: state => {
      return state.tasks;
    },
  },
  actions: {
    getTasks: ({ commit }, payload) => {
      axios.get('api/get/tasks?page=' + payload.page).then(res => {
        commit('SET_TASKS', res.data.tasks);
      });
    },
    createUpdate: ({ commit }, payload) => {
      axios.post('api/store/task', payload).then(res => {
        Swal.fire(
          'Success',
          'Request has been executed.',
          'success',
        );
        commit('SET_TASKS', res.data.tasks);
      });
    },
    delete: ({ commit }, payload) => {
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
          axios.post('api/delete/task', payload).then(res => {
            Swal.fire(
              'Deleted!',
              'Task has been deleted.',
              'success',
            );
            commit('SET_TASKS', res.data.tasks);
          }).catch(err => {
            Swal.fire(
              'Error',
              err.response.data.message,
              'error',
            );
          });
        }
      });
    },
  },
};
