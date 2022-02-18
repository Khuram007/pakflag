import Swal from 'sweetalert2'

export default {
  namespaced: true,
  state: {
    received: 0,
    pending: 0,
    customersCounter: 0,
    employeesCounter: 0,
  },
  mutations: {
    SET_RECEIVED: (state, received) => {
      state.received = received
    },
    SET_PENDING: (state, pending) => {
      state.pending = pending
    },
    SET_CUSTOMER_COUNTER: (state, customersCounter) => {
      state.customersCounter = customersCounter
    },
    SET_EMPLOYEES_COUNTER: (state, employeeCounter) => {
      state.employeesCounter = employeeCounter
    },
  },
  getters: {
    getReceived: state => {
      return state.received
    },
    getPending: state => {
      return state.pending
    },
    getCustomersCounter: state => {
      return state.customersCounter
    },
    getEmployeesCounter: state => {
      return state.employeesCounter
    },
  },
  actions: {
    getStats: ({ commit }) => {
      axios.get('api/get/dashboard/stats')
      .then(res => {
        commit('SET_RECEIVED', res.data.received);
        commit('SET_PENDING', res.data.pending);
        commit('SET_CUSTOMER_COUNTER', res.data.customersCounter);
        commit('SET_EMPLOYEES_COUNTER', res.data.employeesCounter);
      })
    }
  },
}
