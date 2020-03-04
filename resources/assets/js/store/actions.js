import axios from "axios";
export default {
    alertEvent(context, payload) {
        eventBus.$emit('alertRequest', payload)
        // context.commit('alertEvent', payload)
    },

    errorEvent(context, payload) {
        eventBus.$emit('errorEvent', payload)
        // context.commit('alertEvent', payload)
    },

    // GET
    getUsers(context) {

        context.commit('error', [])
        context.commit('loading', true)
        axios.get('users').then((response) => {
            context.commit('loading', false)
            context.commit('updateUsersList', response.data)
        }).catch((error) => {
            context.commit('loading', false)
            if (error.response.status === 500) {
                eventBus.$emit('errorEvent', error.response.statusText)
                return
            } else if (error.response.status === 401 || error.response.status === 409) {
                eventBus.$emit('reloadAppRequest', error.response.statusText)
            } else if (error.response.status === 422) {
                eventBus.$emit('errorEvent', error.response.data.message + ': ' + error.response.statusText)
            }
            context.commit('error', error.response.data.errors)
        })
    },

    getRoles(context) {

        context.commit('error', [])
        context.commit('loading', true)
        axios.get('roles').then((response) => {
            context.commit('loading', false)
            context.commit('updateRoleList', response.data)
        }).catch((error) => {
            if (error.response.status === 500) {
                eventBus.$emit('errorEvent', error.response.statusText)
                return
            } else if (error.response.status === 401 || error.response.status === 409) {
                eventBus.$emit('reloadAppRequest', error.response.statusText)
            } else if (error.response.status === 422) {
                eventBus.$emit('errorEvent', error.response.data.message + ': ' + error.response.statusText)
            }
            context.commit('loading', false)
            context.commit('error', error.response.data.errors)
        })
    },

    filterItems(context, payload) {
        var model = payload.url
        var data = payload.data
        var list = payload.list
        // console.log(payload.url);
        context.commit('loading', true)
        axios.post(model, data).then((response) => {
            console.log(response);

            context.commit('loading', false)
            context.commit(list, response.data)
        }).catch((error) => {
            console.log(error);

            context.commit('loading', false)
            if (error.response.status === 500) {
                eventBus.$emit('errorEvent', error.response.statusText)
                return
            } else if (error.response.status === 401 || error.response.status === 409) {
                eventBus.$emit('reloadAppRequest', error.response.statusText)
            } else if (error.response.status === 422) {
                eventBus.$emit('errorEvent', error.response.data.message + ': ' + error.response.statusText)
            }
            context.commit('error', error.response.data.errors)
        })
    },

    getItems(context, payload) {
        var model = payload.url
        var update_ = payload.list
        context.commit('loading', true)
        axios.get(model).then((response) => {
            context.commit('loading', false)
            context.commit(update_, response.data)
        }).catch((error) => {
            context.commit('loading', false)
            if (error.response.status === 500) {
                eventBus.$emit('errorEvent', error.response.statusText)
                return
            } else if (error.response.status === 401 || error.response.status === 409) {
                eventBus.$emit('reloadAppRequest', error.response.statusText)
            } else if (error.response.status === 422) {
                eventBus.$emit('errorEvent', error.response.data.message + ': ' + error.response.statusText)
            }
            context.commit('error', error.response.data.errors)
        })
    },


    searchItems(context, payload) {
        var model = payload.url
        var update_ = payload.list
        context.commit('loading', true)
        axios.get(model).then((response) => {
            context.commit('loading', false)
            context.commit(update_, response.data)
        }).catch((error) => {
            context.commit('loading', false)
            if (error.response.status === 500) {
                eventBus.$emit('errorEvent', error.response.statusText)
                return
            } else if (error.response.status === 401 || error.response.status === 409) {
                eventBus.$emit('reloadAppRequest', error.response.statusText)
            } else if (error.response.status === 422) {
                eventBus.$emit('errorEvent', error.response.data.message + ': ' + error.response.statusText)
            }
            context.commit('error', error.response.data.errors)
        })
    },

    nextPage(context, payload) {

        // console.log(payload);
        var data = payload.data
        var path = payload.path
        var page = payload.page
        var update_ = payload.list
        context.commit('loading', true)
        axios.post(path + `?page=` + page, data)
            .then((response) => {
                // console.log(response.data);
                context.commit('loading', false)
                context.commit(update_, response.data)
            }).catch((error) => {
                // console.log(error);

                context.commit('loading', false)
                if (error.response.status === 500) {
                    eventBus.$emit('errorEvent', error.response.statusText)
                    return
                } else if (error.response.status === 401 || error.response.status === 409) {
                    eventBus.$emit('reloadAppRequest', error.response.statusText)
                } else if (error.response.status === 422) {
                    eventBus.$emit('errorEvent', error.response.data.message + ': ' + error.response.statusText)
                    context.commit('error', error.response.data.errors)
                    return
                } else {
                    context.commit('error', error.response.data.errors)
                }
            })
    },




    // Delete
    deleteItem(context, payload) {
        context.commit('loading', true)
        axios.delete(payload).then((response) => {
            context.commit('loading', false)
        }).catch((error) => {
            context.commit('loading', false)
            if (error.response.status === 500) {
                eventBus.$emit('errorEvent', error.response.statusText)
                return
            } else if (error.response.status === 401 || error.response.status === 409) {
                eventBus.$emit('reloadAppRequest', error.response.statusText)
            } else if (error.response.status === 422) {
                eventBus.$emit('errorEvent', error.response.data.message + ': ' + error.response.statusText)
            }
            context.commit('error', error.response.data.errors)
        })
    },



    addCart(state, payload) {
        // console.log(state.cart);

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
        return state.cart
        context.commit('updateCartList', state.cart)
    },

    // Post Items
    postItems(context, payload) {
        context.commit('error', [])
        return new Promise((resolve, reject) => {
            // console.log('payloadp', payload);
            var model = payload['url']
            var data = payload['data']
            // console.log(data);
            // var update_ = payload['update_list']
            context.commit('loading', true)
            axios.post(model, data).then((response) => {
                // console.log(response);
                context.commit('loading', false)
                // return 'success'
                resolve(response)
                // console.log(response.data);
                // context.commit(update_, response.data)
            }).catch((error) => {
                // console.log(error);
                reject(error)
                context.commit('loading', false)
                if (error.response.status === 500 || error.response.status === 405) {
                    eventBus.$emit('errorEvent', error.response.statusText)
                    return
                } else if (error.response.status === 401 || error.response.status === 409) {
                    eventBus.$emit('reloadAppRequest', error.response.statusText)
                } else if (error.response.status === 422) {
                    eventBus.$emit('errorEvent', error.response.data.message + ': ' + error.response.statusText)
                    context.commit('error', error.response.data.errors)
                }
                return 'error'
                // context.commit('error', error.response.data.errors)
            })
        })
    },


    // Patch Items
    patchItems(context, payload) {
        // console.log(payload);
        context.commit('error', [])

        var model = payload['url']
        var data = payload['data']
        context.commit('loading', true)
        axios.patch(model, data).then((response) => {
            eventBus.$emit('alertRequest', 'Updated')
            context.commit('loading', false)
        }).catch((error) => {
            context.commit('loading', false)
            if (error.response.status === 500 || error.response.status === 405) {
                eventBus.$emit('errorEvent', error.response.statusText)
                return
            } else if (error.response.status === 401 || error.response.status === 409) {
                eventBus.$emit('reloadAppRequest', error.response.statusText)
            } else if (error.response.status === 422) {
                eventBus.$emit('errorEvent', error.response.data.message + ': ' + error.response.statusText)
            }
            context.commit('error', error.response.data.errors)
        })
    },

    checkUser(context, payload) {
        // console.log(payload);
        var model = payload.url
        // context.commit('loading', true)
        axios.get(model).then((response) => {
            console.log(response.data);

            if (response.data == 'logged_out') {
                window.location.reload()
            }
            // context.commit('loading', false)
        }).catch((error) => {
            context.commit('loading', false)
            if (error.response.status === 500 || error.response.status === 405) {
                eventBus.$emit('errorEvent', error.response.statusText)
                return
            } else if (error.response.status === 401 || error.response.status === 409) {
                eventBus.$emit('reloadAppRequest', error.response.statusText)
            } else if (error.response.status === 422) {
                eventBus.$emit('errorEvent', error.response.data.message + ': ' + error.response.statusText)
            }
            context.commit('error', error.response.data.errors)
        })
    },
}
