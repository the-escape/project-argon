<template>
    <div class="l-container l-full">
        <h1>{{msg}}</h1>
        <pre>{{ groups }}</pre>
    </div>
</template>

<script>
export default {
    data () {
        return {
            msg: 'hello world',
            groups: []
        }
    },
    created: function () {
        this.groups = window.groups
    }
}
</script>
