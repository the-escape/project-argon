<template>
    <div>
        <div class="o-multi">
            <div class="o-multi__track">
                <draggable v-model="users" :options="{ group: { pull:true, put:true }, animation: 150, handle: '.js-multi-drag' }">
                    <div class="o-multi__item" v-for="user in users" :key="user.id">
                        <div class="o-multi__item-wrap">
                            <button class="o-multi__drag-handle js-multi-drag">
                                <div class="o-multi__drag-wrap">
                                    <svg>
                                        <use xlink:href="/argon/images/svgicons.svg#reorder"></use>
                                    </svg>
                                </div>
                            </button>

                            <input type="text" :value="user.firstname" v-on:keyup.stop="updateField('firstname', $event.target.value, user.id)">
                            <input type="text" :value="user.lastname" v-on:keyup.stop="updateField('lastname', $event.target.value, user.id)">
                        </div>
                    </div>
                </draggable>
                <div class="o-multi__foot" slot="footer">
                    <button v-on:click="addValue" class="o-btn o-btn--sm">Add</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import draggable from 'vuedraggable'

export default {
    props: ['fieldid'],
    components: {
        draggable
    },
    computed: {
        'users': {
            get () {
                const field = this.$store.state.fields.filter(field => field.id == this.fieldid)
                if(field.length){
                    return field[0].users
                }
                return  []
            },
            set (users) {
                this.$store.commit('updateUsers', {
                    fieldID: this.fieldid,
                    users
                })
            }
        }
    },
    methods: {
        updateField: function(field, value, userID){
            this.$store.commit('updateUser', {
                fieldID: this.fieldid,
                userID,
                user: {
                    [field]: value
                }
            })
        },
        addValue: function(){
            this.$store.commit('addUser', {
                fieldID: this.fieldid,
                user: {
                    lastname: '',
                    firstname: ''
                }
            })
        }
    }
}
</script>
