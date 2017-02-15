<template>
    <div class="media__grid col-xs-3 col-sm-3 col-md-2 col-lg-2">
        <div class="media__item media__item--folder">
            <div class="media__asset">
                <img src="/argon/assets/img/icons/folder.png" width="100%">
            </div>
            <span class="media__name">{{ folder.name }}</span>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['folder']
    }
</script>

<style>
    @media (min-width: 992px) {
        .media__grid:nth-child(6n+7) {
            clear: left;
        }
    }
    @media (max-width: 992px) {
        .media__grid:nth-child(4n+5) {
            clear: left;
        }
    }
    .media__item {
        text-align: center;
        margin-bottom: 50px;
        line-height: 16px;
    }
    .media__asset {
        display: block;
        margin-bottom: 15px;
    }
</style>
