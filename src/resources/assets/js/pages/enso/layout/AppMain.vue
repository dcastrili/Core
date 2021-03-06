<template>

	<div class="app-main"
		:class="{ 'lights-off': lightsOff }">
		<nprogress></nprogress>
		<navbar class="animated slideInDown"
	        :env-is-local="meta.env === 'local'">
	    </navbar>
	    <sidebar class="animated"
	        :class="{ 'slideInLeft': navbar.isVisible, 'slideOutLeft': !navbar.isVisible }">
	    </sidebar>
	    <section class="main-content">
	        <div class="container is-fluid page-content is-marginless">
	        	<page-header :title="__($route.meta.title)"></page-header>
		        <router></router>
	        </div>
	    </section>
	    <settings class="animated"
	    	:class="{ 'slideInRight': settingsBar.isVisible, 'slideOutRight': !settingsBar.isVisible }">
	    </settings>
	    <app-footer class="animated slideInUp">
	    </app-footer>
   	</div>

</template>

<script>

	import Nprogress from'../../../components/enso/nprogress/Nprogress.vue';
	import Navbar from'./Navbar.vue';
	import Sidebar from'./sidebar/Sidebar.vue';
	import Settings from'./settings/Settings.vue';
	import AppFooter from'./AppFooter.vue';
	import Router from './Router.vue';
	import PageHeader from './PageHeader.vue';
	import { mapState } from 'vuex';
	import { mapGetters } from 'vuex';
	import { mapMutations } from 'vuex';
	import { mapActions } from 'vuex';

	export default {
		name: 'AppMain',

		components: { Nprogress, Navbar, Sidebar, Settings, AppFooter, Router, PageHeader },

		computed: {
			...mapState(['stateLoaded', 'user', 'menus', 'meta']),
			...mapState('layout', ['lightsOff', 'isTablet', 'isMobile', 'navbar', 'settingsBar']),
            ...mapGetters('locale', ['__']),
        },

        watch: {
        	isTablet: {
				handler() {
					return this.isTablet
						? this.$store.commit('layout/navbar/collapse')
						: this.$store.commit('layout/navbar/expand');
				}
			}
        },

		created() {
			if (!this.stateLoaded) {
				this.setState();
			}

			this.$bus.$on('start-impersonating', $event => this.startImpersonating($event));
			this.$bus.$on('stop-impersonating', () => this.stopImpersonating());
			this.$router.replace({ name: this.menus.implicit.link });
		},

		beforeMount () {
			this.addTabletBreakpointListener();
		},

		methods: {
			...mapMutations('layout', ['setThemeParams', 'setIsTablet', 'setIsMobile']),
			...mapActions(['setState']),
			addTabletBreakpointListener() {
				const body = document.body,
					TabletWidth = 1007,
					MobileWidth = 768;

				const handler = () => {
					if (!document.hidden) {
						let rect = body.getBoundingClientRect();
						this.setIsTablet(rect.width <= TabletWidth);
						this.setIsMobile(rect.width <= MobileWidth);
					}
				}

				document.addEventListener('visibilitychange', handler);
				window.addEventListener('DOMContentLoaded', handler);
				window.addEventListener('resize', handler);
			},
			startImpersonating(id) {
	        	axios.get(route('core.impersonate.start', id, false)).then(response => {
	        		toastr.warning(response.data.message);
	        		this.setState();
	        	});
	        },
	        stopImpersonating() {
	        	axios.get(route('core.impersonate.stop', [], false)).then(response => {
	        		toastr.info(response.data.message);
	        		this.setState();
	        	});
	        }
		},

		mounted() {
			this.setThemeParams();
		}
	};

</script>

<style>

	.app-main {
		opacity: 1;
		transition: opacity .25s ease;
	}

	.app-main.lights-off {
		opacity: 0;
	}

	.main-content {
        margin-left: 180px;
        transition: margin .5s ease;
    }

    @media screen and (max-width: 1007px) {
	    .main-content {
		    margin-left: 0;
		}
	}

	div.container.page-content {
        padding: 20px;
    }

</style>