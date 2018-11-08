<template>
    <div class="l-container l-full o-form">
        <pre>{{ fields }}</pre>
        <div v-for="field in fields" :key="field.id">
            <users :users="field.users" :fieldid="field.id" />
        </div>
    </div>
</template>

<script>
import users from './Users.vue'

export default {
    components: {
        users
    },
    computed: {
        fields() {
            return this.$store.state.fields
        }
    },
    // watch: {
    //     userState: {
    //         handler: function (user) {
    //             this.$store.commit('updateUser', user);
    //         }, deep: true
    //     }
    // }
}
</script>
