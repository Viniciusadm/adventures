<script setup lang="ts">
import { PropType, ref, Ref, nextTick } from "vue";
import { Adventure, Content, Option } from "@/types";
import { Head, router } from '@inertiajs/vue3';
import axios from "axios";
import Message from "@/components/Message.vue";
import Modal from "@/components/site/Modal.vue";

const props = defineProps({
    adventure: {
        type: Object as PropType<Adventure>,
        required: true,
    },
    contents: {
        type: Array as PropType<Content[]>,
        required: true,
    },
    messages: {
        type: Array as PropType<Content[]>,
        required: true,
    },
});

const menu = ref(false);
const open_messages = ref(false);

const data: Ref<Content[]> = ref(props.contents);

const showing: Ref<Content[]> = ref([
    props.contents[0]
]);

const inOption = ref(false);

const getNextContent = (adventure_id: number, content_id: number): Promise<void> => {
    return axios.get(`/api/contents/${adventure_id}/${content_id}`).then((response) => {
        data.value = [...data.value, ...response.data];
    });
};

const showOptions = ref(false);
const options: Ref<Option[]> = ref([]);

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

    if (showing.value.length === data.value.length && !inOption.value && last.next_content_id) {
        getNextContent(props.adventure?.id, last.next_content_id);
    }
};

const saveChoice = (content_id: number, option_id: number) => {
    router.post(`/options/${content_id}/${option_id}/save`, {}, {
        preserveState: true,
    });
};

const choice = (adventure_id: number, content_id: number, next_content_id: number, option_id: number) => {
    getNextContent(adventure_id, next_content_id).then(() => {
        saveChoice(content_id, option_id);
        next();
    });
};

const saveLoad = ref(false);

const save = () => {
    saveLoad.value = true;

    const last = showing.value[showing.value.length - 1];
    router.put(`/adventures/${props.adventure.id}/${last.id}/save`, {}, {
        preserveState: true,
        onFinish: () => {
            saveLoad.value = false;
            menu.value = false;
        },
    });
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
    <div class="flex flex-col h-[77vh] overflow-y-auto p-4" id="scroll">
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
        class="flex justify-between items-center border-t-2 border-black h-[15vh] px-5"
        v-if="!showOptions"
    >
        <button
            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
            @click="menu = true"
        >
            Menu
        </button>

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
        class="grid grid-cols-2 gap-2 p-2 border-t-2 border-black h-[15vh]"
        v-if="showOptions">
        <button
            v-for="option in options"
            :key="option.id"
            @click="choice(adventure.id, option.content_id, option.next_content_id, option.id)"
            class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded"
        >
            {{ option.label }}
        </button>
    </div>

    <Modal
        title="Menu"
        v-if="menu"
        @close="menu = false"
    >
        <div class="flex flex-col gap-2">
            <button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                @click="menu = false"
            >
                Continuar
            </button>
            <button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                @click="open_messages = true; menu = false"
            >
                Ver mensagens salvas
            </button>
            <button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                @click="save"
                :disabled="saveLoad"
            >
                Salvar
            </button>
            <button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                @click="router.visit('/')"
            >
                Sair
            </button>
        </div>
    </Modal>

    <Modal
        title="Mensagens salvas"
        v-if="open_messages"
        @close="open_messages = false"
    >
        <div class="flex flex-col gap-2">
            <div
                v-for="message in messages"
                :key="message.id"
                class="flex flex-col gap-2"
            >
                <Message
                    :content="message"
                    :full="true"
                    type="removed"
                />
            </div>
            <p
                v-if="!messages.length"
                class="text-center"
            >
                Nenhuma mensagem salva
            </p>
        </div>
    </Modal>
</template>
