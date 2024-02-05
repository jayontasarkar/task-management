<template>
    <div :class="['alert', `alert-${type}`]" role="alert">
        {{ message }}
        <button
            type="button"
            class="btn-close"
            v-if="closable"
            data-bs-dismiss="alert"
            aria-label="Close"
        ></button>
    </div>
</template>

<script>
export default {
    props: {
        message: {
            required: true,
        },
        type: {
            required: false,
            default: "danger",
        },
        closable: {
            required: false,
            default: false,
        },
    },
};
</script>
