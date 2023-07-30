<script setup lang="ts">
import { PropType } from "vue";
import { User } from "@/types";

defineProps({
    user: Object as PropType<User>,
});
</script>

<template>
    <div class="w-full max-w-[425px] mx-auto h-screen bg-gray-100">
        <slot />
    </div>
</template>
