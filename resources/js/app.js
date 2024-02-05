import "./bootstrap";

import { createApp } from "vue";
import Notifications from "@kyvg/vue3-notification";

const app = createApp({});
app.use(Notifications);

import ProjectManagement from "./components/ProjectManagement.vue";
import TaskManagement from "./components/TaskManagement.vue";
import SwitchProject from "./components/SwitchProject.vue";
import AlertMessage from "./components/AlertMessage.vue";

app.component("project-management", ProjectManagement);
app.component("task-management", TaskManagement);
app.component("switch-project", SwitchProject);
app.component("alert-message", AlertMessage);

app.mount("#app");
