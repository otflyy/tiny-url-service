export default {
    state: {
        link: '',
        error: '',
        img: '',
        url: '',
        user_hash: '',
        log_id: ''
    },
    actions: {
        async getLink (ctx, link = '') {
            try {
                const sec = 300 /* Short link activity time in seconds */
                const response = await axios.post("getLink", {link, sec})
                ctx.commit('updateLinkError', response.data.error)
                ctx.commit('updateLink', response.data.error === '' ? link : '')
                ctx.commit('updateImg', response.data.img)
                ctx.commit('updateLinkUrl', response.data.url)
                ctx.commit('updateLogId', response.data.log)
                ctx.commit('updateUserHash', response.data.user_hash)
            } catch (error) {
                console.error(error);
            }
        },
        async setUserLog (ctx, data) {
            try {
                await axios.post("setUserLog", data)

            } catch (error) {
                console.error(error);
            }
        }
    },
    mutations: {
        updateLink (state, link) {
            state.link = link
        },
        updateLinkError (state, error) {
            state.error = error
        },
        updateImg (state, img) {
            state.img = img
        },
        updateLinkUrl (state, url) {
            state.url = url
        },
        updateLogId (state, log) {
            state.log_id = log
        },
        updateUserHash (state, user_hash) {
            if (document.cookie.indexOf('user_hash') !== -1) {
                for ( const el of document.cookie.split(";") ) {
                    if (el.split("=")[0] === 'user_hash')
                        state.user_hash = el.split("=")[1]
                }
            }
            else {
                state.user_hash = user_hash
                document.cookie = "user_hash=" + user_hash
            }
        }
    },
    getters: {
        linkError (state) {
            return state.error
        },
        linkLink (state) {
            return state.link
        },
        linkImg (state) {
            return state.img
        },
        linkUrl (state) {
            return state.url
        },
        linkLogId (state) {
            return state.log_id
        },
        linkUserHash (state) {
            return state.user_hash
        }
    },
}