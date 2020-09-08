import Vue from 'vue'
import Vuex from 'vuex'
import form from './modules/form'
import link from './modules/link'
import statistics from './modules/statistics'
import statistics_totall from './modules/statistics_totall'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        form,
        link,
        statistics,
        statistics_totall
    }
})