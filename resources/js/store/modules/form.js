export default {
    state: {
        url: '',
        tiny_url: '',
        commercial: false,
        error: ''
    },
    actions: {
        async setUrl () {
            try {
                return await axios.post("setUrl", this.getters.formState)

            } catch (error) {
                console.error(error);
            }
        },
    },
    mutations: {
        updateUrl (state, event) {
            state.url = event.target.value.replace(/\s+/g, "")
        },
        updateShortUrl (state, event) {
            state.tiny_url = event.target.value.substr(0, 100).replace(/[&\/\\#,$~%=.'`":*?<>{}\s+]/g, "")
        },
        updateCommercial (state, event) {
            state.commercial = event.target.checked
        },
        updateError (state, error) {
            state.error = error
        }
    },
    getters: {
        formState (state) {
            return state
        },
        formUrl (state) {
            return state.url
        },
        formShortUrl (state) {
            return state.tiny_url
        },
        formCommercial (state) {
            return state.commercial
        },
        formError (state) {
            return state.error
        }
    }
}