import actions from './actions';
import getters from './getters';
import mutations from './mutations';

export default {
    state: {
        loading: false,
        error: [],
        users: [],
        roles: [],
        clients: [],
        riders: [],
        shipments: [],
        countries: [],
        branches: [],
        statuses: [],
        logs: [],
        statusupdates: [],

    },
    getters,
    mutations,
    actions
}
