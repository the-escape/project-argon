<script>
export default {
    computed: {
        options: function() {
            let options = this.$store.getters['fields/getFieldOption'](this.groupId, [this.fieldId, this.comboId], 'settings.options')

            if(!options){
                return []
            }

            return options.reduce((acc, opt) => {
                for(let key in opt){
                    acc.push({
                        value: key,
                        label: opt[key]
                    })
                }
                return acc
            }, [])
        },
        values: {
            get() {
                let values = this.$store.getters['fields/getValues'](this.groupId, [this.fieldId, this.comboId, this.comboItemId])
                const settings = this.$store.getters['fields/getFieldOption'](this.groupId, [this.fieldId, this.comboId], 'settings')

                if(!settings){
                    return ''
                }

                const isMultiple = settings.multiple || settings.multiple_instances

                if(isMultiple){
                    return values.map(value => value.value)
                }

                if(!values.length){
                    return ''
                }

                return values[0].value
            },
            set(values){
                if(!Array.isArray(values)){
                    values = [values]
                }

                const valueObjs = values.map((value, id) => {
                    return {
                        value,
                        id
                    }
                })

                if(this.comboId){
                    this.$store.commit('fields/updateComboItemFieldValue', {
                        groupID: this.groupId,
                        ids: [this.fieldId, this.comboId, this.comboItemId],
                        newValue: valueObjs
                    })
                } else {
                    this.$store.commit('fields/updateValues', {
                        groupID: this.groupId,
                        id: this.fieldId,
                        newValues: valueObjs
                    })
                }
            }
        }
    },
}
</script>
