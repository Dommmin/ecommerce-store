<template>
    <AdminLayout>
        <template #header>
            Variant Create
        </template>

        <div class="mt-10 sm:mt-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="mt-5 md:col-span-2 md:mt-0">
                    <form @submit.prevent="submit">
                        <div class="overflow-hidden shadow sm:rounded-md">
                            <div class="bg-white px-4 py-5 sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                                        <input v-model="form.color" type="text" name="color" id="color" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        <div class="text-red-600 mt-1">
                                            <div v-if="errors.color" class="text-red-600">
                                                {{ errors.color }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="color" class="block text-sm font-medium text-gray-700">Price</label>
                                        <input v-model="form.price" type="number" min="1" name="price" id="price" autocomplete="price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        <div class="text-red-600 mt-1">
                                            <div v-if="errors.price" class="text-red-600">
                                                {{ errors.price }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <p class="font-bold text-xl">Zdjęcie główne</p>

                                    <div class="flex items-center justify-center w-full">
                                        <label for="mainImage" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">

                                            <div v-if="!file.src">
                                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                    <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">Click to upload</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                                                </div>
                                            </div>
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6" v-else>
                                                <img :src="file.src" :alt="file.src" class="rounded mt-2" width="400">
                                            </div>
                                            <input @input="getImage" id="mainImage" name="mainImage" type="file" class="hidden" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="hidden sm:block" aria-hidden="true">
                            <div class="py-5">
                                <div class="border-t border-gray-200" />
                            </div>
                        </div>

                        <div class="p-6">
                            <button :disabled="isLoading" class="inline-flex items-center px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl disabled:opacity-75 disabled:cursor-not-allowed w-full justify-center">
                                <div v-show="isLoading" class="inline-block animate-spin w-4 h-4 mr-2 border-t-2 border-t-white border-r-2 border-r-white border-b-2 border-b-white border-l-2 border-l-indigo-600 rounded-full"></div>
                                <span v-if="isLoading">Processing...</span>
                                <span v-else class="px-2">Save</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import {ref} from 'vue';
import {router, useForm} from "@inertiajs/vue3";

const isLoading = ref(false);

const props = defineProps({
    errors: Object,
    id: Number,
    csrf_token: String
});

const form = useForm({
    product_id: props.id,
    color: '',
    price: null,
});

const file = useForm({
    src: '',
    image: {},
})

// Main image
const getImage = function (e) {
    const selectedFiles = e.target.files;

    for (let i = 0; i < selectedFiles.length; i++) {
        file.src = URL.createObjectURL(selectedFiles[i]);
        file.image = selectedFiles[i];
    }
}

const submit = () => {
    router.post(route('admin.variant.store', props.id), {
        _method: 'post',
        form: form,
        image: file.image
    });
};
</script>
