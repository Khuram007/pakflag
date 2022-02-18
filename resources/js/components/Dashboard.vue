<template>
        <div class="content container-fluid">
            <div class="row">
                <div class="col-xl-6 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
									<span class="dash-widget-icon bg-1">
										<i class="fas fa-wallet"></i>
									</span>
                                <div class="dash-count">
                                    <div class="dash-title">Received Amount</div>
                                    <div class="dash-counts">
                                        <p>{{received || 0}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
									<span class="dash-widget-icon bg-2">
										<i class="far fa-credit-card"></i>
									</span>
                                <div class="dash-count">
                                    <div class="dash-title">Pending Amount</div>
                                    <div class="dash-counts">
                                        <p>{{pending || 0}}</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
									<span class="dash-widget-icon bg-3">
										<i class="fas fa-users"></i>
									</span>
                                <div class="dash-count">
                                    <div class="dash-title">Customers</div>
                                    <div class="dash-counts">
                                        <p>{{getCustomersCounter || 0}}</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
									<span class="dash-widget-icon bg-4">
										<i class="fas fa-users"></i>
									</span>
                                <div class="dash-count">
                                    <div class="dash-title">Employees</div>
                                    <div class="dash-counts">
                                        <p>{{employeesCounter || 0}}</p>
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
    import {mapGetters} from 'vuex';
  export default {
    name: 'Dashboard',
    mounted () {
      this.$store.dispatch('dashboard/getStats');
    },
    computed:{
      ...mapGetters({
        received: 'dashboard/getReceived',
        pending: 'dashboard/getPending',
        getCustomersCounter: 'dashboard/getCustomersCounter',
        employeesCounter: 'dashboard/getEmployeesCounter',
      })
    }
  }
</script>

<style scoped>

</style>
