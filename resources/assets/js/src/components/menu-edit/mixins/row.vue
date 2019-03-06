<script>
import { post } from '../../../util'
import Noty from 'noty'
import { Bus } from '../util/bus'

export default {
    mounted() {
        Bus.$on('closeAddForm', this.closeAddForm.bind(this))
        Bus.$on('closeEditForm', this.closeEditForm.bind(this))
    },
    methods: {
        toggleAddForm() {
            this.addFormOpen = !this.addFormOpen
        },
        toggleEditForm(evt) {
            evt.preventDefault()
            this.editFormOpen = !this.editFormOpen
        },
        addItem(item) {
            const tree = this.$root.$children[0].$refs.tree

            tree.insert({
                node: this.node,
                placement: 'inside'
            }, {
                title: item.label,
                data: item
            })

            this.closeAddForm()
        },
        deleteItem() {
            // todo

            if(this.preventDelete){
                new Noty({
                    text: "Before you delete this item, move or remove it's child items",
                    type: 'error',
                    timeout: 3500
                }).show()

                return
            }
        },
        viewError() {
            new Noty({
                text: "TODO",
                type: 'error',
                timeout: 3500
            }).show()
        },
        editItem(item) {
            const tree = this.$root.$children[0].$refs.tree

            tree.updateNode(this.node.path, {data: item})

            this.closeEditForm()
        },
        closeAddForm() {
            this.addFormOpen = false
        },
        closeEditForm() {
            this.editFormOpen = false
        }
    },
    computed: {
        viewUrl: function() {
            // todo
            if(this.node.data.status){
                return '/' + this.node.data.id
            }
        },
        preventDelete: function () {
            return this.node.children.length || !this.node.level
        },
        editUrl: function () {
            // todo
            return argon.root() + '/pages/' + this.node.data.id + '/edit'
        }
    }
}
</script>
