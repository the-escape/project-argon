<template>
    <div class="l-container l-full o-form">
        <p>
            Lastname: {{ userState.lastname }}<br />
            Firstname: {{ userState.firstname }}
        </p>
        <p>
            {{ userState }}
        </p>
        <input v-model="userState.lastname" />
        <input v-model="userState.firstname" />
    </div>
</template>

<script>
export default {
    computed: {
        userState() {
            return this.$store.state.user
        }
    },
    watch: {
        userState: {
            handler: function (user) {
                this.$store.commit('updateUser', user);
            }, deep: true
        }
    }
}
</script>
