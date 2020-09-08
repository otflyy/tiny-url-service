<template>
    <div>
        <Error v-if="this.formError !== ''"/>
        <div class="form-group" :class="{ 'form-group--error' : ( $v.url.$invalid && !$v.url.url ) || ( $v.url.$invalid && $v.url.$dirty ) || ( $v.url.$dirty && !$v.url.url )}">
            <input
                    type="url"
                    v-model="url"
                    @input="changeUrl"
                    class="form-control form__input"
                    autocomplete="off"
                    placeholder="URL"
            >
            <div class="invalid-feedback">Invalid URL</div>
        </div>
        <div class="form-group" :class="{ 'form-group--error' : ( $v.tiny_url.$invalid && !$v.tiny_url.minLength ) || ( $v.tiny_url.$invalid && $v.tiny_url.$dirty ) || ( $v.tiny_url.$dirty && !$v.tiny_url.minLength)}">
            <input
                    type="text"
                    v-model="tiny_url"
                    @input="changeShortUrl"
                    class="form-control form__input"
                    autocomplete="off"
                    placeholder="Your short link"
            >
            <small class="form-text text-muted">Maximum of 100 characters</small>
            <div class="invalid-feedback">Use 4 characters or more</div>
        </div>
        <div class="form-group form-check">
            <input
                    type="checkbox"
                    class="form-check-input"
                    id="commercial"
                    @change="changeCommercial"
            >
            <label class="form-check-label" for="commercial">Commercial link</label>
        </div>
        <button type="button" @click="submitHandler" class="btn btn-success" >Shorten</button>
    </div>
</template>

<script>

    import { required, minLength, url } from 'vuelidate/lib/validators'
    import {mapGetters, mapActions, mapMutations} from 'vuex'

    import Error from './Error.vue'

    export default {
        computed: mapGetters (['formState', 'formUrl', 'formShortUrl', 'formCommercial', 'formError']),
        components: {
            Error,
        },
        data () {
            return {
                url: '',
                tiny_url: ''
            }
        },
        validations: {
            url: {
                url,
                required,
            },
            tiny_url: {
                minLength: minLength(4),
                required,
            },
        },
        methods: {
            changeUrl (event) {
                this.updateUrl (event)
                this.url = this.formUrl
            },
            changeShortUrl (event) {
                this.updateShortUrl (event)
                this.tiny_url = this.formShortUrl
            },
                changeCommercial (event) {
                this.updateCommercial (event)
            },
            async submitHandler () {
                if (this.$v.$invalid) {
                    this.$v.$touch()
                    return false
                }

                const response = await this.setUrl()

                this.updateError(response.data.error === undefined ? '' : response.data.error)

                if ( response.data.error === undefined )
                    this.$router.push({ path: "links"})

            },
            ...mapActions(["setUrl"]),
            ...mapMutations(['updateUrl', 'updateShortUrl', 'updateCommercial', 'updateError'])
        }
    }
</script>

<style>
    .form-group--error input, .form-group--error input:focus{
        border-color: #dc3545;
    }
    .form-group--error input:focus{
        box-shadow: 0 0 0 3px #f6ccd0;
    }
    .form-group--error .invalid-feedback {
        display:block;
    }
    .form-group--error .text-muted {
        display:none;
    }
</style>