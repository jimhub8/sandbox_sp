import actions from './actions';
import getters from './getters';
import mutations from './mutations';

export default {
    state: {
        loading: false,
        error: null,
        users: [],
        roles: [],
        clients: [],
        riders: [],
        shipments: [],
        countries: [],
        branches: [],
        statuses: [],
        logs: [],

    },
    getters,
    mutations,
    actions
}
