<template>
    <div class="alert alert-danger mb-3" role="alert">
        <strong>{{this.formError || this.linkError || this.statError}}</strong>
    </div>
</template>

<script>

import {mapGetters} from 'vuex'

export default {
  computed: mapGetters (['formError', 'linkError', 'statError']),

}
</script>