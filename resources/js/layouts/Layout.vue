<script setup lang="ts">
import { PropType } from "vue";
import { User } from "@/types";
import { router } from "@inertiajs/vue3";

defineProps({
    user: Object as PropType<User>,
});

const logout = () => {
    router.visit("/logout")
};
</script>

<template>
    <div class="w-full max-w-[425px] mx-auto h-screen bg-gray-100">
        <div class="w-full h-[8vh] flex items-center justify-between px-4 border-b border-gray-300">
            <div class="flex items-center">
                <p class="mr-4">{{ user.name }}</p>
            </div>
            <div class="flex items-center">
                <button @click="logout" class="text-red-500">Sair</button>
            </div>
        </div>
        <slot />
    </div>
</template>
