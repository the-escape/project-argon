<template>
    <div class="media__item media__item--folder"
         v-on:click="select()">
        <div class="media__asset" style="background-image: url('/argon/assets/img/user.png');"></div>
        <span class="media__name">{{ item.filename | length }}</span>
    </div>
</template>

<script>
    export default {
        props: ['item'],
        methods: {
            select () {
                //
            }
        }
    }
</script>
