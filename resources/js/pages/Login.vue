<script setup lang="ts">
import Layout from "@/layouts/Layout.vue";
import { InertiaForm, useForm } from "@inertiajs/vue3";
import { PropType } from "vue";

defineProps({
    errors: {
        type: Object as PropType<InertiaForm>,
        default: () => ({}),
    },
})

const form = useForm({
    email: "",
    password: "",
});

const submit = () => {
    form.post('/logar');
};
</script>

<template>
    <div class="w-full max-w-[425px] mx-auto h-screen bg-gray-100">
        <div class="flex flex-col items-center justify-center h-full">
            <h1 class="text-3xl font-bold text-gray-800">Login</h1>
            <form class="w-full mt-8 px-4" @submit.prevent="submit">
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="email">
                        Email
                    </label>
                    <input
                        class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                        id="email"
                        type="email"
                        placeholder="Email"
                        v-model="form.email"
                    />
                    <div class="text-red-500 text-sm mt-2">
                        <span v-if="errors.email" v-text="errors.email" />
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="password">
                        Password
                    </label>
                    <input
                        class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                        id="password"
                        type="password"
                        placeholder="******************"
                        v-model="form.password"
                    />
                    <div class="text-red-500">
                        <span v-if="errors.password" v-text="errors.password" />
                    </div>
                </div>

                <button
                    class="w-full px-4 py-2 mt-8 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline"
                    type="submit"
                >
                    Login
                </button>
            </form>
        </div>
    </div>
</template>
