<template>
    <AdminLayout title="Index">
        <template #header>
            Category Create
        </template>

        <div class="py-2">
            <div class="sm:px-6 lg:px-8 bg-gray-100">
                <div class="mx-auto py-6 sm:px-6 lg:px-8 max-w-[50rem]">
                    <form @submit.prevent="form.post(route('admin.category.store'))">
                        <div class="overflow-hidden shadow sm:rounded-md">

                            <div class="m-4">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Nazwa</label>
                                <input v-model="form.name" id="name" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <div class="text-red-600 mt-1">
                                    <div v-if="errors.name" class="text-red-600">
                                        {{ errors.name }}
                                    </div>
                                </div>
                            </div>

                            <div class="m-4">
                                <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Człowiek</label>
                                <select v-model="form.person_id" name="category" id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected disabled>-- Wybierz rodzaj --</option>
                                    <option v-for="person in people" :value="person.id">{{ person.name }}</option>
                                </select>
                                <div class="text-red-600 mt-1">
                                    <div v-if="errors.person" class="text-red-600">
                                        {{ errors.person }}
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                                <button :disabled="isLoading" class="inline-flex items-center px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl disabled:opacity-75 disabled:cursor-not-allowed w-full justify-center md:w-auto">
                                    <div v-show="isLoading" class="inline-block animate-spin w-4 h-4 mr-2 border-t-2 border-t-white border-r-2 border-r-white border-b-2 border-b-white border-l-2 border-l-indigo-600 rounded-full"></div>
                                    <span v-if="isLoading">Processing...</span>
                                    <span v-else class="px-2">Save</span>
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

const isLoading = ref(false);

const props = defineProps({
    errors: Object,
    people: Object
});

const form = useForm({
    name: '',
    person_id: '',
});
</script>
