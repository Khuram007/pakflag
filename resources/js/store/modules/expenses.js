import Swal from 'sweetalert2';

export default {
  namespaced: true,
  state: {
    expenses: {
      data: {},
    },
  },
  mutations: {
    SET_EXPENSES: (state, expenses) => {
      state.expenses = expenses;
    },
  },
  getters: {
    getExpenses: state => {
      return state.expenses;
    },
  },
  actions: {
    getExpenses: ({ commit }, payload) => {
      axios.get('api/get/expenses?page=' + payload.page).then(res => {
        commit('SET_EXPENSES', res.data.expenses);
      });
    },
    save: ({ commit }, payload) => {
      axios.post('api/store/expense', payload).then(res => {
        Swal.fire(
          'Success',
          'Request has been executed.',
          'success',
        );
        commit('SET_EXPENSES', res.data.expenses);
      }).catch(err => {
        Swal.fire(
          'Error',
          err.response.data.message,
          'error',
        );
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
          axios.post('api/delete/expense', payload).then(res => {
            Swal.fire(
              'Deleted!',
              'Expense has been deleted.',
              'success',
            );
            commit('SET_EXPENSES', res.data.expenses);
          });
        }
      });

    },
  },
};
