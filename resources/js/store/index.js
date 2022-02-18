import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);
import auth from './modules/auth';
import dashboard from './modules/dashboard';
import customers from './modules/customers';
import clients from './modules/clients';
import expenses from './modules/expenses';
import receivedAmount from './modules/receivedAmount';
import employees from './modules/emloyees';
import tasks from './modules/tasks';
// import createMutationsSharer from "vuex-shared-mutations";

export default new Vuex.Store({
    // strict: true,
    modules: {
        auth,
        dashboard,
        customers,
        expenses,
        employees,
        clients,
        receivedAmount,
        tasks
    },
    // plugins: [createMutationsSharer({ predicate: ["studentsModule/add", "studentsModule/delete"] },true)],
});

