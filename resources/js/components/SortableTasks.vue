<template>
    <draggable
        tag="ul"
        item-key="id"
        :list="elements"
        class="list-group rounded-0 bg-transparent"
        handle=".handle"
        @end="onDragEnd"
    >
        <template #item="{ element }">
            <li class="list-group-item bg-transparent">
                <div class="row">
                    <div class="col-md-9 d-flex gap-3">
                        <span style="cursor: pointer" class="handle">
                            <i class="fa-solid fa-bars"></i>
                        </span>
                        <div>
                            {{ element.name }}
                        </div>
                    </div>
                    <div class="col-md-2 text-center">
                        {{ element.created_at }}
                    </div>
                    <div class="col-md-1 d-flex gap-2">
                        <button
                            class="btn btn-sm btn-outline-info"
                            title="Edit task"
                            @click.prevent="onEditTask(element)"
                        >
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                        <button
                            class="btn btn-sm btn-outline-danger"
                            title="Delete task"
                            :disabled="deleting && deleting === element.id"
                            @click.prevent="confirmDeleteTask(element.id)"
                        >
                            <i
                                class="fa-solid fa-spinner fa-spin"
                                v-if="deleting && deleting === element.id"
                            ></i>
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </div>
                </div>
            </li>
        </template>
    </draggable>
</template>

<script>
import draggable from "vuedraggable";

export default {
    props: ["elements", "deleting"],
    components: { draggable },
    methods: {
        confirmDeleteTask(taskId) {
            this.$emit("onDeleteTask", taskId);
        },
        onEditTask({ id, name }) {
            this.$emit("onEditTask", {
                id,
                name,
            });
        },
        onDragEnd(e) {
            if (e.newIndex !== e.oldIndex) {
                this.$emit("dragEnd", { ...this.elements[e.newIndex] });
            }
        },
    },
};
</script>
