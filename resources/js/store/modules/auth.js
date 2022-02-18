import axios from 'axios';

export default {
    namespaced: true,
    state: {
        token: null,
        user: null
    },
    getters: {
        authCheck(state) {
            return state.token && state.user;
        },
        authUser(state) {
            return state.user;
        }
    },
    mutations: {
        SET_TOKEN(state, token) {
            state.token = token;
        },
        SET_USER(state, user) {
            state.user = user;
        },
    },
    actions: {
        async login({dispatch}, credentials) {
            let res = await axios.post('/api/login', credentials);
            dispatch('getUser', res.data.data.token)
        },
        async getUser({commit,state}, token) {
            if (token)
                commit('SET_TOKEN', token);
            if (!state.token) return;
            try {
                let res = await axios.get('/api/get/user');
                commit('SET_USER', res.data.data.user);
            } catch (e) {
                commit('SET_TOKEN', null);
                commit('SET_USER', null);
            }
        },
        logout({commit}){
                axios.get('/api/user/logout');
                commit('SET_TOKEN', null);
                commit('SET_USER', null);
        }
    }
}
