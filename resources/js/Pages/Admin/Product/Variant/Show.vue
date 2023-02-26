<template>
    <AdminLayout title="Index">
        <template #header>
            Options
        </template>

        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="py-3 pl-2">
                    <div class="flex justify-between mb-4">
                        <input
                            class="rounded-xl"
                            type="text"
                            placeholder="Szukaj..."
                        >
                        <Link class="bg-cyan-500 hover:bg-cyan-600 px-4 py-2 rounded-xl text-white" :href="route('admin.option.create', {product: productId, variant: variantId})">
                            <span>Dodaj</span>
                            <span class="hidden md:inline"> opcje</span>
                        </Link>
                    </div>
                </div>

                <div class="p-1.5 w-full inline-block align-middle">
                    <div class="overflow-hidden border rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th
                                    scope="col"
                                    class="flex items-center px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase"
                                >
                                    ID
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4 text-gray-500"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M17 13l-5 5m0 0l-5-5m5 5V6"
                                        />
                                    </svg>
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase"
                                >
                                <span class="inline-flex items-center">
                                    Size
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M7 11l5-5m0 0l5 5m-5-5v12"
                                        />
                                    </svg>
                                </span>
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase"
                                >
                                <span class="inline-flex items-center">
                                    Price
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4 text-gray-500"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M17 13l-5 5m0 0l-5-5m5 5V6"
                                        />
                                    </svg>
                                </span>
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase"
                                >
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-xs font-bold text-right text-gray-500 uppercase"
                                >
                                    Edit
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-xs font-bold text-right text-gray-500 uppercase"
                                >
                                    Delete
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            <tr v-for="option in options">
                                <td
                                    class="px-6 py-4 text-sm font-medium text-gray-800 whitespace-nowrap"
                                >
                                    {{ option.id }}
                                </td>
                                <td
                                    class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap"
                                >
                                    {{ option.size }}
                                </td>
                                <td
                                    class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap"
                                >
                                    ${{ option.price }}
                                </td>
                                <td
                                    class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap"
                                >
                                    <a
                                        class="text-green-500 hover:text-green-700"
                                        href="#"
                                    >
                                        Edit
                                    </a>
                                </td>
                                <td
                                    class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap"
                                >
                                    <a
                                        class="text-red-500 hover:text-red-700"
                                        href="#"
                                    >
                                        Delete
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4">
                        <Link :href="route('admin.product.show', productId)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                            </svg>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from "@inertiajs/vue3";
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import { router } from "@inertiajs/vue3";
import {reactive, ref, watch} from "vue";
import Pagination from "@/Shared/Pagination.vue";
import {pickBy, throttle} from "lodash";

const props = defineProps({
    options: Object,
    productId: Number,
    variantId: Number,
    // filters: Object,
});

// const productFilters = reactive({
//     search: props.filters.search,
//     perPage: props.filters.perPage,
//     column: props.filters.column,
//     direction: props.filters.direction,
// });
//
// watch(productFilters, throttle(() => {
//     let query = pickBy(productFilters)
//     let queryRoute = route('admin.product.index',
//         Object.keys(query).length ? query : {remember: 'forget'});
//         router.get(queryRoute, {}, {
//             preserveState: true,
//             replace: true
//         });
//     }, 400), { deep: true }
// );
//
// function sort(column) {
//     productFilters.column = column;
//     productFilters.direction = productFilters.direction === "asc" ? "desc" : "asc";
// }
//
const image_path = (image) => {
    image = JSON.parse(image)
    return '/uploads/product/' + props.productId + '/main/' + image;
};
//
// const search = ref(props.filters.search);

const destroy = (id) => {
    if (confirm('Are you sure?')) {
        router.delete(route('admin.product.destroy', id));
    }
};
</script>
