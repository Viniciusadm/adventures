<script setup lang="ts">
defineProps({
    title: {
        type: String,
        required: true,
    },
});

const emit = defineEmits(['close']);

const close = () => {
    emit('close');
};
</script>

<template>
    <div
        class="absolute top-0 right-0 w-full h-full bg-gray-900 bg-opacity-50 flex justify-center items-center"
        @click="close"
    >
        <div class="bg-white rounded-lg p-4 m-4 w-[300px]" @click.stop>
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold">{{ title }}</h3>
                <button
                    type="button"
                    @click="close"
                >
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <slot/>
        </div>
    </div>
</template>
