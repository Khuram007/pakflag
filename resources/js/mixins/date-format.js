import moment from 'moment'

export default {
  methods: {
    formatDate (date) {
      return moment(date).format('MMMM Do YYYY')
    },
  },
}
