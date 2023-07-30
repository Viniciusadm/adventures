<script setup lang="ts">
import { defineProps, PropType } from "vue";
import { Adventure } from "@/types";

defineProps({
    adventures: {
        type: Array as PropType<Adventure[]>,
        required: true,
    },
});
</script>

<template>
    <div class="flex flex-col p-4">
        <h1 class="text-3xl font-bold mb-4">Adventures</h1>

        <a
            v-for="adventure in adventures"
            :key="adventure.id"
            :href="`/play/${adventure.slug}`"
            class="mb-4"
        >
            {{ adventure.title }}
        </a>
    </div>
</template>
