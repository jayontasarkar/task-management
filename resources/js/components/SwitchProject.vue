<template>
    <div
        class="d-flex justify-content-end align-items-center mb-4 pt-2 pb-3 gap-2"
    >
        <p class="small mb-0 me-2 text-muted">Switch project</p>
        <select
            class="form-select"
            aria-label="Switch between project"
            style="width: 200px"
            @change="handleChange($event)"
            v-model="currentProject"
        >
            <option
                :value="project.id"
                v-for="project in projects"
                :selected="project.id == project"
                :key="project.id"
            >
                {{ project.name }}
            </option>
        </select>
    </div>
</template>

<script>
export default {
    props: ["project", "projects"],
    data() {
        return {
            currentProject: null,
        };
    },
    methods: {
        handleChange(event) {
            const project = event.target.value;
            window.location.href = `/projects/${project}/tasks`;
        },
    },
    created() {
        this.currentProject = this.project;
    },
};
</script>
