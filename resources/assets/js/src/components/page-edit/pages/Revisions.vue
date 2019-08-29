<template>
    <div class="c-tab-panel active">
        <main class="c-tab-panel__container c-container">
            <div class="c-actions__container">
                <div class="c-actions__content c-tab-panel__inner-container l-full">
                    <h2>Revisions ({{ revisionTotal }})</h2>

                    <div class="l-space" v-if="isEditingCurrentRevision">
                        <p><span class="o-icon o-icon--danger"><svg><use xlink:href="/argon/images/svgicons.svg#alert"></use></svg></span> You're editing a {{ currentRevision.status == 1 ? 'draft' : 'revision' }} created by {{ currentRevision.user.name }} {{ currentRevision.created_at }}. If you want to edit the published version of the page, please click <a href="#editLocalLink">here</a>.</p>
                        <!-- class="confirm" data-confirm="This will discard any unsaved changes and take you back to published revision.\nYou can save changes as another revision without affecting live page by clickin 'Save Revision' button.\nAre you sure you want to continue?" -->
                    </div>

                    <div class="o-table o-table--max-content--6 l-full">
                        <div class="o-table__header o-table--center">ID</div>
                        <div class="o-table__header">Status</div>
                        <div class="o-table__header">Created At</div>
                        <div class="o-table__header o-table--center">Created By</div>
                        <div class="o-table__header o-table--end">Actions</div>
                        <div class="o-table__header o-table--center"></div>
                    </div>

                        <div v-for="revision in revisions" :key="revision.id" class="o-table o-table--max-content--6 l-full">
                            <div class="o-table__data o-table--center"
                                :class="{
                                    'o-table__data--green': isCurrentRevision(revision.id),
                                    'o-table__data--green': isPublishedRevision(revision.id)
                                }">
                                {{ revision.id }}
                            </div>
                            <div class="o-table__data"
                                :class="{
                                    'o-table__data--green': isCurrentRevision(revision.id),
                                    'o-table__data--green': isPublishedRevision(revision.id)
                                }">
                                <strong v-if="isCurrentRevision(revision.id)">Editing <span v-if="revision.status != 5">-&nbsp;</span></strong>
                                <span v-if="revision.status != 5">{{ revision.statusName }}</span>
                            </div>
                            <div class="o-table__data"
                                :class="{
                                    'o-table__data--green': isCurrentRevision(revision.id),
                                    'o-table__data--green': isPublishedRevision(revision.id)
                                }">
                                {{ formatDate(revision.createdAt) }}
                            </div>
                            <div class="o-table__data o-table--center"
                                :class="{
                                    'o-table__data--green': isCurrentRevision(revision.id),
                                    'o-table__data--green': isPublishedRevision(revision.id)
                                }">
                                {{ revision.user.name }}
                            </div>
                            <div class="o-table__data o-table--end"
                                :class="{
                                    'o-table__data--green': isCurrentRevision(revision.id),
                                    'o-table__data--green': isPublishedRevision(revision.id)
                                }">
                                <div class="o-confirm-btn__container">
                                    <div class="o-confirm-btn__questions">

                                        <a v-if="isCurrentRevision(revision.id)" href="#editLocal" class="o-confirm-btn">
                                            <!-- class="o-confirm-btn confirm" data-balloon="Load/edit revision" data-confirm="This will load and allow editing the selected revision from {{ formatDate(revision.createdAt) }} saved by user: {{ $revision->user->name }} without affecting published page unless 'Save and Publish' button clicked.\nYou can load and edit and click 'Save Revision' to capture as new snapshot for further checks and review without impact on live - published page.\nAre you sure you want to continue?" -->
                                            <svg><use xlink:href="/argon/images/svgicons.svg#edit"></use></svg>
                                        </a>
                                        <button v-else class="o-confirm-btn o-confirm-btn--fade" disabled>
                                            <svg><use xlink:href="/argon/images/svgicons.svg#edit"></use></svg>
                                        </button>

                                        <a href="#previewLink" class="o-confirm-btn" data-balloon="Preview revision" target="_blank">
                                            <svg><use xlink:href="/argon/images/svgicons.svg#see"></use></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="o-table__data o-table--center"
                                :class="{
                                    'o-table__data--green': isCurrentRevision(revision.id),
                                    'o-table__data--green': isPublishedRevision(revision.id)
                                }">
                                <a v-if="isPublishedRevision(revision.id)" href="#publishedPreview" class="o-btn o-btn--primary o-btn--xs confirm">Publish</a>
                                <!-- data-confirm="This will overwrite current page content.\nSelected revision is from {{ formatDate(revision.createdAt) }}.\nAre you sure you want to continue?" -->
                            </div>
                        </div>


                    <p>pagination</p>

                </div>

                <div class="c-actions">
                    <div class="c-actions__group">
                        <button type="submit" class="o-btn o-btn--primary js-tab-btn" data-tab="page-content">Back</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import { mapState } from 'vuex'
import { format } from 'date-fns'

export default {
    computed: {
        ...mapState('page', ['pageID', 'currentRevisionID', 'publishedRevisionID', 'revisions']),
        revisionTotal: function() {
            return this.revisions.length
        },
        isEditingCurrentRevision: function() {
            return this.currentRevisionID === this.publishedRevisionID
        },
        currentRevision: function() {
            return this.revisions.find(rev => rev.id === this.currentRevisionID)
        }
    },
    methods: {
        isCurrentRevision: function(revisionID) {
            return revisionID === this.currentRevisionID;
        },
        isPublishedRevision: function(revisionID) {
            return revisionID === this.publishedRevisionID;
        },
        formatDate: function(date, formatStr = 'DD/MM/YYYY HHH:MM:SS') {
            return format(new Date(date), formatStr);
        }
    }
}
</script>
