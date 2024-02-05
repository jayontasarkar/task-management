<template>
    <div class="pb-2">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row align-items-center gap-4">
                    <input
                        type="text"
                        class="form-control"
                        :class="{
                            'is-invalid': project.errors && project.errors.name,
                        }"
                        :placeholder="!project.id ? 'Add new project...' : ''"
                        v-model="project.name"
                    />
                    <div>
                        <button
                            type="button"
                            class="btn btn-primary"
                            :disabled="
                                project.submitting || !project.name.length
                            "
                            @click.prevent="onSubmit"
                        >
                            {{ project.submitting ? "Saving..." : "Save" }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["project"],
    methods: {
        onSubmit() {
            this.$emit("onProjectSubmit");
        },
    },
};
</script>
