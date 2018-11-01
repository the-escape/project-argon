<template>
    <div>
        <div class="example">{{ msg }}</div>
        <child test-msg="testing prop"></child>
    </div>
</template>

<script>
import child from './child.vue'

export default {
    components: {
        child
    },
    data () {
        return {
            msg: 'Hello world!'
        }
    }
}
</script>

<style>
.example {
    color: red;
}
</style>
