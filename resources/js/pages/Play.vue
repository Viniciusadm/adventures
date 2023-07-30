<script setup lang="ts">
import Layout from "@/layouts/Layout.vue";
import { PropType, ref, Ref } from "vue";
import { Adventure, Content } from "@/types";

const props = defineProps({
    adventure: {
        type: Object as PropType<Adventure>,
        required: true,
    },
    contents: {
        type: Array as PropType<Content[]>,
        required: true,
    },
});

const data: Ref<Content[]> = ref(props.contents);
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
                    v-for="content in data"
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

                        <div class="grid grid-cols-2 gap-4">
                            <button
                                v-for="option in content.options"
                                :key="option.id"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            >
                                {{ option.label }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
