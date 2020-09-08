export default {
    state: {
        period: '',
        log_total: [],
    },
    actions: {
        async getStatTotal (ctx) {
            try {
                const response = await axios.post("getStatTotal")
                ctx.commit('updateStatTotalPeriod', response.data.period)
                ctx.commit('updateStatTotalLog', response.data.stat_total)
            } catch (error) {
                console.error(error);
            }
        }
    },
    mutations: {
        updateStatTotalPeriod (state, period) {
            state.period = period
        },
        updateStatTotalLog (state, log_total) {
            state.log_total = log_total
        },
    },
    getters: {
        statTotalPeriod (state) {
            return state.period
        },
        statTotalLog (state) {
            return state.log_total
        }
    },
}