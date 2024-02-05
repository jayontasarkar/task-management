<template>
    <div class="pb-2">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row align-items-center gap-4">
                    <input
                        type="text"
                        class="form-control"
                        :class="{
                            'is-invalid': task.errors && task.errors.name,
                        }"
                        :placeholder="!task.id ? 'Add new task...' : ''"
                        v-model="task.name"
                    />
                    <div>
                        <button
                            type="button"
                            class="btn btn-primary"
                            :disabled="task.submitting || !task.name.length"
                            @click.prevent="onSubmit"
                        >
                            {{ task.submitting ? "Saving..." : "Save" }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["task"],
    methods: {
        onSubmit() {
            this.$emit("onTaskSubmit");
        },
    },
};
</script>
