<template>
    <div class="o-modal__container" :class="{ 'active': options.isOpen }" @click.prevent="close">
        <div class="o-modal" :class="{ 'active': options.isOpen }" @click.stop>
            <div class="o-modal__content typography h-text--centre">
                <h1>{{ options.title }}</h1>
                <p>{{ options.message }}</p>
                <button class="o-btn o-btn--primary" @click.prevent="accept">
                    <span>Accept</span>
                </button>
                 &nbsp;
                <button class="o-btn" @click.prevent="close">
                    <span>Close</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['options'],
    methods: {
        accept() {
            this.options.res()
        },
        close() {
            this.options.rej()
        }
    }
}
</script>
