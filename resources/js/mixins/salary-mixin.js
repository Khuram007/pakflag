import moment from 'moment'

export default {
  data(){
    return {
      perDayWorkingHours: 10,
    }
  },
  methods: {
    getCurrentMonthDeductions (salaries) {
      return salaries?.reduce((a, b) => a + (b['deduction'] || 0), 0);
    },
    getCurrentMonthOverTime (salaries) {
      return salaries?.reduce((a, b) => a + (b['overtime'] || 0), 0);
    },
    getCurrentMonthAdvanceSalaries (advanceSalaries) {
      return advanceSalaries?.reduce((a, b) => a + (b['amount'] || 0), 0);
    },
    getCurrentMonthSalary (monthlySalary,hourlyRate, salaries,advanceSalaries) {
      let currentMonthHours = 30 * this.perDayWorkingHours;
      let salary = ((this.getCurrentMonthOverTime(salaries) + currentMonthHours) - this.getCurrentMonthDeductions(salaries)) * (+hourlyRate);
      return (salary-this.getCurrentMonthAdvanceSalaries(advanceSalaries)).toFixed(2);
    },
    convertSalaryToHourly(salary){
      return (+salary/30/10).toFixed(2) || 0;
    }
  },
}
