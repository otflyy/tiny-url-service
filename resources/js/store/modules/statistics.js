export default {
    state: {
        error: '',
        log: [],
        status: null,
        count: 0
    },
    actions: {
        async getStat (ctx, opt = {}) {
            try {
                const response = await axios.post(opt.method, opt)
                ctx.commit('updateStatError', response.data.error)
                ctx.commit('updateStatLog', response.data.list.log)
                ctx.commit('updateStatStatus', response.data.list.status)
                ctx.commit('updateStatCount', response.data.list.log.length)
            } catch (error) {
                console.error(error);
            }
        }
    },
    mutations: {
        updateStatError (state, error) {
            state.error = error
        },
        updateStatLog (state, log) {
            state.log = log
        },
        updateStatStatus (state, status) {
            state.status = status
        },
        updateStatCount (state, count) {
            state.count = count
        },
    },
    getters: {
        statError (state) {
            return state.error
        },
        statLog (state) {
            return state.log
        },
        statStatus (state) {
            return state.status
        },
        statCount (state) {
            return state.count
        }
    },
}