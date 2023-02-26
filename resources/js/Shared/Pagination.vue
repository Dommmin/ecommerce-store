<template>
    <div class="mt-6">
        <template v-for="link in links">
            <Link
                v-if="link.url"
                :href="link.url"
                v-html="link.label"
                class="px-1"
                :class="link.active ? 'font-bold' : ''"
            />
            <span
                v-else
                v-html="link.label"
                :class="link.url ? '' : 'text-gray-500'"
            />
        </template>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    links: Array,
});

</script>
