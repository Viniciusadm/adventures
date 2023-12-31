<script setup lang="ts">
import { PropType, ref } from "vue";
import { Content } from "@/types";
import { router } from "@inertiajs/vue3";
import Modal from "@/components/site/Modal.vue";

const props = defineProps({
    content: {
        type: Object as PropType<Content>,
        required: true,
    },
    full: {
        type: Boolean,
        default: false,
    },
    type: {
        type: String as PropType<"added" | "removed">,
        default: "added",
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

const remove = () => {
    router.delete(`/contents/${props.content?.adventure_id}/${props.content?.id}`, {}, {
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
                'max-w-[80%]': ['self', 'character'].includes(content.type) && !full,
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

        <Modal
            title="Opções"
            v-if="dropDown"
            @close="dropDown = false"
        >
            <button
                type="button"
                @click="save"
                class="flex items-center justify-center"
                v-if="type === 'added'"
            >
                <i class="bi bi-bookmark-plus-fill me-2 text-blue-500"></i> Salvar mensagem
            </button>

            <button
                type="button"
                @click="remove"
                class="flex items-center justify-center"
                v-if="type === 'removed'"
            >
                <i class="bi bi-trash-fill me-2 text-red-500"></i> Remover mensagem
            </button>
        </Modal>
    </div>
</template>
