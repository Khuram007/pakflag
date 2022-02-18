<template>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li class="menu-title"><span>Main</span></li>
                    <li>
                        <router-link :to="{name: 'dashboard'}"><i data-feather="home"></i> <span>Dashboard</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{name: 'customers'}"><i data-feather="users"></i> <span>Customers</span>
                        </router-link>
                    </li>

                    <li>
                        <router-link :to="{name: 'employees'}"><i data-feather="users"></i> <span>Employee's</span>
                        </router-link>
                    </li>

                    <li>
                        <router-link :to="{name: 'expenses'}"><i data-feather="package"></i> <span>Expenses</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{name: 'clients'}"><i data-feather="package"></i> <span>Clients</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{name: 'received_amount'}"><i data-feather="package"></i> <span>Received Amount</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{name: 'tasks'}"><i data-feather="package"></i> <span>Tasks</span>
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex';

  export default {
    name: 'SideBar',
    methods: {
      ...mapActions({
        authLogout: 'auth/logout',
      }),
      logout () {
        this.authLogout().then((res) => {
          if (this.$route.name !== 'home')
            this.$router.push({
              name: 'home',
            });
        });
      },
    },
    computed: {
      ...mapGetters({
        authCheck: 'auth/authCheck',
        authUser: 'auth/authUser',
      }),
    },
  };
</script>

<style scoped>
    .router-link-exact-active.router-link-active {
        font-weight: bold;
        color: #7638ff;
        text-decoration: revert;
    }
</style>
