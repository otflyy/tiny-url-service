<template>
    <table v-if="this.statError === '' && this.statCount > 0" class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th v-if="this.statStatus === 1">Image</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="log of this.statLog">
                <td>{{log.id}}</td>
                <td>{{log.date}}</td>
                <td v-if="statStatus === 1">
                    <img :src="pathImg + log.img.url.url" width="200" />
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <strong>Total traffic: {{this.statCount}}</strong>
                </td>
            </tr>
        </tbody>
    </table>
    <Error v-else-if="this.statError !== '' && this.statCount === 0"/>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex'
    import Error from './Error.vue'

    export default {
        components: {
            Error
        },
        computed: {
            pathBase () {
                return this.$router.options.base
            },
            pathImg () {
                return this.pathBase + 'img/'
            },
            pathMethod() {
                return this.pathBase + 'getStat'
            },
            ...mapGetters (['statLog', 'statError', 'statStatus', 'statCount'])
        },
        async mounted () {
            await this.getStat({link: this.$route.params.link, method: this.pathMethod})
        },
        methods: {
            ...mapActions(['getStat'])
        }
    }
</script>