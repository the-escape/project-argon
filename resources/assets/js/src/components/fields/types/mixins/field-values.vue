<script>
export default {
    computed: {
        field: function () {
            return this.$store.getters['fields/getField'](this.groupId, [this.fieldId, this.comboId])
        },
        inputName: function () {
            if(this.comboId){
                return `combo[${this.comboId}][${this.comboItemId}][fields][${this.fieldId}][]`
            }else{
                return `fields[${this.fieldId}][]`
            }
        },
        inputNameMultiValue: function () { // eg: fields[5]['lat']
            if(this.comboId){
                return `combo[${this.comboId}][${this.comboItemId}][fields][${this.fieldId}]`
            }else{
                return `fields[${this.fieldId}]`
            }
        },
        name: function () {
            return this.$store.getters['fields/getFieldOption'](this.groupId, [this.fieldId, this.comboId], 'name')
        },
        errors: function() {
            return this.$store.getters['fields/getFieldErrors'](this.groupId, [this.fieldId, this.comboId, this.comboItemId])
        }
    }
}
</script>
