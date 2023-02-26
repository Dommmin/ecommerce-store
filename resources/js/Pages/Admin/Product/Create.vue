<template>
    <AdminLayout>
        <template #header>
            Product Create
        </template>

        <div class="mt-10 sm:mt-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="mt-5 md:col-span-2 md:mt-0">
                    <form @submit.prevent="form.post(route('admin.product.store'))">
                        <div class="overflow-hidden shadow sm:rounded-md">
                            <div class="bg-white px-4 py-5 sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                        <input v-model="form.name" type="text" name="name" id="name" autocomplete="given-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        <div class="text-red-600 mt-1">
                                            <div v-if="errors.name" class="text-red-600">
                                                {{ errors.name }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                                        <select v-model="form.category_id" id="type" name="category_id" autocomplete="category_id" class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                            <option selected disabled>-- Wybierz kategorię --</option>
                                            <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                                        </select>
                                        <div class="text-red-600 mt-1">
                                            <div v-if="errors.category_id" class="text-red-600">
                                                {{ errors.category_id }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="brand" class="block text-sm font-medium text-gray-700">Brand</label>
                                        <select v-model="form.brand_id" id="brand" name="brand_id" autocomplete="brand" class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                            <option selected disabled>-- Wybierz markę --</option>
                                            <option v-for="brand in brands" :value="brand.id">{{ brand.name }}</option>
                                        </select>
                                        <div class="text-red-600 mt-1">
                                            <div v-if="errors.brand_id" class="text-red-600">
                                                {{ errors.brand_id }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                        <div class="mt-1">
                                            <textarea v-model="form.description" id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Description..." />
                                        </div>
                                        <div class="text-red-600 mt-1">
                                            <div v-if="errors.description" class="text-red-600">
                                                {{ errors.description }}
                                            </div>
                                        </div>
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
    categories: Object,
    brands: Object,
    productTypes: Object,
    csrf_token: String
});

const form = useForm({
    name: '',
    category_id: '',
    brand_id: '',
    description: '',
});

</script>
