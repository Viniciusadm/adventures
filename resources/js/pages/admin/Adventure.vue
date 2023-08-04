<script setup lang="ts">
import { Adventure } from "@/types";
import { PropType } from "vue";

defineProps({
    adventure: {
        type: Object as PropType<Adventure>,
        required: true,
    },
});
</script>

<template>
    <div class="p-5">
        <h1 class="text-2xl font-bold mb-3">{{ adventure.title }}</h1>
        <p class="text-sm text-gray-500">{{ adventure.description }}</p>
    </div>
</template>
