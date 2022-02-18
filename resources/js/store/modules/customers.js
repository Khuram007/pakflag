import Swal from 'sweetalert2'

export default {
  namespaced: true,
  state: {
    customers: {
      data: {},
    },

  },
  mutations: {
    SET_CUSTOMERS: (state, customers) => {
      state.customers = customers
    },
  },
  getters: {
    getAllCustomers: state => {
      return state.customers
    },
  },
  actions: {
    getCustomers: ({ commit }, payload) => {
      axios.get('api/get/customers?page=' + payload.page).then(res => {
        commit('SET_CUSTOMERS', res.data.customers)
      })
    },
    createUpdate: ({ commit }, payload) => {
      axios.post('api/store/customer', payload).then(res => {
        Swal.fire(
          'Success',
          'Request has been executed.',
          'success',
        )
        commit('SET_CUSTOMERS', res.data.customers)
      })
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
          axios.post('api/delete/customer', payload).then(res => {
            Swal.fire(
              'Deleted!',
              'Customer has been deleted.',
              'success',
            )
            commit('SET_CUSTOMERS', res.data.customers)
          }).catch(err => {
            Swal.fire(
              'Error',
              err.response.data.message,
              'error',
            )
          })
        }
      })
    },
  },
}
