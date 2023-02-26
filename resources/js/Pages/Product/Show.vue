<template>
    <AppLayout title="Product">

        <div class="mx-auto max-w-7xl mt-10">

            <div v-if="this.$page.props.flash">
                {{ this.$page.props.flash.notification }}
            </div>
        </div>

        <div class="bg-white">
            <div class="pt-6">
                <nav aria-label="Breadcrumb">
                    <ol role="list" class="mx-auto flex max-w-2xl items-center space-x-2 px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                        <li v-for="(breadcrumb, index) in product.breadcrumbs" :key="breadcrumb.id">
                            <div class="flex items-center">
                                <a :href="index" class="mr-2 text-sm font-medium text-gray-900">{{ breadcrumb }}</a>
                                <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-5 w-4 text-gray-300">
                                    <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                                </svg>
                            </div>
                        </li>
                        <li class="text-sm">
                            <p>{{ product.name }}</p>
                        </li>
                    </ol>
                </nav>

                <!-- Image gallery -->
                <div class="mx-auto mt-6 max-w-2xl sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:gap-x-8 lg:px-8">
                    <div class="aspect-w-3 aspect-h-4 hidden overflow-hidden rounded-lg lg:block" v-for="image in product.images">
<!--                        <img :src="image_path(image.serverId)" class="h-full w-full object-cover object-center" />-->
                        <pre>{{ image.serverId }}</pre>
                        <img :src="image_path(image.serverId)" class="h-full w-full object-cover object-center"  alt=""/>
                    </div>
                </div>

                <!-- Main Image -->
                <div class="mx-auto mt-6 max-w-2xl sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:gap-x-8 lg:px-8">
                    <img :src="image_path(product.image)" class="h-full w-full object-cover object-center"  alt=""/>
                </div>
                <!-- Main Image -->

                <!-- Product info -->
                <div class="mx-auto max-w-2xl px-4 pt-10 pb-16 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8 lg:px-8 lg:pt-16 lg:pb-24">
                    <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
                        <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ product.name }}</h1>
                    </div>

                    <!-- Options -->
                    <div class="mt-4 lg:row-span-3 lg:mt-0">
                        <h2 class="sr-only">Product information</h2>
                        <p class="text-3xl tracking-tight text-gray-900">{{ product.price }} zł</p>

                        <!-- Reviews -->
                        <div class="mt-6">
                            <h3 class="sr-only">Reviews</h3>
<!--                            <div class="flex items-center">-->
<!--                                <div class="flex items-center">-->
<!--                                    <StarIcon v-for="rating in [0, 1, 2, 3, 4]" :key="rating" :class="[reviews.average > rating ? 'text-gray-900' : 'text-gray-200', 'h-5 w-5 flex-shrink-0']" aria-hidden="true" />-->
<!--                                </div>-->
<!--                                <p class="sr-only">{{ reviews.average }} out of 5 stars</p>-->
<!--                                <a :href="reviews.href" class="ml-3 text-sm font-medium text-indigo-600 hover:text-indigo-500">{{ reviews.totalCount }} reviews</a>-->
<!--                            </div>-->
                        </div>

                        <form class="mt-10">
                            <!-- Colors -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">Color</h3>
                                <div v-for="variant in variants">
                                    <input class="hover:border-4 hover:border-blue-600" type="radio" :id="variant.id" :value="variant.color" v-model="form.color" @click="changeVariant(variant.url)"/>
                                    <label class="ml-2 cursor-pointer hover:text-blue-600" :for="variant.id" >{{ variant.color }}</label>
                                </div>

<!--                                <div v-for="variant in product.product_variants">-->
<!--                                    <input type="radio" :id="variant.id" :value="variant.color" v-model="form.color" />-->
<!--                                    <label class="ml-2" :for="variant.id" >{{ variant.color }}</label>-->
<!--                                </div>-->

<!--                                <RadioGroup v-model="selectedColor" class="mt-4">-->
<!--                                    <RadioGroupLabel class="sr-only"> Choose a color </RadioGroupLabel>-->
<!--                                    <div class="flex items-center space-x-3">-->
<!--                                        <RadioGroupOption as="template" v-for="color in product.colors" :key="color.name" :value="color" v-slot="{ active, checked }">-->
<!--                                            <div :class="[color.selectedClass, active && checked ? 'ring ring-offset-1' : '', !active && checked ? 'ring-2' : '', '-m-0.5 relative p-0.5 rounded-full flex items-center justify-center cursor-pointer focus:outline-none']">-->
<!--                                                <RadioGroupLabel as="span" class="sr-only"> {{ color.name }} </RadioGroupLabel>-->
<!--                                                <span aria-hidden="true" :class="[color.class, 'h-8 w-8 border border-black border-opacity-10 rounded-full']" />-->
<!--                                            </div>-->
<!--                                        </RadioGroupOption>-->
<!--                                    </div>-->
<!--                                </RadioGroup>-->
                            </div>

                            <!-- Sizes -->
                            <div class="mt-10">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-medium text-gray-900">Size</h3>
                                    <div>
                                        <select v-model="form.id" class="block w-48 p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" >
                                            <option disabled value="">Choose size</option>
                                            <option class="text-lg" v-for="option in product.options" :key="option" :value="option.id" :disabled="!option.in_stock">
                                                <span v-if="option.price">{{ option.size }} - {{ option.price }} zł</span>
                                                <span v-else>{{ option.size }}</span>
                                            </option>
                                        </select>
                                    </div>
<!--                                    <div v-for="size in sizes">-->
<!--                                        <input type="radio" :value="size" :id="size" :disabled="size === '36'" v-model="form.size">-->
<!--                                        <label :for="size">{{ size }}</label>-->
<!--                                    </div>-->
<!--                                    <div v-for="variants in product.product_variants">-->
<!--                                        <div v-if="form.color === variants.color">-->
<!--                                            <p>{{ variants.size }}</p>-->
<!--                                        </div>-->
<!--                                    </div>-->
                                    <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Size guide</a>
                                </div>

<!--                                <RadioGroup v-model="selectedSize" class="mt-4">-->
<!--                                    <RadioGroupLabel class="sr-only"> Choose a size </RadioGroupLabel>-->
<!--                                    <div class="grid grid-cols-4 gap-4 sm:grid-cols-8 lg:grid-cols-4">-->
<!--                                        <RadioGroupOption as="template" v-for="size in product.sizes" :key="size.name" :value="size" :disabled="!size.inStock" v-slot="{ active, checked }">-->
<!--                                            <div :class="[size.inStock ? 'bg-white shadow-sm text-gray-900 cursor-pointer' : 'bg-gray-50 text-gray-200 cursor-not-allowed', active ? 'ring-2 ring-indigo-500' : '', 'group relative border rounded-md py-3 px-4 flex items-center justify-center text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6']">-->
<!--                                                <RadioGroupLabel as="span">{{ size.name }}</RadioGroupLabel>-->
<!--                                                <span v-if="size.inStock" :class="[active ? 'border' : 'border-2', checked ? 'border-indigo-500' : 'border-transparent', 'pointer-events-none absolute -inset-px rounded-md']" aria-hidden="true" />-->
<!--                                                <span v-else aria-hidden="true" class="pointer-events-none absolute -inset-px rounded-md border-2 border-gray-200">-->
<!--                                                    <svg class="absolute inset-0 h-full w-full stroke-2 text-gray-200" viewBox="0 0 100 100" preserveAspectRatio="none" stroke="currentColor">-->
<!--                                                      <line x1="0" y1="100" x2="100" y2="0" vector-effect="non-scaling-stroke" />-->
<!--                                                    </svg>-->
<!--                                              </span>-->
<!--                                            </div>-->
<!--                                        </RadioGroupOption>-->
<!--                                    </div>-->
<!--                                </RadioGroup>-->
                            </div>
                            <button @click.prevent="addToCart(form.id, product.quantity)" title="Dodaj do koszyka" type="submit" class="mt-10 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 py-3 px-8 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" v-if="isAvailable">Dodaj do koszyka</button>
                            <button class="mt-10 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 py-3 px-8 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" v-else>Powiadom mnie</button>

                        </form>
                    </div>

                    <div class="py-10 lg:col-span-2 lg:col-start-1 lg:border-r lg:border-gray-200 lg:pt-6 lg:pb-16 lg:pr-8">
                        <!-- Description and details -->
                        <div>
                            <h3 class="sr-only">Description</h3>

                            <div class="space-y-6">
                                <p class="text-base text-gray-900">{{ product.description }}</p>
                            </div>
                        </div>

                        <div class="mt-10">
                            <h3 class="text-sm font-medium text-gray-900">Highlights</h3>

                            <div class="mt-4">
<!--                                <ul role="list" class="list-disc space-y-2 pl-4 text-sm">-->
<!--                                    <li v-for="highlight in product.highlights" :key="highlight" class="text-gray-400">-->
<!--                                        <span class="text-gray-600">{{ highlight }}</span>-->
<!--                                    </li>-->
<!--                                </ul>-->
                            </div>
                        </div>

                        <div class="mt-10">
                            <h2 class="text-sm font-medium text-gray-900">Details</h2>

<!--                            <div class="mt-4 space-y-6">-->
<!--                                <p class="text-sm text-gray-600">{{ product.details }}</p>-->
<!--                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

import {ref} from 'vue'
import {useForm} from "@inertiajs/vue3";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    product: Object,
    variants: Object,
});

const form = useForm({
    id: null,
    color: props.product.color,
});

const addToCart = (product_id, quantity) => {
    router.post(route('cart.add', product_id, quantity));
    alert('Pomyślnie dodano ' + props.product.name + ' do koszyka ' );
};

const image_path = (image) => {
    return '/products/' + image;
};

const sizes = ['30', '32', '34', '36', '38', '40'];

const changeVariant = (url) => {
    router.get(route('product.show', url), {}, {preserveScroll: true, preserveState: true})
}

const changePrice = (option) => {
    console.log(option);
}

const isAvailable = ref(true)

</script>
