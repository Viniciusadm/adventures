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

const showOptions = ref(false);
const options = ref([]);

const next = () => {
    showing.value = [...showing.value, data.value[showing.value.length]];

    const last = showing.value[showing.value.length - 1];

    inOption.value = !!(last.options && last.options.length);

    if (last.options && last.options.length) {
        options.value = last.options;
        showOptions.value = true;
    } else {
        showOptions.value = false;
    }

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
    <Head>
        <title>{{ adventure.title }}</title>
    </Head>
    <Layout>
        <div class="flex flex-col h-[85vh] overflow-y-auto p-4" id="scroll">
            <h1 class="text-2xl md:text-3xl font-bold mb-4">{{ adventure.title }}</h1>

            <div>
                <div
                    v-for="content in showing"
                    :key="content.id"
                    class="pb-4"
                >
                    <Message :content="content"/>
                </div>
            </div>
        </div>
        <div
            class="flex justify-end border-t-2 border-black pt-4 pe-4"
            v-if="!showOptions"
        >
            <button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
                @click="next"
                :disabled="inOption"
                v-if="showing.length !== data.length"
            >
                Próximo
            </button>
        </div>
        <div
            class="grid grid-cols-2 gap-2 p-2 border-t-2 border-black"
            v-if="showOptions">
            <button
                v-for="option in options"
                :key="option.id"
                @click="getNextContent(adventure.id, option.next_content_id)"
                class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded"
            >
                {{ option.label }}
            </button>
        </div>
    </Layout>
</template>
