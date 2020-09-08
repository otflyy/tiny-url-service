<template>
    <div v-if="this.formShortUrl !== '' || this.$router.push('/')">
        <div class="alert alert-success result" role="alert">
            <strong>Short link:</strong>&nbsp;<router-link :to="this.formShortUrl">{{this.link()}}</router-link>
        </div>
        <div class="alert alert-primary result" role="alert">
            <strong>Statistics:</strong>&nbsp;<router-link :to="'/stat/' + this.formShortUrl">{{this.stat()}}</router-link>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        computed: mapGetters (['formShortUrl']),
        methods: {
            link () {
                return window.location.origin + this.$router.options.base + this.formShortUrl
            },
            stat () {
                return window.location.origin + this.$router.options.base + 'stat/' + this.formShortUrl
            }
        }
    }
</script>