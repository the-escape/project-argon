<template>
    <div class="c-tab-panel active">
        <main class="c-tab-panel__container c-container">
            <div class="c-actions__container">
                <div class="c-actions__content c-tab-panel__inner-container l-full">
                    <h2>Page properties</h2>

                    <p>page name input</p>
                    <p>url slug</p>
                    <p>published switch</p>

                    <hr>
                    <h3>301 Redirects</h3>
                    <p>url redirect (include logic for multiple localisations)</p>

                    <hr>
                    <p>other field groups</p>
                </div>
                <div class="c-actions">
                    <div class="c-actions__group">
                        <button type="submit" class="o-btn o-btn--primary">Save</button>
                        <a href="#pagePreview" class="o-btn" target="_blank">Preview</a>
                        <button type="submit" class="o-btn " data-form-action="#saveDraftAction">Save draft</button>
                        <a href="#cancelPageEdit" class="o-btn ">Cancel</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
export default {

}
</script>
