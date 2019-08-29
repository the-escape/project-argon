<template>
    <div class="c-page">
        <header class="c-header c-container">
            <div class="c-header__title c-header__title--deep">
                <div class="c-header__local-container">
                    <h1>{{ pageTitle }}<small>{{ pagePath }}</small></h1>
                </div>

                <div class="c-header__btns">
                    <a :href="pageLink" class="o-link" target="_blank">Go to live page</a>
                </div>
            </div>
            <div class="c-header__nav c-tab__nav">
                <ul>
                    <template v-for="tab in tabs">
                        <li :key="tab.path" v-if="showTab(tab)">
                            <router-link :to="tab.path" class="c-tab__btn" :class="{ active: currentTab === tab.path }">
                                <div class="c-tab__btn-container">
                                    <span>{{ tab.name }}</span>
                                    <svg v-if="tab.showAlert"><use xlink:href="/argon/images/svgicons.svg#alert"></use></svg>
                                </div>
                            </router-link>
                        </li>
                    </template>
                </ul>
            </div>
        </header>

        <div class="c-tab-panel__list">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex'

export default {
    data() {
        return {
            revisionTab: {
                name: 'revisions',
                path: '/revisions',
                showAlert: false
            },
            baseTabs: [
                {
                    name: 'Page content',
                    path: '/'
                },
                {
                    name: 'page properties',
                    path: '/edit/page-properties'
                }
            ],
            currentTab: '/'
        }
    },
    created() {
        this.$store.dispatch('blockSelect/getPageGroups', this.pageID)
        this.$store.dispatch('page/setPageRevisions', this.pageID)
        this.currentTab = this.$route.path
    },
    watch: {
        '$route' (to, from) {
            this.currentTab = to.path
        }
    },
    computed: {
        ...mapState('blockSelect', ['tabGroups', 'renderingGroups']),
        ...mapState('page', ['pageID', 'pageTitle', 'pagePath', 'pageLink']),
        renderingGroupTabs: function () {
            return this.renderingGroups.map(el => {
                el.path = '/edit/' + el.id
                el.isGroup = true
                return el
            })
        },
        tabGroupTabs: function() {
            return this.tabGroups.map(el => {
                el.path = '/edit/' + el.id
                return el
            })
        },
        tabs: function() {
            return [...this.baseTabs, ...this.renderingGroupTabs, ...this.tabGroupTabs, this.revisionTab]
        }
    },
    methods: {
        showTab(tab) {
            if(!tab.isGroup){
                return true
            }

            return tab.path === this.currentTab
        }
    }
}
</script>
