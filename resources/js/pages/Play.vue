<script setup lang="ts">
import Layout from "@/layouts/Layout.vue";
import { PropType } from "vue";
import { Adventure } from "@/types";

defineProps({
    adventure: {
        type: Object as PropType<Adventure>,
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
                    Description: {{ adventure.description }}
                </p>
            </div>
        </div>
    </Layout>
</template>
