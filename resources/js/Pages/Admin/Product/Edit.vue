<template>
    <AdminLayout title="Index">
        <template #header>
            {{ form.name }}
        </template>

        <div class="py-2">
            <div class="sm:px-6 lg:px-8 bg-gray-100">
                <div class="mx-auto py-6 sm:px-6 lg:px-8 max-w-[50rem]">

                    <form @submit.prevent="updateProduct">
                        <div class="overflow-hidden shadow sm:rounded-md">
                            <div class="bg-white px-4 py-5 sm:p-6 bg-indigo-500 bg-opacity-20">
                                <div class="m-4">
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Nazwa</label>
                                    <input v-model="form.name" id="name" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <div class="text-red-600 mt-1">
                                        <div v-if="errors.name" class="text-red-600">
                                            {{ errors.name }}
                                        </div>
                                    </div>
                                </div>

                                <!-- ////////////////////////////////////////// -->
                                <div class="m-4">
                                    <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Wybierz kategorię i podkategorię</label>
                                    <div class="flex">
                                        <select v-model="form.category" name="category" id="category" class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600">
                                            <option selected disabled>-- Wybierz kategorię --</option>
                                            <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                                        </select>
                                        <div class="text-red-600 mt-1">
                                            <div v-if="errors.category" class="text-red-600">
                                                {{ errors.category }}
                                            </div>
                                        </div>
                                        <label for="subcategory" class="sr-only">Wybierz podkategorię</label>
                                        <select v-model="form.subcategory_id" name="subcategory" id="subcategory" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg border-l-gray-100 dark:border-l-gray-700 border-l-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option selected disabled>-- Wybierz podkategorię --</option>
                                            <option v-for="subcategory in subcategories" :value="subcategory.id">{{ subcategory.name }}</option>
                                        </select>
                                    </div>
                                    <div class="text-red-600 mt-1">
                                        <div v-if="errors.subcategory_id" class="text-red-600">
                                            {{ errors.subcategory_id }}
                                        </div>
                                    </div>
                                </div>



                                <!--                                <div v-for="category in categories">-->
                                <!--                                    <div v-for="subcategory in category.subcategories">-->
                                <!--                                        <div v-if="subcategory.category_id === form.category">-->
                                <!--                                            <pre>{{ subcategory.name }}</pre>-->
                                <!--                                        </div>-->
                                <!--                                    </div>-->
                                <!--                                </div>-->

                                <!-- ////////////////////////////////////////// -->

                                <!--                                <div class="m-4">-->
                                <!--                                    <label for="subcategory" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Podkategoria</label>-->
                                <!--                                    <select v-model="form.subcategory_id" name="subcategory" id="subcategory" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">-->
                                <!--                                        <option selected>&#45;&#45; Wybierz podkategorię &#45;&#45;</option>-->
                                <!--                                        <option v-for="subcategory in subcategories" :value="subcategory.id">{{ subcategory.name }}</option>-->
                                <!--                                    </select>-->
                                <!--                                    <div class="text-red-600 mt-1">-->
                                <!--                                        <div v-if="errors.subcategory" class="text-red-600">-->
                                <!--                                            {{ errors.subcategory }}-->
                                <!--                                        </div>-->
                                <!--                                    </div>-->
                                <!--                                </div>-->

                                <!-- ////////////////////////////////////////// -->

                                <div class="m-4">
                                    <label for="brand" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Marka</label>
                                    <select v-model="form.brand_id" name="brand" id="brand" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option selected disabled>-- Wybierz markę --</option>
                                        <option v-for="brand in brands" :value="brand.id">{{ brand.name }}</option>
                                    </select>
                                    <div class="text-red-600 mt-1">
                                        <div v-if="errors.brand_id" class="text-red-600">
                                            {{ errors.brand_id }}
                                        </div>
                                    </div>
                                </div>

                                <div class="m-4">
                                    <label for="color" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Kolor</label>
                                    <select v-model="form.color" id="color" name="color" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option selected disabled>-- Wybierz kolor --</option>
                                        <option v-for="(index, color) in colors">
                                            {{ color }}
                                        </option>
                                    </select>
                                    <div class="text-red-600 mt-1">
                                        <div v-if="errors.color" class="text-red-600">
                                            {{ errors.color }}
                                        </div>
                                    </div>
                                    <!--                                <div class="p-6 ml-2 rounded-full border border-black" :class="[colors[form.color]]"></div>-->
                                </div>

                                <div class="m-4">
                                    <label for="typ" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Wybierz typ i rozmiar</label>
                                    <div class="flex">
                                        <select v-model="form.types" name="typ" id="typ" class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600">
                                            <option selected disabled>-- Wybierz typ --</option>
                                            <option v-for="typ in types">{{ typ }}</option>
                                        </select>
                                        <div class="text-red-600 mt-1">
                                            <div v-if="errors.types" class="text-red-600">
                                                {{ errors.types }}
                                            </div>
                                        </div>

                                        <label for="size" class="sr-only">Wybierz rozmiar</label>
                                        <select v-model="form.size" name="size" id="size"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg border-l-gray-100 dark:border-l-gray-700 border-l-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option selected disabled>-- Wybierz rozmiar --</option>
                                            <option v-for="size in sizes[form.types]">{{ size }}</option>
                                        </select>
                                    </div>
                                    <div class="text-red-600 mt-1">
                                        <div v-if="errors.size" class="text-red-600">
                                            {{ errors.size }}
                                        </div>
                                    </div>
                                </div>


                                <div class="m-4">
                                    <label for="material" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Materiał</label>
                                    <select v-model="form.material" name="material" id="material" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option selected disabled>-- Wybierz materiał --</option>
                                        <option v-for="material in materials">{{ material }}</option>
                                    </select>
                                    <div class="text-red-600 mt-1">
                                        <div v-if="errors.material" class="text-red-600">
                                            {{ errors.material }}
                                        </div>
                                    </div>
                                </div>

                                <div class="m-4">
                                    <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Cena</label>
                                    <input v-model="form.price" id="price" type="number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <div class="text-red-600 mt-1">
                                        <div v-if="errors.price" class="text-red-600">
                                            {{ errors.price }}
                                        </div>
                                    </div>
                                </div>

                                <div class="m-4">
                                    <label for="in_stock" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Ilość</label>
                                    <input v-model="form.in_stock" id="in_stock" type="number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <div class="text-red-600 mt-1">
                                        <div v-if="errors.in_stock" class="text-red-600">
                                            {{ errors.in_stock }}
                                        </div>
                                    </div>
                                </div>

                                <div class="m-4">
                                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Description</label>
                                    <textarea
                                        name="description"
                                        id="description"
                                        cols="100"
                                        rows="6"
                                        v-model="form.description"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    ></textarea>
                                    <div class="text-red-600 mt-1 w-full">
                                        <div v-if="errors.description" class="text-red-600">
                                            {{ errors.description }}
                                        </div>
                                    </div>

                                    <!-------------- ------------------>

                                    <div class="mt-4">
                                        <p class="font-bold text-xl">Zdjęcie główne</p>

                                        <div class="flex items-center justify-center w-full">
                                            <label for="image" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">

                                                <div v-if="!form.image">
                                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                        <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">Click to upload</p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                                                    </div>
                                                </div>
                                                <div class="flex flex-col items-center justify-center pt-5 pb-6" v-else>

                                                    <img :src="image_path(form.image)" :alt="form.image" class="rounded mt-2" width="400" v-if="!file.src">

                                                    <img :src="file.src" :alt="file.src" class="rounded mt-2" width="400" v-else>
                                                </div>
                                                <input @input="getImage" id="image" name="image" type="file" class="hidden" />
                                            </label>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <p class="text-xl font-bold">Galeria zdjęć</p>
                                        <FilePond
                                            name="images"
                                            ref="filepondGalleryInput"
                                            class-name="my-pond"
                                            allow-multiple="true"
                                            accepted-file-types="image/*"
                                            @init="handleFilePondInit"
                                            @processfile="handleFilePondGalleryProcess"
                                            @removefile="handleFilePondGalleryRemoveFile"
                                        />
                                    </div>


                                    <!-------------- ---------------->

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
                    </form>

                </div>
            </div>
        </div>
    </AdminLayout>
</template>


<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import {useForm} from "@inertiajs/inertia-vue3";
import {ref} from "vue";
import vueFilePond, {setOptions} from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFilePoster from 'filepond-plugin-file-poster';
import 'filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css';
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import {Inertia} from "@inertiajs/inertia";

const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
    FilePondPluginFilePoster
);

const isLoading = ref(false);

const props = defineProps({
    errors: Object,
    product: Object,
    categories: Object,
    brands: Object,
    subcategories: Object,
    csrf_token: String
});

const form = useForm(props.product);
const file = useForm({
    src: '',
    image: {}
});

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
};

const types = [
    'Spodnie', 'Buty', 'Odzież'
];

const sizes = {
    'Odzież': ['XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL'],
    'Buty': ['36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50'],
    'Spodnie': ['26', '28', '30', '32', '34']
};

const materials = [
    'Bawełna', 'Wełna', 'Jedwab', 'Poliester', 'Wiskoza', 'Skóra', 'Kaszmir', 'Dżersej'
];

const image_path = (image) => {
    image = JSON.parse(image)
    return '/uploads/products/main/' + image;
};

// Main image
const getImage = function (e) {
    const selectedFiles = e.target.files;

    for (let i = 0; i < selectedFiles.length; i++) {
        file.image = selectedFiles[i];
        file.src = URL.createObjectURL(selectedFiles[i]);
    }
}

// Gallery images
let myFiles = ref([]);

const handleInit = () => {
    const arr = form.images ? form.images : [];

    myFiles = [];

    for(let i =0; i < arr.length; i++){
        const item = arr[i];

        myFiles.push({
            source: '/' + item.serverId,
            options: {
                type: 'local',
                metadata: {
                    poster: '/' + item.serverId
                }
            }
        });
    }

    setOptions({
        server: {
            url: route('admin.product.index'),
            headers: {
                'X-CSRF-TOKEN': props.csrf_token,
            },
        },
        files: myFiles
    });
};

const handleFilePondInit = () => {
    setOptions({
        credits: false,
        server: {
            url: route('admin.product.images.upload'),
            headers: {
                'X-CSRF-TOKEN': props.csrf_token,
            },
            withCredentials: false,
        },
    });
};

handleInit()

const handleFilePondGalleryProcess = (error, file) => {
    form.images.push({id: file.id, serverId: file.serverId, size: file.fileSize, originalFilename: file.filename, fileExtension: file.fileExtension});
};

const handleFilePondGalleryRemoveFile = (error, file) => {
    form.images = form.images.filter(item => item.id !== file.id);
    form.images = form.images.filter(item => '/' + item.serverId !== file.serverId);
};

function updateProduct() {
    Inertia.post(route('admin.product.update', props.product.id), {
        _method: 'put',
        form: form,
        image: file.image
    })
}
</script>
