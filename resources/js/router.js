import VueRouter from 'vue-router'
import Dashboard from './components/Dashboard'
import Login from './components/auth/Login'
import Customers from './components/customers/Index'
import CustomerDetail from './components/customers/Detail'
import Clients from './components/clients/Index'
import ClientDetail from './components/clients/Detail'
import Expenses from './components/expenses/Index'
import Employees from './components/employees/Index'
import EmployeeDetail from './components/employees/Detail'
import ReceivedAmount from './components/received_amount/Index'
import Tasks from './components/tasks/Index'
import authMiddleware from './middleware/auth'

let router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/login', name: 'login', component: Login,
    },
    {
      path: '/', name: '/', component: Dashboard,
    },
    {
      path: '/dashboard', name: 'dashboard', component: Dashboard,
    },
    {
      path: '/customers', name: 'customers', component: Customers,
    },
    {
      path: '/customer/:id', name: 'customer', component: CustomerDetail,
    },
    {
      path: '/expenses', name: 'expenses', component: Expenses,
    },
    {
      path: '/employees', name: 'employees', component: Employees,
    },
    {
      path: '/employee/:id', name: 'employee', component: EmployeeDetail,
    },
    {
      path: '/clients', name: 'clients', component: Clients,
    },
    {
      path: '/client/:id', name: 'client', component: ClientDetail,
    },
    {
      path: '/received/amount', name: 'received_amount', component: ReceivedAmount,
    },
    {
      path: '/tasks', name: 'tasks', component: Tasks,
    },
  ],
});

// router.beforeEach((to,form,next)=>{
//     if(store.getters['auth/authCheck'])
//         next();
//     else
//         next('/login')
// });

export default router
