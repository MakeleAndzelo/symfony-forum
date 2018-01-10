<template>
    <div class="alert alert-info alert-custom" v-show="isVisible">
        {{ message }}
    </div>
</template>

<script>
    export default {
        props: ['message', 'type'],

        data() {
            return {
                isVisible: true,
            }
        },

        mounted() {
            setTimeout(() => {
                this.isVisible = false;
            }, 3000);
        }
    }
</script>