export default {
    loading(state) {
        return state.loading;
    },
    error(state) {
        return state.error;
    },
    alertEvent(state) {
        eventBus.$emit('alertEvent', state)
        // return state.alertEvent;
    },
    users(state) {
        return state.users
    },
    roles(state) {
        return _.orderBy(state.roles, 'name', 'asc')
    },
    shipments(state) {
        return state.shipments
    },
    clients(state) {
        return state.clients
    },
    riders(state) {
        return state.riders
    },
    countries(state) {
        return state.countries
    },
    logs(state) {
        return state.logs
    },
    statuses(state) {
        return state.statuses
    },
    branches(state) {
        return state.branches
    },
}
