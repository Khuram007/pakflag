import Swal from 'sweetalert2';

export default {
  namespaced: true,
  state: {
    receivedAmount: {
      data: {},
    },
  },
  mutations: {
    SET_AMOUNT: (state, receivedAmount) => {
      state.receivedAmount = receivedAmount;
    },
  },
  getters: {
    getAmount: state => {
      return state.receivedAmount;
    },
  },
  actions: {
    getAmount: ({ commit }, payload) => {
      axios.get('/api/get/received/amount?page=' + payload.page).then(res => {
        commit('SET_AMOUNT', res.data.receivedAmount);
      });
    },
    save: ({ commit }, payload) => {
      axios.post('/api/store/received/amount', payload).then(res => {
        Swal.fire(
          'Success',
          'Request has been executed.',
          'success',
        );
        commit('SET_AMOUNT', res.data.receivedAmount);
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
          axios.post('/api/delete/received/amount', payload).then(res => {
            Swal.fire(
              'Deleted!',
              'Received Amount has been deleted.',
              'success',
            );
            commit('SET_AMOUNT', res.data.receivedAmount);
          });
        }
      });

    },
  },
};
