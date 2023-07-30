<script setup lang="ts">
import Layout from "@/layouts/Layout.vue";
import { PropType, ref, Ref, nextTick } from "vue";
import { Adventure, Content } from "@/types";
import axios from "axios";
import Message from "@/components/Message.vue";

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

    if (inOption.value) {
        nextTick(() => {
            requestAnimationFrame(scroll);
        });
    } else {
        requestAnimationFrame(scroll);
    }
};

const scroll = () => {
    const scrollDiv = document.querySelector("#scroll");

    if (scrollDiv) {
        const targetScrollTop = scrollDiv.scrollHeight - scrollDiv.clientHeight;
        smoothScroll(scrollDiv, targetScrollTop, 300);
    }
};

const smoothScroll = (element, targetScrollTop, duration) => {
    const startScrollTop = element.scrollTop;
    const startTime = performance.now();

    const scrollStep = (timestamp) => {
        const currentTime = timestamp - startTime;
        const scrollDistance = targetScrollTop - startScrollTop;

        element.scrollTop = startScrollTop + scrollDistance * easeInOutQuad(currentTime / duration);

        if (currentTime < duration) {
            requestAnimationFrame(scrollStep);
        }
    };

    requestAnimationFrame(scrollStep);
};

const easeInOutQuad = (t) => {
    return t < 0.5 ? 2 * t * t : 1 - Math.pow(-2 * t + 2, 2) / 2;
};
</script>

<template>
    <Layout>
        <div class="flex flex-col h-[85vh] overflow-y-auto p-4" id="scroll">
            <h1 class="text-2xl md:text-3xl font-bold mb-4">{{ adventure.title }}</h1>

            <div>
                <div
                    v-for="(content, index) in showing"
                    :key="content.id"
                    class="pb-4"
                >
                    <Message :content="content"/>

                    <div
                        v-if="content.options && content.options.length && showing.length - 1 === index"
                    >
                        <div class="grid grid-cols-2 gap-4 mt-4">
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
        <div class="flex justify-end border-t-2 border-black pt-4 pe-4">
            <button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
                @click="next"
                :disabled="inOption"
                v-if="showing.length !== data.length"
            >
                Próximo
            </button>
        </div>
    </Layout>
</template>
