<template>

	<section class="hero login is-fullheight is-primary is-bold">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-mobile is-centered">
                	<router-view
                		:app-name="appName">
	        		</router-view>
                </div>
            </div>
        </div>
    </section>

</template>

<script>

	import Router from '../layout/Router.vue';

	export default {
		name: 'Auth',

		components: { Router },

		data() {
			return {
				appName: ''
			}
		},

		created() {
			axios.get(route('appName').toString()).then(({ data }) => {
				this.appName = data;
			});
		},

		mounted() {
			if (this.$route.path === '/') {
				this.$router.replace({ path: '/login' });
			}
		}
	};

</script>

<style>

	.box.login {
		 max-width: 400px;
	}

	figure.logo {
	    display: inline-block;
	}

</style>