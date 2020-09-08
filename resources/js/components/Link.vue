<template>
    <div>
        <div v-if="this.linkError === '' && this.linkLink !== ''">
            <h1>You will be redirected to the link in <span class="badge badge-secondary">{{this.timer}}</span> seconds.</h1>
            <img v-if="this.linkImg !== ''" :src="this.pathName + this.linkImg" width="200" />
        </div>
        <Error v-else/>
    </div>
</template>

<script>
    import {mapGetters, mapActions, mapMutations} from 'vuex'
    import Error from './Error.vue'

    export default {
        data () {
            return {
                timer: 5
            }
        },
        components: {
            Error
        },
        computed: {
            pathName () {
                return this.$router.options.base + 'img/'
            },
            ...mapGetters (['linkError', 'linkImg', 'linkLink', 'linkUrl', 'linkLogId', 'linkUserHash'])
        },
        async mounted () {
            await this.getLink(this.$route.params.link)

            if (this.linkError === '') {
                this.setUserLog({ log: this.linkLogId, user: this.linkUserHash })

                const int_id = setInterval( () => {
                    this.timer--

                    if (this.timer === 0) {
                        clearInterval(int_id)
                        window.location.replace(this.linkUrl);
                    }
                } , 1000)
            }
        },
        methods: {
            ...mapActions(['getLink', 'setUserLog'])
        }
    }
</script>