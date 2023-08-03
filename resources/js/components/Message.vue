<script setup lang="ts">
import { PropType, ref } from "vue";
import { Content } from "@/types";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    content: {
        type: Object as PropType<Content>,
        required: true,
    },
});

const dropDown = ref(false);

const save = () => {
    router.post(`/contents/${props.content?.adventure_id}/${props.content?.id}`, {}, {
        preserveScroll: true,
        onSuccess: () => {
            dropDown.value = false;
        },
    });
};
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
            class="rounded-lg"
            :class="{
                'bg-blue-200': content.type === 'self',
                'bg-gray-300': content.type === 'narrator',
                'bg-green-200': content.type === 'character',
                'max-w-[80%]': ['self', 'character'].includes(content.type),
        }"
        >
            <div class="flex">
                <p class="text-sm md:text-lg p-4 pe-0">
                    {{ content.body }}
                </p>
                <button
                    type="button"
                    @click="dropDown = !dropDown"
                    class="pe-3 pt-3 flex align-items-start h-fit"
                >
                    <i class="bi bi-three-dots"></i>
                </button>
            </div>
        </div>

        <div
            v-if="dropDown"
            class="absolute top-0 right-0 w-full h-full bg-gray-900 bg-opacity-50 flex justify-center items-center"
            @click="dropDown = !dropDown"
        >
            <div class="bg-white rounded-lg p-4 m-4 w-[300px]" @click.stop>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold">Opções</h3>
                    <button
                        type="button"
                        @click="dropDown = !dropDown"
                    >
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <button
                    type="button"
                    @click="save"
                    class="flex items-center justify-center"
                >
                    <i class="bi bi-bookmark-plus-fill me-2 text-blue-500"></i> Salvar mensagem
                </button>
            </div>
        </div>
    </div>
</template>
