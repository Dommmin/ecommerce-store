<template>
    <AppLayout title="Home">
<!--        <template #header>-->
<!--            <h2 class="font-semibold text-xl text-gray-800 leading-tight">-->
<!--                Dashboard-->
<!--            </h2>-->
<!--        </template>-->

                <main class="container mx-auto max-w-custom lg:max-w-[1700px] flex flex-col lg:flex-row">

                    <!-- Flying Panel-->
                    <div class="w-96 mx-auto lg:mx-0 lg:mr-5">
                        <div class="bg-white lg:sticky lg:top-8 border-2 border-blue-500 rounded-xl mt-16 hidden lg:block ml-5">
                            <div class="text-center px-6 py-2 pt-6">
                                <h3 class="font-semibold text-base text-4xl mb-5">Filtry</h3>

                                <!-- Filters -->
                                <h3 class="font-bold text-2xl mb-5">Color</h3>
                                <ul v-for="(index, color) in colors" :key="index">
                                    <li>
                                        <input
                                            @input="changeColor(color)"
                                            type="checkbox"
                                            :id="index"
                                            :value="color"
                                            class="rounded hover:border-cyan-500 hover:border-2 mr-3"
                                        >

<!--                                        <input-->
<!--                                            v-model="checkbox"-->
<!--                                            @click="changeColor('')"-->
<!--                                            type="checkbox"-->
<!--                                            :id="index"-->
<!--                                            :value="color"-->
<!--                                            class="rounded hover:border-cyan-500 hover:border-2 mr-3"-->
<!--                                            v-else-->
<!--                                        >-->
                                        <label :for="index">{{ color }}</label>
                                    </li>
                                </ul>

<!--                                    <Disclosure as="div" class="border-b border-gray-200 py-6" v-slot="{ open }">-->
<!--                                        <h3 class="-my-3 flow-root">-->
<!--                                            <DisclosureButton class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500">-->
<!--                                                <span class="font-medium text-gray-900">Color</span>-->
<!--                                                <span class="ml-6 flex items-center">-->
<!--                                                          <PlusIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />-->
<!--                                                          <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />-->
<!--                                                        </span>-->
<!--                                            </DisclosureButton>-->
<!--                                        </h3>-->
<!--                                        <DisclosurePanel class="pt-6">-->
<!--                                            <div class="space-y-4">-->
<!--                                                <div v-for="(option, optionIdx) in section.options" :key="option.value" class="flex items-center">-->
<!--                                                    <input :id="`filter-${section.id}-${optionIdx}`" :name="`${section.id}[]`" :value="option.value" type="checkbox" :checked="option.checked" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />-->
<!--                                                    <label :for="`filter-${section.id}-${optionIdx}`" class="ml-3 text-sm text-gray-600">{{ option.label }}</label>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </DisclosurePanel>-->
<!--                                    </Disclosure>-->
                            </div>

                        </div>
                    </div>
                    <!-- Flying Panel-->


                    <div class="w-full px-2 md:px-0 md:w-184">

                        <div class="mt-8">
                            <!-- Slot -->
                            <!-- Mobile filter dialog -->
                            <TransitionRoot as="template" :show="mobileFiltersOpen">
                                <Dialog as="div" class="relative z-40 lg:hidden" @close="mobileFiltersOpen = false">
                                    <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
                                        <div class="fixed inset-0 bg-black bg-opacity-25" />
                                    </TransitionChild>

                                    <div class="fixed inset-0 z-40 flex">
                                        <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="translate-x-full">
                                            <DialogPanel class="relative ml-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white py-4 pb-12 shadow-xl">
                                                <div class="flex items-center justify-between px-4">
                                                    <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                                                    <button type="button" class="-mr-2 flex h-10 w-10 items-center justify-center rounded-md bg-white p-2 text-gray-400" @click="mobileFiltersOpen = false">
                                                        <span class="sr-only">Close menu</span>
                                                        <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                                                    </button>
                                                </div>

                                                <!-- Filters -->
                                                <form class="mt-4 border-t border-gray-200">
                                                    <h3 class="sr-only">Categories</h3>
                                                    <ul role="list" class="px-2 py-3 font-medium text-gray-900">
                                                        <li v-for="category in subCategories" :key="category.name">
                                                            <a :href="category.href" class="block px-2 py-3">{{ category.name }}</a>
                                                        </li>
                                                    </ul>

                                                    <Disclosure as="div" v-for="section in filters" :key="section.id" class="border-t border-gray-200 px-4 py-6" v-slot="{ open }">
                                                        <h3 class="-mx-2 -my-3 flow-root">
                                                            <DisclosureButton class="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500">
                                                                <span class="font-medium text-gray-900">{{ section.name }}</span>
                                                                <span class="ml-6 flex items-center">
                                                                  <PlusIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />
                                                                  <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />
                                                                </span>
                                                            </DisclosureButton>
                                                        </h3>
                                                        <DisclosurePanel class="pt-6">
                                                            <div class="space-y-6">
                                                                <div v-for="(option, optionIdx) in section.options" :key="option.value" class="flex items-center">
                                                                    <input :id="`filter-mobile-${section.id}-${optionIdx}`" :name="`${section.id}[]`" :value="option.value" type="checkbox" :checked="option.checked" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                                                    <label :for="`filter-mobile-${section.id}-${optionIdx}`" class="ml-3 min-w-0 flex-1 text-gray-500">{{ option.label }}</label>
                                                                </div>
                                                            </div>
                                                        </DisclosurePanel>
                                                    </Disclosure>
                                                </form>
                                            </DialogPanel>
                                        </TransitionChild>
                                    </div>
                                </Dialog>
                            </TransitionRoot>

                            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                                <div class="flex items-baseline justify-between border-b border-gray-200 pt-24 pb-6">
                                    <h1 class="text-4xl font-bold tracking-tight text-gray-900">Klienci zakupili także</h1>

                                    <div class="flex items-center">
                                        <Menu as="div" class="relative inline-block text-left">
                                            <div>
                                                <MenuButton class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900">
                                                    Sort
                                                    <ChevronDownIcon class="-mr-1 ml-1 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                                                </MenuButton>
                                            </div>

                                            <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                                <MenuItems class="absolute right-0 z-10 mt-2 w-40 origin-top-right rounded-md bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                    <div class="py-1">
                                                        <MenuItem v-for="option in sortOptions" :key="option.name" v-slot="{ active }">
                                                            <a :href="option.href" :class="[option.current ? 'font-medium text-gray-900' : 'text-gray-500', active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm']">{{ option.name }}</a>
                                                        </MenuItem>
                                                    </div>
                                                </MenuItems>
                                            </transition>
                                        </Menu>

                                        <button type="button" class="-m-2 ml-5 p-2 text-gray-400 hover:text-gray-500 sm:ml-7">
                                            <span class="sr-only">View grid</span>
                                            <Squares2X2Icon class="h-5 w-5" aria-hidden="true" />
                                        </button>
                                        <button type="button" class="-m-2 ml-4 p-2 text-gray-400 hover:text-gray-500 sm:ml-6 lg:hidden" @click="mobileFiltersOpen = true">
                                            <span class="sr-only">Filters</span>
                                            <FunnelIcon class="h-5 w-5" aria-hidden="true" />
                                        </button>
                                    </div>
                                </div>

                                <section aria-labelledby="products-heading" class="pt-6">
                                    <h2 id="products-heading" class="sr-only">Products</h2>

                                </section>
                            </div>

                            <div class="bg-white">
                                <div class="mx-auto max-w-2xl py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
                                    <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                                        <div v-for="product in products" :key="product.id" class="group relative">
<!--                                            <div v-for="variant in product.variants">-->
                                                <div class="min-h-80 aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none lg:h-80">
                                                    <Link :href="route('product.show', product.url)" class="hover:opacity-75">
                                                        <img :src="image_path(product.image)" :alt="product.image" class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
                                                    </Link>
                                                </div>
                                                <div class="mt-4 flex justify-between">
                                                    <div>
                                                        <h3 class="text-sm text-gray-700">
                                                            {{ product.name }}
                                                        </h3>
                                                        <p class="mt-1 text-sm text-gray-500">{{ product.color }}</p>
                                                    </div>
                                                    <p class="text-sm font-medium text-gray-900">{{ product.price }} zł</p>
                                                </div>
                                            <div>
                                                <div class="flex justify-center mt-2">
                                                    <button @click.prevent="addFavorite(product.variant_id)" type="submit" class="" title="Dodaj do ulubionych" v-if="!product.favorite">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 stroke-red-600 hover:fill-red-600 cursor-pointer" title="Dodaj do ulubionych">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                                        </svg>
                                                    </button>
                                                    <button @click.prevent="removeFavorite(product.variant_id)" type="submit" class="" title="Usuń z ulubionych" v-else>
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 stroke-red-600 fill-red-600 hover:fill-none cursor-pointer" title="Usuń z ulubionych">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                                <div class="flex items-center justify-center">
                                                    <button @click="open = true" class="text-white bg-indigo-500 hover:bg-indigo-600 w-full py-2 rounded-xl mt-2">Dodaj do koszyka</button>
                                                </div>
<!--                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                            </div>

<!--                            <div class="bg-white">-->
<!--                                <div class="mx-auto max-w-2xl py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">-->
<!--                                    <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">-->
<!--                                        <div v-for="product in products" :key="product.id" class="group relative">-->
<!--                                            <div class="min-h-80 aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none lg:h-80">-->
<!--                                                <Link :href="route('product.show', product.slug)" class="hover:opacity-75">-->
<!--                                                    <img :src="image_path(product.image)" :alt="product.image" class="h-full w-full object-cover object-center lg:h-full lg:w-full" />-->
<!--                                                </Link>-->
<!--                                            </div>-->

                                            <!-- Favorites --->
<!--                                            <div>-->
<!--                                                <div class="flex justify-center mt-2">-->
<!--                                                    <button @click.prevent="addFavorite(product.id)" type="submit" class="" title="Dodaj do ulubionych" v-if="!product.favorite">-->
<!--                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 stroke-red-600 hover:fill-red-600 cursor-pointer" title="Dodaj do ulubionych">-->
<!--                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />-->
<!--                                                        </svg>-->
<!--                                                    </button>-->
<!--                                                    <button @click.prevent="removeFavorite(product.id)" type="submit" class="" title="Usuń z ulubionych" v-else>-->
<!--                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 stroke-red-600 fill-red-600 hover:fill-none cursor-pointer" title="Usuń z ulubionych">-->
<!--                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />-->
<!--                                                        </svg>-->
<!--                                                    </button>-->
<!--                                                </div>-->
<!--                                            </div>-->
                                            <!-- Favorites --->

<!--                                            <div class="mt-4 flex justify-between">-->
<!--                                                <div>-->
<!--                                                    <h3 class="text-sm text-gray-700">-->
<!--                                                        {{ product.name }}-->
<!--                                                    </h3>-->
<!--                                                    <p class="mt-1 text-sm text-gray-500">{{ product.color }}</p>-->
<!--                                                </div>-->
<!--                                                <p class="text-sm font-medium text-gray-900">{{ product.price }} zł</p>-->
<!--                                            </div>-->
<!--                                            <div class="flex items-center justify-center">-->
<!--                                                <button @click="open = true" class="text-white bg-indigo-500 hover:bg-indigo-600 w-full py-2 rounded-xl mt-2">Dodaj do koszyka</button>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->


                            <!---------- modal ----------->

                            <TransitionRoot as="template" :show="open">
                                <Dialog as="div" class="relative z-10" @close="open = false">
                                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                                        <div class="fixed inset-0 hidden bg-gray-500 bg-opacity-75 transition-opacity md:block" />
                                    </TransitionChild>

                                    <div class="fixed inset-0 z-10 overflow-y-auto">
                                        <div class="flex min-h-full items-stretch justify-center text-center md:items-center md:px-2 lg:px-4">
                                            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 md:translate-y-0 md:scale-95" enter-to="opacity-100 translate-y-0 md:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 md:scale-100" leave-to="opacity-0 translate-y-4 md:translate-y-0 md:scale-95">
                                                <DialogPanel class="flex w-full transform text-left text-base transition md:my-8 md:max-w-2xl md:px-4 lg:max-w-4xl">
                                                    <div class="relative flex w-full items-center overflow-hidden bg-white px-4 pt-14 pb-8 shadow-2xl sm:px-6 sm:pt-8 md:p-6 lg:p-8">
                                                        <button type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500 sm:top-8 sm:right-6 md:top-6 md:right-6 lg:top-8 lg:right-8" @click="open = false">
                                                            <span class="sr-only">Close</span>
                                                            <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                                                        </button>

                                                        <div class="grid w-full grid-cols-1 items-start gap-y-8 gap-x-6 sm:grid-cols-12 lg:gap-x-8">
                                                            <div class="aspect-w-2 aspect-h-3 overflow-hidden rounded-lg bg-gray-100 sm:col-span-4 lg:col-span-5">
                                                                <img :src="product.imageSrc" :alt="product.imageAlt" class="object-cover object-center" />
                                                            </div>
                                                            <div class="sm:col-span-8 lg:col-span-7">
                                                                <h2 class="text-2xl font-bold text-gray-900 sm:pr-12">{{ product.name }}</h2>

                                                                <section aria-labelledby="information-heading" class="mt-2">
                                                                    <h3 id="information-heading" class="sr-only">Product information</h3>

                                                                    <p class="text-2xl text-gray-900">{{ product.price }}</p>

                                                                    <!-- Reviews -->
                                                                    <div class="mt-6">
                                                                        <h4 class="sr-only">Reviews</h4>
                                                                        <div class="flex items-center">
                                                                            <div class="flex items-center">
                                                                                <StarIcon v-for="rating in [0, 1, 2, 3, 4]" :key="rating" :class="[product.rating > rating ? 'text-gray-900' : 'text-gray-200', 'h-5 w-5 flex-shrink-0']" aria-hidden="true" />
                                                                            </div>
                                                                            <p class="sr-only">{{ product.rating }} out of 5 stars</p>
                                                                            <a href="#" class="ml-3 text-sm font-medium text-indigo-600 hover:text-indigo-500">{{ product.reviewCount }} reviews</a>
                                                                        </div>
                                                                    </div>
                                                                </section>

                                                                <section aria-labelledby="options-heading" class="mt-10">
                                                                    <h3 id="options-heading" class="sr-only">Product options</h3>

                                                                    <form>
                                                                        <!-- Colors -->
                                                                        <div>
                                                                            <h4 class="text-sm font-medium text-gray-900">Color</h4>

                                                                            <RadioGroup v-model="selectedColor" class="mt-4">
                                                                                <RadioGroupLabel class="sr-only"> Choose a color </RadioGroupLabel>
                                                                                <span class="flex items-center space-x-3">
                                                                      <RadioGroupOption as="template" v-for="color in product.colors" :key="color.name" :value="color" v-slot="{ active, checked }">
                                                                        <div :class="[color.selectedClass, active && checked ? 'ring ring-offset-1' : '', !active && checked ? 'ring-2' : '', '-m-0.5 relative p-0.5 rounded-full flex items-center justify-center cursor-pointer focus:outline-none']">
                                                                          <RadioGroupLabel as="span" class="sr-only"> {{ color.name }} </RadioGroupLabel>
                                                                          <span aria-hidden="true" :class="[color.class, 'h-8 w-8 border border-black border-opacity-10 rounded-full']" />
                                                                        </div>
                                                                      </RadioGroupOption>
                                                                    </span>
                                                                            </RadioGroup>
                                                                        </div>

                                                                        <!-- Sizes -->
                                                                        <div class="mt-10">
                                                                            <div class="flex items-center justify-between">
                                                                                <h4 class="text-sm font-medium text-gray-900">Size</h4>
                                                                                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Size guide</a>
                                                                            </div>

                                                                            <RadioGroup v-model="selectedSize" class="mt-4">
                                                                                <RadioGroupLabel class="sr-only"> Choose a size </RadioGroupLabel>
                                                                                <div class="grid grid-cols-4 gap-4">
                                                                                    <RadioGroupOption as="template" v-for="size in product.sizes" :key="size.name" :value="size" :disabled="!size.inStock" v-slot="{ active, checked }">
                                                                                        <div :class="[size.inStock ? 'bg-white shadow-sm text-gray-900 cursor-pointer' : 'bg-gray-50 text-gray-200 cursor-not-allowed', active ? 'ring-2 ring-indigo-500' : '', 'group relative border rounded-md py-3 px-4 flex items-center justify-center text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none sm:flex-1']">
                                                                                            <RadioGroupLabel as="span">{{ size.name }}</RadioGroupLabel>
                                                                                            <span v-if="size.inStock" :class="[active ? 'border' : 'border-2', checked ? 'border-indigo-500' : 'border-transparent', 'pointer-events-none absolute -inset-px rounded-md']" aria-hidden="true" />
                                                                                            <span v-else aria-hidden="true" class="pointer-events-none absolute -inset-px rounded-md border-2 border-gray-200">
                                                                                <svg class="absolute inset-0 h-full w-full stroke-2 text-gray-200" viewBox="0 0 100 100" preserveAspectRatio="none" stroke="currentColor">
                                                                                  <line x1="0" y1="100" x2="100" y2="0" vector-effect="non-scaling-stroke" />
                                                                                </svg>
                                                                              </span>
                                                                                        </div>
                                                                                    </RadioGroupOption>
                                                                                </div>
                                                                            </RadioGroup>
                                                                        </div>

                                                                        <button type="submit" class="mt-6 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 py-3 px-8 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Dodaj</button>
                                                                    </form>
                                                                </section>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </DialogPanel>
                                            </TransitionChild>
                                        </div>
                                    </div>
                                </Dialog>
                            </TransitionRoot>

                            <!---------- modal ----------->

                            <div class="relative overflow-hidden bg-white">
                                <div class="pt-16 pb-80 sm:pt-24 sm:pb-40 lg:pt-40 lg:pb-48">
                                    <div class="relative mx-auto max-w-custom px-4 sm:static sm:px-6 lg:px-8">
                                        <div class="sm:max-w-lg">
                                            <h1 class="font text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Summer styles are finally here</h1>
                                            <p class="mt-4 text-xl text-gray-500">This year, our new summer collection will shelter you from the harsh elements of a world that doesn't care if you live or die.</p>
                                        </div>
                                        <div>
                                            <div class="mt-10">
                                                <!-- Decorative image grid -->
                                                <div aria-hidden="true" class="pointer-events-none lg:absolute lg:inset-y-0 lg:mx-auto lg:w-full lg:max-w-7xl">
                                                    <div class="absolute transform sm:left-1/2 sm:top-0 sm:translate-x-8 lg:left-1/2 lg:top-1/2 lg:-translate-y-1/2 lg:translate-x-8">
                                                        <div class="flex items-center space-x-6 lg:space-x-8">
                                                            <div class="grid flex-shrink-0 grid-cols-1 gap-y-6 lg:gap-y-8">
                                                                <div class="h-64 w-44 overflow-hidden rounded-lg sm:opacity-0 lg:opacity-100">
                                                                    <img src="https://tailwindui.com/img/ecommerce-images/home-page-03-hero-image-tile-01.jpg" alt="" class="h-full w-full object-cover object-center" />
                                                                </div>
                                                                <div class="h-64 w-44 overflow-hidden rounded-lg">
                                                                    <img src="https://tailwindui.com/img/ecommerce-images/home-page-03-hero-image-tile-02.jpg" alt="" class="h-full w-full object-cover object-center" />
                                                                </div>
                                                            </div>
                                                            <div class="grid flex-shrink-0 grid-cols-1 gap-y-6 lg:gap-y-8">
                                                                <div class="h-64 w-44 overflow-hidden rounded-lg">
                                                                    <img src="https://tailwindui.com/img/ecommerce-images/home-page-03-hero-image-tile-03.jpg" alt="" class="h-full w-full object-cover object-center" />
                                                                </div>
                                                                <div class="h-64 w-44 overflow-hidden rounded-lg">
                                                                    <img src="https://tailwindui.com/img/ecommerce-images/home-page-03-hero-image-tile-04.jpg" alt="" class="h-full w-full object-cover object-center" />
                                                                </div>
                                                                <div class="h-64 w-44 overflow-hidden rounded-lg">
                                                                    <img src="https://tailwindui.com/img/ecommerce-images/home-page-03-hero-image-tile-05.jpg" alt="" class="h-full w-full object-cover object-center" />
                                                                </div>
                                                            </div>
                                                            <div class="grid flex-shrink-0 grid-cols-1 gap-y-6 lg:gap-y-8">
                                                                <div class="h-64 w-44 overflow-hidden rounded-lg">
                                                                    <img src="https://tailwindui.com/img/ecommerce-images/home-page-03-hero-image-tile-06.jpg" alt="" class="h-full w-full object-cover object-center" />
                                                                </div>
                                                                <div class="h-64 w-44 overflow-hidden rounded-lg">
                                                                    <img src="https://tailwindui.com/img/ecommerce-images/home-page-03-hero-image-tile-07.jpg" alt="" class="h-full w-full object-cover object-center" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <a href="#" class="inline-block rounded-md border border-transparent bg-indigo-600 py-3 px-8 text-center font-medium text-white hover:bg-indigo-700">Shop Collection</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Slot -->
                        </div>
                    </div>
                </main>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Link} from "@inertiajs/vue3";
import {reactive, ref, watch} from 'vue'
import {
    Dialog,
    DialogPanel,
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    RadioGroup,
    RadioGroupLabel,
    RadioGroupOption,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue'
import {XMarkIcon} from '@heroicons/vue/24/outline'
import {ChevronDownIcon, FunnelIcon, MinusIcon, PlusIcon, Squares2X2Icon, StarIcon} from '@heroicons/vue/20/solid'
import {router} from "@inertiajs/vue3";
import {pickBy, throttle} from "lodash";

const items = [
    {
        id: 1,
        name: 'Basic Tee',
        href: '#',
        imageSrc: 'https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-01.jpg',
        imageAlt: "Front of men's Basic Tee in black.",
        price: '$35',
        color: 'Black',
    },
    {
        id: 2,
        name: 'Basic Tee',
        href: '#',
        imageSrc: 'https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-02.jpg',
        imageAlt: "Front of men's Basic Tee in black.",
        price: '$35',
        color: 'Black',
    },
    {
        id: 3,
        name: 'Basic Tee',
        href: '#',
        imageSrc: 'https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-03.jpg',
        imageAlt: "Front of men's Basic Tee in black.",
        price: '$35',
        color: 'Black',
    },
    {
        id: 4,
        name: 'Basic Tee',
        href: '#',
        imageSrc: 'https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-04.jpg',
        imageAlt: "Front of men's Basic Tee in black.",
        price: '$35',
        color: 'Black',
    },
    // More products...
]

const props = defineProps({
    products: Object,
    filters: Object,
});

const product = {
    name: 'Basic Tee 6-Pack ',
    price: '$192',
    rating: 3.9,
    reviewCount: 117,
    href: '#',
    imageSrc: 'https://tailwindui.com/img/ecommerce-images/product-quick-preview-02-detail.jpg',
    imageAlt: 'Two each of gray, white, and black shirts arranged on table.',
    colors: [
        { name: 'White', class: 'bg-white', selectedClass: 'ring-gray-400' },
        { name: 'Gray', class: 'bg-gray-200', selectedClass: 'ring-gray-400' },
        { name: 'Black', class: 'bg-gray-900', selectedClass: 'ring-gray-900' },
    ],
    sizes: [
        { name: 'XXS', inStock: true },
        { name: 'XS', inStock: true },
        { name: 'S', inStock: true },
        { name: 'M', inStock: true },
        { name: 'L', inStock: true },
        { name: 'XL', inStock: true },
        { name: 'XXL', inStock: true },
        { name: 'XXXL', inStock: false },
    ],
}

const open = ref(false)
const selectedColor = ref(product.colors[0])
const selectedSize = ref(product.sizes[2])

const sortOptions = [
    { name: 'Most Popular', href: '#', current: true },
    { name: 'Best Rating', href: '#', current: false },
    { name: 'Newest', href: '#', current: false },
    { name: 'Price: Low to High', href: '#', current: false },
    { name: 'Price: High to Low', href: '#', current: false },
]
const subCategories = [
    { name: 'Totes', href: '#' },
    { name: 'Backpacks', href: '#' },
    { name: 'Travel Bags', href: '#' },
    { name: 'Hip Bags', href: '#' },
    { name: 'Laptop Sleeves', href: '#' },
]
const filters = [
    {
        id: 'color',
        name: 'Color',
        options: [
            { value: 'white', label: 'White', checked: false },
            { value: 'beige', label: 'Beige', checked: false },
            { value: 'blue', label: 'Blue', checked: true },
            { value: 'brown', label: 'Brown', checked: false },
            { value: 'green', label: 'Green', checked: false },
            { value: 'purple', label: 'Purple', checked: false },
        ],
    },
    {
        id: 'category',
        name: 'Category',
        options: [
            { value: 'new-arrivals', label: 'Klienci zakupili także', checked: false },
            { value: 'sale', label: 'Sale', checked: false },
            { value: 'travel', label: 'Travel', checked: true },
            { value: 'organization', label: 'Organization', checked: false },
            { value: 'accessories', label: 'Accessories', checked: false },
        ],
    },
    {
        id: 'size',
        name: 'Size',
        options: [
            { value: '2l', label: '2L', checked: false },
            { value: '6l', label: '6L', checked: false },
            { value: '12l', label: '12L', checked: false },
            { value: '18l', label: '18L', checked: false },
            { value: '20l', label: '20L', checked: false },
            { value: '40l', label: '40L', checked: true },
        ],
    },
]

let mobileFiltersOpen = ref(false)

const addFavorite = (id) => {
    router.post(route('product.add-to-favorite', id), {}, {
        preserveScroll: true,
        preserveState: true
    })
};

const removeFavorite = (id) => {
    router.post(route('product.remove-from-favorite', id), {}, {
        preserveScroll: true,
        preserveState: true
    })
};

const image_path = (image) => {
    // image = JSON.parse(image);
    // return '/uploads/products/main/' + image;
    return '/products/' + image;
};

const productFilters = reactive({
    color: props.filters.color,
});

let checkbox = ref([])
checkbox = [];

function changeColor(color) {
    if (checkbox.includes(color)) {
        checkbox.remove(color);
    } else {
        checkbox.push(color);
    }

    productFilters.color = checkbox.toString();
}

watch(productFilters, throttle(() => {
        let query = pickBy(productFilters)
        let queryRoute = route('index',
            Object.keys(query).length ? query : {remember: 'forget'});
            router.get(queryRoute, {}, {
            preserveState: true,
            replace: true
        });
    }, 400), { deep: true }
);

const colors = {
    'Czarny': 'bg-black',
    'Brązowy': 'bg-custom-brown',
    'Beżowy': 'bg-custom-beige',
    'Szary': 'bg-custom-gray',
    'Biały': 'bg-white',
    'Niebieski': 'bg-custom-blue',
    'Morski': 'bg-custom-teal',
    'Turkusowy': 'bg-custom-turquoise',
    'Zielony': 'bg-custom-green',
    'Oliwkowy': 'bg-custom-olive',
    'Żółty': 'bg-custom-yellow',
    'Pomarańczowy': 'bg-custom-orange',
    'Czerwony': 'bg-custom-red',
    'Różowy': 'bg-custom-rose',
    'Liliowy': 'bg-custom-lilac',
    // 'Kolorowy'
}

const checked = ref(true)

Array.prototype.remove = function() {
    let what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};
</script>
