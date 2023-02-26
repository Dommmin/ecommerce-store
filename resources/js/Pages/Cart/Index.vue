<template>
    <AppLayout title="Cart">

        <div class="mx-auto mt-6 max-w-7xl">
            <div class="mt-16 mb-16 ml-10 mr-10">
                <div class="font-bold text-3xl mb-8 text-white">Shopping Cart</div>

                <div v-if="!cartItems">
                    <p class="text-white">Twój koszyk jest pusty...</p>
                </div>
                <div class="grid grid-cols-1 gap-x-16">
                    <div class="grid grid-flow-row auto-rows-max grid-cols-4 gap-6 border-t border-b pt-8 pb-8" v-for="product in products">
                            <div>
                                <img :src="image_path(product.image)" :alt="product.image" class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
                            </div>
                            <div>
                                <p class="font-bold text-white">{{ product.name }}</p>
                                <p class="text-gray-500">{{ product.color }} | {{ product.size }}</p>
                                <p class="font-bold text-white">${{ product.price }}</p>
                                <p class="mt-5 text-white">Dostępne: {{ product.in_stock }}</p>
                            </div>
                            <div>
                                <select @change="changeQuantity(product.product_option_id, product.quantity)" v-model="product.quantity" class="block w-16 p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                                    <option v-for="quantity in quantities" :key="product.quantity" :value="quantity" :selected="product.quantity" :disabled="product.in_stock < quantity">
                                        {{ quantity }}
                                    </option>
<!--                                    <option selected :value="product.quantity">{{ product.quantity }}</option>-->
                                </select>
                            </div>
                            <div class="flex justify-end">
                                <a href="#" @click.prevent="removeFromCart(product.product_option_id)" title="Usuń z koszyka">
                                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            </div>
                    </div>

                    <div class="p-8 rounded-xl" v-if="total">
                        <div>
                            <div>
                                <div>
                                    <div class="grid grid-cols-1 gap-4 py-4">
                                        <div class="col-start-1 font-bold text-xl text-white">Wartość zamówienia</div>
                                        <div class="col-end-5 font-bold text-white">{{ total }} zł</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-center items-center mt-5">
                                <button class="text-white bg-indigo-600 hover:bg-indigo-700 py-3 w-full rounded-lg">Do kasy</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {router} from "@inertiajs/vue3";

const props = defineProps({
    cartItems: Object,
    products: Object,
    total: Number
});

const data = {
    selected: ''
};

const quantities = [1,2,3,4,5];

const removeFromCart = (id) => {
    router.post(route('cart.remove', id), {}, {
        preserveScroll: true
    });
};

const image_path = (image) => {
    // image = JSON.parse(image);
    return '/products/' + image;
};

const changeQuantity = (product, quantity) => {
    return router.post(route('cart.update-quantity', product), {quantity: quantity}, {
        preserveScroll: true,
    })
}
</script>
