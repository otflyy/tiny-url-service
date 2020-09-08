<template>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Link number</th>
                <th>Short link</th>
                <th>Unique clicks per period ( {{this.statTotalPeriod}} )</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(log, index) in this.statTotalLog">
                <td>{{index}}</td>
                <td>{{log.url}}</td>
                <td>{{log.count}}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
    computed: {
        ...mapGetters (['statTotalLog', 'statTotalPeriod'])
    },
    async mounted () {
        await this.getStatTotal()
    },
    methods: {
        ...mapActions(['getStatTotal'])
    }
}
</script>