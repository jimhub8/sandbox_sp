export default {
    loading(state, payload) {
        state.loading = payload
    },
    error(state, payload) {
        state.error = payload
    },
    alertEvent(state, payload) {
        state.alertEvent = payload
    },
    updateUsersList(state, payload) {
        state.users = payload
    },
    updateRoleList(state, payload) {
        state.roles = payload
    },
    updateShipmentsList(state, payload) {
        state.shipments = payload
    },
    updateBranchesList(state, payload) {
        state.branches = payload
    },
    updateClientList(state, payload) {
        state.clients = payload
    },
    updateCountryList(state, payload) {
        state.countries = payload
    },
    updateRidersList(state, payload) {
        state.riders = payload
    },
    updateStatusList(state, payload) {
        state.statuses = payload
    },
    updateunique_pkg(state, payload) {
        state.unique_pkg = payload
    },

    // Deleted
    updateDeletedClients(state, payload) {
        state.deleted_clients = payload
    },

    // Api
    updateApiStatusItemList(state, payload) {
        state.api_status = payload
    },


    updateCartList(state, payload) {
        state.cart = payload

        var exists = state.cart.some(function (product_1) {
            return product_1.id === payload.id
        });
        if (!exists) {
            payload.ordered = 1
            state.cart.push(payload)
        } else {
            var index = state.cart.indexOf(payload);
            var add_item = (Object.assign({}, payload));
            add_item.ordered += 1
            // console.log(add_item);
            Object.assign(state.cart[index], add_item)
        }
        state.cart = state.cart
    },
}
