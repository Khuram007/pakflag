import Swal from 'sweetalert2'

export default {
  namespaced: true,
  state: {
    employees: {
      data: {},
    },
  },
  mutations: {
    SET_EMPLOYEES: (state, employees) => {
      state.employees = employees
    },
  },
  getters: {
    getEmployees: state => {
      return state.employees
    },
  },
  actions: {
    getEmployees: ({ commit }, payload) => {
      axios.get('api/get/employees?page=' + payload.page).then(res => {
        commit('SET_EMPLOYEES', res.data.employees)
      })
    },
    save: ({ commit }, payload) => {
      axios.post('api/store/employee', payload).then(res => {
        Swal.fire(
          'Success',
          'Request has been executed.',
          'success',
        )
        commit('SET_EMPLOYEES', res.data.employees)
      }).catch(err => {
        Swal.fire(
          'Error',
          err.response.data.message,
          'error',
        )
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
          axios.post('api/delete/employee', payload).then(res => {
            Swal.fire(
              'Deleted!',
              'Employee has been deleted.',
              'success',
            )
            commit('SET_EMPLOYEES', res.data.employees)
          })
        }
      })

    },
  },
}
