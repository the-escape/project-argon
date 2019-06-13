<script>
import { post } from '../../../util'
import Noty from 'noty'
import { Bus } from '../util/bus'

export default {
    mounted() {
        Bus.$on('closeAddForm', this.closeAddForm.bind(this))
    },
    methods: {
        toggleAddForm() {
            this.addFormOpen = !this.addFormOpen
        },
        addItem(typeid) {
            window.location.href = argon.root() + '/pages/' + this.node.data.id + '/addchild/' + typeid
        },
        duplicateItem() {

            const token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')

            const pageName = this.node.title

            post(argon.root() + '/pages/' + this.node.data.id + '/clone', {
                _token: token,
                _method: 'POST'
            })
                .then(data => JSON.parse(data))
                .then(data => {
                    if (data.success && data.entity) {
                        new Noty({
                            layout: 'topCenter',
                            text: 'Successfully cloned page ' + pageName,
                            type: 'success',
                            timeout: 3500
                        }).show()

                        const app = this.$root.$children[0]
                        const tree = app.$refs.tree[0]

                        tree.insert({
                            node: this.node,
                            placement: 'after'
                        }, data.entity)

                        let newPath = this.node.path
                        newPath[newPath.length - 1] += 1


                        this.$nextTick(() => {
                            app.highlightNode(newPath, true)
                        })

                    } else {
                        new Noty({
                            layout: 'topCenter',
                            text: 'An error occured when cloning: ' + pageName,
                            type: 'error',
                            timeout: 3500
                        }).show()
                    }
                })
                .catch(error => console.log(error))
        },
        deleteItem() {
            if(this.preventDelete){
                if(typeof this.node.level === 'undefined'){
                    new Noty({
                        layout: 'topCenter',
                        text: "You can't delete the home page",
                        type: 'error',
                        timeout: 3500
                    }).show()
                }else{
                    new Noty({
                        layout: 'topCenter',
                        text: "Before you delete this page, move or remove it's child pages",
                        type: 'error',
                        timeout: 3500
                    }).show()
                }

                return
            }

            const token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')

            const pageName = this.node.title

            if (confirm('Are you sure you want to delete this page?')) {
                post(argon.root() + '/pages/' + this.node.data.id, {
                    _token: token,
                    _method: 'DELETE'
                })
                    .then(data => JSON.parse(data))
                    .then(data => {
                        if (data.success) {
                            new Noty({
                                layout: 'topCenter',
                                text: 'Successfully removed ' + pageName,
                                type: 'success',
                                timeout: 3500
                            }).show()
                            this.$root.$children[0].removeNode(this.treeIndex, this.node.path)
                        } else {
                            new Noty({
                                layout: 'topCenter',
                                text: 'An error occured removing: ' + pageName,
                                type: 'error',
                                timeout: 3500
                            }).show()
                        }
                    })
                    .catch(error => console.log(error))
            }
        },
        viewError() {
            new Noty({
                layout: 'topCenter',
                text: "The Page needs to be published before you can view it",
                type: 'error',
                timeout: 3500
            }).show()
        },
        edit() {
            window.location.href = this.editUrl
        },
        closeAddForm() {
            this.addFormOpen = false
        }
    },
    computed: {
        viewUrl: function() {
            if(this.node.data.status){
                return argon.root() + '/pages/' + this.node.data.id + '/preview'
            }
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
