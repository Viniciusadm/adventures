<script setup lang="ts">
import { Adventure } from "@/types";
import { PropType } from "vue";
import { router } from "@inertiajs/vue3";

defineProps({
    adventures: {
        type: Array as PropType<Adventure[]>,
        required: true,
    },
});
</script>

<template>
    <div class="flex flex-col p-4">
        <h1 class="text-3xl font-bold mb-4">Aventuras</h1>

        <button
            v-for="adventure in adventures"
            :key="adventure.id"
            class="mb-4 text-start"
            @click="router.visit(`/admin/edit/${adventure.slug}`)"
        >
            {{ adventure.title }}
        </button>
    </div>
</template>
