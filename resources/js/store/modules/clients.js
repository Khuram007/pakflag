import Swal from 'sweetalert2'

export default {
  namespaced: true,
  state: {
    clients: {
      data: {},
    },

  },
  mutations: {
    SET_CLIENTS: (state, clients) => {
      state.clients = clients
    },
  },
  getters: {
    getAllClients: state => {
      return state.clients
    },
  },
  actions: {
    getClients: ({ commit }, payload) => {
      axios.get('api/get/clients?page=' + payload.page).then(res => {
        commit('SET_CLIENTS', res.data.clients)
      })
    },
    createUpdate: ({ commit }, payload) => {
      axios.post('api/store/client', payload).then(res => {
        Swal.fire(
          'Success',
          'Request has been executed.',
          'success',
        )
        commit('SET_CLIENTS', res.data.clients)
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
          axios.post('api/delete/client', payload).then(res => {
            Swal.fire(
              'Deleted!',
              'Client has been deleted.',
              'success',
            )
            commit('SET_CLIENTS', res.data.clients)
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
