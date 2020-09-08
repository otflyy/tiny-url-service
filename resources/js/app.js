/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import 'bootstrap'
import '../sass/app.scss'

// window.Vue = require('vue')
import Vue from 'vue'
import VueRouter from "vue-router"
// import Vuex from "vuex"
import Vuelidate from 'vuelidate'

import { library } from '@fortawesome/fontawesome-svg-core'
import { faUserSecret } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(faUserSecret)
Vue.component('font-awesome-icon', FontAwesomeIcon)

Vue.config.productionTip = false

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import App from './components/App'
import Form from './components/Form'
import Statistics from './components/Statistics'
import StatisticsTotal from './components/StatisticsTotal'
import Alert from './components/Alert'
import Link from './components/Link'

import store from './store'

Vue.use(VueRouter);
Vue.use(Vuelidate);

const routes = [
					{ path: '/', component: Form },
					{ path: '/links', component: Alert },
					{ path: '/stat', component: StatisticsTotal },
					{ path: '/stat/:link', component: Statistics },
					{ path: '/:link', component: Link },
				]
const router = new VueRouter({
	mode: 'history',
	base: '/tiny_url/public/',
	routes
})

window.onload = function () {
	new Vue({
		store,
		router,
		render: h => h(App)
	}).$mount('#app')
}
