<template>

    <div class="level">
        <div class="level-left">
            <div class="level-item">
                {{ title }}
            </div>
        </div>
        <div class="level-right">
            <div class="level-item">
            	<div class="dropdown is-right"
                    :class="{ 'is-active': show }"
                    @click="show=!show">
                    <div class="dropdown-trigger">
                        <button class="button theme-selector"
                            aria-haspopup="true"
                            aria-controls="dropdown-menu">
                            <span>{{ theme }}</span>
                            <span class="icon angle is-small"
                                 :aria-hidden="show">
                                <i class="fa fa-angle-up"></i>
                            </span>
                        </button>
                    </div>
                    <div class="dropdown-menu" role="menu">
                        <div class="dropdown-content theme-list has-text-centered">
                        	<a v-for="(href, key) in themes"
                        		class="dropdown-item"
                                :class="{ 'is-active': key === theme }"
                                @click="update(key)">
                        		{{ key }}
                        	</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>


<script>

    import { mapState } from 'vuex';
    import { mapGetters } from 'vuex';
    import { mapActions } from 'vuex';

	export default {
		name: 'ThemeSelector',

        props: {
            title: {
                type: String,
                required: true
            }
        },

        computed: {
            ...mapState('layout', ['themes']),
            ...mapGetters('layout', ['theme'])
        },

		data() {
			return {
				show: false,
			}
		},

        methods: {
            ...mapActions('layout', ['switchTheme']),
            update(theme) {
                if (theme === this.theme) {
                    return false;
                }

                this.switchTheme(theme);
                this.$emit('update');
            }
        }
	};

</script>

<style>

    .dropdown-content.theme-list {
        max-height: 185px;
        overflow-y: auto;
    }
</style>