<script setup lang="ts">
import Layout from "@/layouts/Layout.vue";
import { PropType } from "vue";
import { Adventure, Content } from "@/types";

defineProps({
    adventure: {
        type: Object as PropType<Adventure>,
        required: true,
    },
    contents: {
        type: Array as PropType<Content[]>,
        required: true,
    },
});
</script>

<template>
    <Layout>
        <div class="flex flex-col p-4 h-screen overflow-y-auto">
            <h1 class="text-2xl md:text-3xl font-bold mb-4">{{ adventure.title }}</h1>

            <div class="mb-4">
                <p class="mb-2 md:text-lg">
                    <span class="font-bold">Description:</span> {{ adventure.description }}
                </p>
            </div>

            <div class="mb-4">
                <div
                    v-for="content in contents"
                    :key="content.id"
                    class="border-b border-black pb-4 mb-4"
                >
                    <p class="mb-2 md:text-lg">
                        {{ content.body }}
                    </p>

                    <div v-if="content.options && content.options.length">
                        <p class="mb-2 md:text-lg">
                            <span class="font-bold">Options:</span>
                        </p>

                        <ul class="list-disc list-inside">
                            <li v-for="option in content.options" :key="option.id">
                                {{ option.label }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
