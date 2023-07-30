<script setup lang="ts">
import Layout from "@/layouts/Layout.vue";
import { PropType, ref, Ref } from "vue";
import { Adventure, Content } from "@/types";
import axios from "axios";

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

const showing: Ref<Content[]> = ref([
    props.contents[0]
]);

const inOption = ref(false);

const getNextContent = (adventure_id: number, content_id: number) => {
    axios.get(`/api/contents/${adventure_id}/${content_id}`).then((response) => {
        data.value = [...data.value, ...response.data];
        next();
    });
};

const next = () => {
    showing.value = [...showing.value, data.value[showing.value.length]];

    const last = showing.value[showing.value.length - 1];

    inOption.value = !!(last.options && last.options.length);
};
</script>

<template>
    <Layout>
        <div class="p-4">
            <div class="flex flex-col h-[85vh] overflow-y-auto" id="scroll">
                <h1 class="text-2xl md:text-3xl font-bold mb-4">{{ adventure.title }}</h1>

                <div class="mb-4">
                    <p class="mb-2 md:text-lg">
                        <span class="font-bold">Description:</span> {{ adventure.description }}
                    </p>
                </div>

                <div>
                    <div
                        v-for="(content, index) in showing"
                        :key="content.id"
                        class="border-b border-black pb-4"
                        :class="{
                            'mb-4': showing.length - 1 !== index,
                        }"
                    >
                        <p class="mb-2 md:text-lg">
                            {{ content.body }}
                        </p>

                        <div
                            v-if="content.options && content.options.length && showing.length - 1 === index"
                        >
                            <p class="mb-2 md:text-lg">
                                <span class="font-bold">Options:</span>
                            </p>

                            <div class="grid grid-cols-2 gap-4">
                                <button
                                    v-for="option in content.options"
                                    :key="option.id"
                                    @click="getNextContent(adventure.id, option.next_content_id)"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                >
                                    {{ option.label }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end border-t-2 border-black pt-4">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
                    @click="next"
                    :disabled="inOption"
                    v-if="showing.length !== data.length"
                >
                    Próximo
                </button>
            </div>
        </div>
    </Layout>
</template>
