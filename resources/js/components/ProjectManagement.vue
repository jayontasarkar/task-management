<template>
    <div>
        <project-form :project="project" @onProjectSubmit="addNewProject" />
        <hr class="my-4" />
        <alert-message v-if="error" :message="error" type="danger" closable />
        <div class="d-flex justify-content-center" v-else-if="loading">
            <div
                class="spinner-border"
                style="width: 2rem; height: 2rem"
                role="status"
            >
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <template v-else-if="projects.length">
            <div class="row">
                <div
                    class="col-md-4 mb-4"
                    v-for="project in projects"
                    :key="project.id"
                >
                    <div class="card">
                        <div class="card-header">{{ project.name }}</div>
                        <div class="card-body">
                            <h5 class="card-title">
                                Tasks Count: {{ project.tasks.length }}
                            </h5>
                            <p class="card-text">
                                Created {{ project.created_at }}
                            </p>
                            <div class="d-flex justify-content-between">
                                <a
                                    :href="`/projects/${project.id}/tasks`"
                                    class="btn btn-primary"
                                    >Check Tasks</a
                                >
                                <button
                                    class="btn btn-outline-danger"
                                    title="Delete project"
                                    :disabled="
                                        deleting && deleting === project.id
                                    "
                                    @click.prevent="
                                        handleOnDeleteProject(project.id)
                                    "
                                >
                                    <i
                                        class="fa-solid fa-spinner fa-spin"
                                        v-if="
                                            deleting && deleting === project.id
                                        "
                                    ></i>
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <alert-message
            v-else
            message="No project found. Create a new one."
            type="info"
            closable
        />
    </div>
</template>

<script>
import axios from "axios";
import ProjectForm from "./ProjectForm.vue";
import { notify } from "@kyvg/vue3-notification";

const initProject = {
    id: null,
    name: "",
    errors: {},
    submitting: false,
};
export default {
    components: {
        ProjectForm,
    },
    data() {
        return {
            projects: [],
            project: { ...initProject },
            error: null,
            loading: false,
            deleting: false,
        };
    },
    methods: {
        async fetchProjects() {
            this.loading = true;
            try {
                const { data } = await axios.get("/api/projects");
                this.projects = data.data;
            } catch (error) {
                this.error = "Failed to fetch projects";
            }
            this.loading = false;
        },
        async addNewProject() {
            this.project.submitting = true;
            try {
                const { data } = await axios.post("/api/projects", {
                    name: this.project.name,
                });
                this.projects = [{ ...data.data, tasks: [] }, ...this.projects];
                this.project = initProject;
                notify({
                    title: "Success!",
                    text: "Project created successfully!",
                });
            } catch (error) {
                if (error.response?.status === 422) {
                    this.project.errors = error.response?.data?.errors;
                }
            }
            this.project.submitting = false;
        },
        async handleOnDeleteProject(project) {
            this.deleting = project;
            try {
                await axios.delete(`/api/projects/${project}`);
                const projectIndex = this.projects.findIndex(
                    (t) => t.id == project
                );
                if (projectIndex >= 0) {
                    this.projects.splice(projectIndex, 1);
                    notify({
                        title: "Success!",
                        text: "Project removed successfully!",
                    });
                }
            } catch (error) {
                notify({
                    title: "Failed!",
                    text: "Failed to remove project. Try again later.",
                    type: "error",
                });
            }
            this.deleting = null;
        },
    },
    created() {
        this.fetchProjects();
    },
};
</script>
