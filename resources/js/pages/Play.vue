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
        <div class="flex flex-col p-4">
            <h1 class="text-2xl md:text-3xl font-bold mb-4">{{ adventure.title }}</h1>

            <div class="mb-4">
                <p class="mb-2 md:text-lg">
                    <span class="font-bold">Description:</span> {{ adventure.description }}
                </p>
            </div>

            <div class="mb-4">
                <p class="mb-2 md:text-lg" v-for="content in contents" :key="content.id">
                    {{ content.body }}
                </p>
            </div>
        </div>
    </Layout>
</template>
