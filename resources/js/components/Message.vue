<script setup lang="ts">
import { PropType } from "vue";
import { Content } from "@/types";

defineProps({
    content: {
        type: Object as PropType<Content>,
        required: true,
    },
});
</script>

<template>
    <div
        class="w-full flex"
        :class="{
            'justify-start': content.type === 'self',
            'justify-end': content.type === 'character',
            'justify-center': content.type === 'narrator',
        }"
    >
        <div
            class="rounded-lg p-4"
            :class="{
                'bg-blue-200': content.type === 'self',
                'bg-gray-300': content.type === 'narrator',
                'bg-green-200': content.type === 'character',
                'max-w-[80%]': ['self', 'character'].includes(content.type),
        }"
        >
            <p class="text-sm md:text-lg">{{ content.body }}</p>
        </div>
    </div>
</template>
