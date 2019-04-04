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
            if(this.preventDelete){
                new Noty({
                    text: "Before you delete this item, move or remove it's child items",
                    type: 'error',
                    timeout: 3500
                }).show()

                return
            }

            const tree = this.$root.$children[0].$refs.tree
            console.log(tree.nodes.length)

            if(tree.nodes.length === 1 && tree.nodes[0].children.length === 0){
                new Noty({
                    text: "You cannot delete the last item in the tree",
                    type: 'error',
                    timeout: 3500
                }).show()

                return
            }

            tree.remove([this.node.path])
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
            if (+this.node.data.page) {
                return '/admin/pages/'+this.node.data.page+'/preview'
            } else if (this.node.data.url && this.node.data.url !== '') {
                return this.node.data.url
            }

            return false
        },
        preventDelete: function () {
            return this.node.children.length || !this.node.level
        },
        editUrl: function () {
            return argon.root() + '/pages/' + this.node.data.id + '/edit'
        }
    }
}
</script>
