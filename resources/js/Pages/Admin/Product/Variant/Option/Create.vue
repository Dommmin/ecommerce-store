<template>
    <AdminLayout>
        <template #header>
            Variant Create
        </template>

        <div class="mt-10 sm:mt-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="mt-5 md:col-span-2 md:mt-0">
                    <form @submit.prevent="form.post(route('admin.option.store', {product: productId, variant: variantId}))">
                        <div class="overflow-hidden shadow sm:rounded-md">
                            <div class="bg-white px-4 py-5 sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="color" class="block text-sm font-medium text-gray-700">Size</label>
                                        <input v-model="form.size" type="text" name="size" id="size" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        <div class="text-red-600 mt-1">
                                            <div v-if="errors.size" class="text-red-600">
                                                {{ errors.size }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                                        <input v-model="form.price" type="number" min="1" name="price" id="price" autocomplete="price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        <div class="text-red-600 mt-1">
                                            <div v-if="errors.price" class="text-red-600">
                                                {{ errors.price }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="in_stock" class="block text-sm font-medium text-gray-700">In stock</label>
                                        <input v-model="form.in_stock" type="number" min="0" name="in_stock" id="in_stock" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        <div class="text-red-600 mt-1">
                                            <div v-if="errors.in_stock" class="text-red-600">
                                                {{ errors.in_stock }}
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
import {useForm} from "@inertiajs/vue3";

const isLoading = ref(false);

const props = defineProps({
    errors: Object,
    productId: Number,
    variantId: Number,
});

const form = useForm({
    product_id: props.productId,
    variant_id: props.variantId,
    size: '',
    price: null,
    in_stock: null,
});
</script>
