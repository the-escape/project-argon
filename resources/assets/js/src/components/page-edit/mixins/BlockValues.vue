<script>
export default {
    computed: {
        renderInputName: function () {
            return `group_render[${this.block.id}]`
        }
    }
}
</script>
