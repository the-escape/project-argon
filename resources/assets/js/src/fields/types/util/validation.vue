<template>
    <div class="o-form-status" :class="{ 'has-error': hasError, 'has-success': success}">
        <div class="o-form-status__input">
            <slot></slot>
        </div>
        <div class="o-form-status__message">
            <div class="o-form-status__icon">
                <div class="o-form-status__icon--error" v-if="hasError">
                    <svg><use xlink:href="/images/svgicons.svg#alert"></use></svg>
                </div>
                <div class="o-form-status__icon--success" v-if="success">
                    <svg><use xlink:href="/images/svgicons.svg#success"></use></svg>
                </div>
            </div>
            <div class="o-form-status__message-bar">
                <label :for="inputName">{{ errorMsg }}</label>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['statusError', 'inputName'],
    data () {
        return {
            success: false
        }
    },
    computed: {
        hasError: function () {
            return this.statusError.length
        },
        errorMsg: function () {
            return this.statusError[0]
        }
    }
}
</script>
