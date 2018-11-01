<template>
    <div>
        <p>test child - {{ testData }}</p>
        <p>test prop - {{ testMsg }}</p>
    </div>
</template>

<script>
export default {
    props: ['testMsg'],
    data() {
        return {
            testData: 'hello child'
        }
    }
}
</script>
