<template>
    <div>
        <task-form :task="element" @onTaskSubmit="addOrEditTask" />
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
        <sortable-tasks
            :elements="elements"
            @onDeleteTask="handleOnDeleteTask"
            @dragEnd="onDragEnd"
            @onEditTask="fillTaskForm"
            v-else-if="elements.length"
        />
        <alert-message
            v-else
            message="No task found for this project. Create a new one."
            type="info"
            closable
        />
    </div>
</template>

<script>
import axios from "axios";
import SortableTasks from "./SortableTasks.vue";
import TaskForm from "./TaskForm.vue";
import { notify } from "@kyvg/vue3-notification";

const initElement = {
    id: null,
    name: "",
    errors: {},
    submitting: false,
};

export default {
    props: ["project"],
    data() {
        return {
            elements: [],
            loading: false,
            deleting: null,
            element: { ...initElement },
            error: null,
        };
    },
    components: {
        SortableTasks,
        TaskForm,
    },
    methods: {
        async fetchTasks() {
            this.loading = true;
            this.error = null;
            try {
                const { data } = await axios.get(
                    `/api/projects/${this.project}/tasks`
                );

                this.elements = data?.data;
            } catch (error) {
                this.error = "Failed to fetch tasks for project";
            }
            this.loading = false;
        },
        async onDragEnd(task) {
            const tasks = [...this.elements];
            const mapped = tasks.map((item, index) => {
                return {
                    id: item.id,
                    priority: index + 1,
                };
            });
            try {
                await axios.post(`/api/tasks/priority`, {
                    mapped,
                });
                notify({
                    title: "Success!",
                    text: "Task priority sorted successfully!",
                });
            } catch (error) {
                notify({
                    title: "Failed!",
                    text: "Failed to sort task priority. Try again later!",
                    type: "error",
                });
            }
        },
        fillTaskForm({ id, name }) {
            this.element = {
                id,
                name,
                errors: {},
                submitting: false,
            };
        },
        addOrEditTask() {
            if (this.element.id) {
                this.editTask();
            } else {
                this.createTask();
            }
        },
        async createTask() {
            this.element.submitting = true;
            try {
                const { data } = await axios.post("/api/tasks", {
                    name: this.element.name,
                    project_id: this.project,
                });
                this.elements = [...this.elements, { ...data.data }];
                this.element = initElement;
                notify({
                    title: "Success!",
                    text: "Task created successfully!",
                });
            } catch (error) {
                if (error.response?.status === 422) {
                    this.element.errors = error.response?.data?.errors;
                }
            }
            this.element.submitting = false;
        },
        async editTask() {
            this.element.submitting = true;
            try {
                await axios.put(`/api/tasks/${this.element.id}`, {
                    name: this.element.name,
                    project_id: this.project,
                });
                const index = this.elements.findIndex(
                    (e) => e.id === this.element.id
                );
                this.elements[index].name = this.element.name;
                this.element = { ...initElement };
                notify({
                    title: "Success!",
                    text: "Task updated successfully!",
                });
            } catch (error) {
                if (error.response?.status === 422) {
                    this.element.errors = error.response?.data?.errors;
                } else {
                    notify({
                        title: "Failed!",
                        text: "Failed to update the task.",
                        type: "error",
                    });
                }
            }
            this.element.submitting = false;
        },
        async handleOnDeleteTask(task) {
            this.deleting = task;
            try {
                await axios.delete(`/api/tasks/${task}`);
                const taskIndex = this.elements.findIndex((t) => t.id == task);
                if (taskIndex >= 0) {
                    this.elements.splice(taskIndex, 1);
                    notify({
                        title: "Success!",
                        text: "Task removed successfully!",
                    });
                }
            } catch (error) {
                notify({
                    title: "Failed!",
                    text: "Failed to remove task. Try again later.",
                    type: "error",
                });
            }
            this.deleting = null;
        },
    },
    created() {
        this.fetchTasks();
    },
};
</script>
