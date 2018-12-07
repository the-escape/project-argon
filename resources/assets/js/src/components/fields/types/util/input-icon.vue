<template>
    <div class="o-form-icon">
        <div class="o-form-icon__icon" v-if="preIcon">
            <svg v-if="preIcon && preIcon.svg" xmlns="http://www.w3.org/2000/svg">
                <use :xlink:href="'/argon/images/svgicons.svg#' + preIcon.svg"></use>
            </svg>
            <span v-if="preIcon && preIcon.text">{{preIcon.text}}</span>
        </div>

        <slot></slot>

        <div class="o-form-icon__icon" v-if="postIcon">
            <svg v-if="postIcon && postIcon.svg" xmlns="http://www.w3.org/2000/svg">
                <use :xlink:href="'/argon/images/svgicons.svg#' + postIcon.svg"></use>
            </svg>
            <span v-if="postIcon && postIcon.text">{{postIcon.text}}</span>
        </div>
    </div>
</template>

<script>
export default {
    props: ['preIcon', 'postIcon']
}
</script>
