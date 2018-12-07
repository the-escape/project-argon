<script>
export default {
    computed: {
        field: function () {
            if(this.comboId){
                return this.$store.getters.getComboField(this.comboId, this.fieldId)
            }
            return this.$store.getters.getField(this.fieldId)
        },
        inputName: function () {
            let field
            if(this.comboId){
                field = this.$store.getters.getComboField(this.comboId, this.fieldId)
                return `combo[${this.comboId}][${this.comboItemId}][fields][${this.fieldId}][]`
            }else{
                field = this.$store.getters.getField(this.fieldId)
                return `fields[${field.id}][]`
            }
        },
        inputNameMultiValue: function () {
            let field
            if(this.comboId){
                field = this.$store.getters.getComboField(this.comboId, this.fieldId)
                return `combo[${this.comboId}][${this.comboItemId}][fields][${this.fieldId}]`
            }else{
                field = this.$store.getters.getField(this.fieldId)
                return `fields[${field.id}]`
            }
        },
        name: function () {
            let field
            if (this.comboId) {
                field = this.$store.getters.getComboField(this.comboId, this.fieldId)
            } else {
                field = this.$store.getters.getField(this.fieldId)
            }
            if(field){
                return field.options.name
            }
        },
        errors: function() {
            if(this.comboId){
                const comboItem = this.$store.getters.getField(this.comboId)
                if(comboItem.errors.length){
                    const errors =  comboItem.errors.filter(errorsObj => errorsObj.id === this.comboItemId)
                    if(errors.length && errors[0][this.fieldId]){
                        return errors[0][this.fieldId]
                    }
                }
                return []
            }

            const field = this.$store.getters.getField(this.fieldId)
            return field.errors
        }
    }
}
</script>
