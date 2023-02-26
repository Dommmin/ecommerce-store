<template>
    <AdminLayout title="Index">
        <template #header>
            Kategorie
        </template>

        <div class="py-12">
            <div class="sm:px-6 lg:px-8">
                <div class="mx-auto py-6 sm:px-6 lg:px-8">
                    <div class="px-4 py-6 sm:px-0">

                        <div class="flex justify-between mb-4">
                            <input
                                v-model="search"
                                class="rounded-xl"
                                type="text"
                                placeholder="Szukaj..."
                            >
                            <Link class="bg-violet-500 hover:bg-violet-600 px-4 py-2 rounded-xl text-white" :href="route('admin.category.create')">
                                <span>Dodaj</span>
                                <span class="hidden md:inline"> kategorię</span>
                            </Link>
                        </div>

                        <div class="bg-white rounded-md shadow overflow-x-auto">
                            <table class="w-full whitespace-nowrap">
                                <thead>
                                <tr class="text-left font-bold bg-sky-700 text-xl text-white">
                                    <th class="pb-4 pt-3 px-4">Nazwa</th>
                                    <th class="pb-4 pt-3 px-4">Rodzaj</th>
                                    <th class="pb-4 pt-3 px-4">Utworzono</th>
                                    <th class="pb-4 pt-3 px-4">Dodał</th>
                                    <th class="pb-4 pt-3 px-4">Usuń</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="category in categories.data" class="hover:bg-sky-200 bg-sky-100">
                                    <td class="border-t">
                                        <Link class="flex items-center px-4 py-4 focus:text-indigo-500" :href="`/organizations/{organization.id}/edit`">
                                            {{ category.name }}
<!--                                            <icon v-if="organization.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-gray-400" />-->
                                        </Link>
                                    </td>
                                    <td class="border-t">
                                        <Link class="flex items-center px-4 py-4"
                                              :href="`/organizations/#/edit`"
                                              tabindex="-1"
                                        >
                                            <span v-if="category.person === 'Kobiety'">Kobiece</span>
                                            <span v-else-if="category.person === 'Mężczyźni'">Męskie</span>
                                            <span v-else>Dziecięce</span>
                                        </Link>
                                    </td>
                                    <td class="border-t">
                                        <Link class="flex items-center px-4 py-4"

                                              :href="`/organizations/#/edit`"
                                              tabindex="-1">
                                            {{ category.created_at }}
                                        </Link>
                                    </td>
                                    <td class="border-t">
                                        <Link class="flex items-center px-4 py-4"
                                              :href="`/organizations/#/edit`"
                                              tabindex="-1">
                                            {{ category.user }}
                                        </Link>
                                    </td>
                                    <td class="border-t">
                                        <a href="#" @click="destroy(category.id)" class="flex items-center px-6 py-4" title="Usuń">
                                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-red-600 hover:text-red-700 cursor-pointer">
                                                <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </td>
<!--                                    <td class="w-px border-t">-->
<!--                                        icon-->
<!--                                    </td>-->
                                </tr>
<!--                                <tr>-->
<!--                                    v-if="organizations.data.length === 0"-->
<!--                                >-->
<!--                                    <td class="px-6 py-4 border-t" colspan="4">No organizations found.</td>-->
<!--                                </tr>-->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <Pagination :links="categories.links" />
                </div>
            </div>
        </div>

        <div class="fixed top-16 w-56 text-right">

        </div>

    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import {Link} from "@inertiajs/vue3";
import { ref, watch } from "vue";
import {router} from "@inertiajs/vue3";
import Pagination from "@/Shared/Pagination.vue";
import debounce from "lodash/debounce";

let props = defineProps({
    categories: Object,
    filters: Object
});

const destroy = (id) => {
    if (confirm('Are you sure?')) {
        router.delete(route('admin.category.destroy', id), {
            preserveScroll: true
        });
    }
};

let search = ref(props.filters.search);

watch(search, debounce(function (value) {
    router.get(route('admin.category.index'), { search: value }, {
        preserveState: true,
        replace: true
    });
}, 300));
</script>

