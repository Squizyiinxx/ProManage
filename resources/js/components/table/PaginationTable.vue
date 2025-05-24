<script setup lang="ts">
import { Pagination } from '@/types';
import { Link } from '@inertiajs/vue3';
import { computed, defineProps } from 'vue';

const props = defineProps<{
    pagination?: Pagination<any[]> | null;
}>();

const getPageLink = (page: number) => {
    const query = new URLSearchParams(window.location.search);
    query.set('page', page.toString());
    return `${props.pagination?.path}?${query.toString()}`;
};

const visibleLinks = computed(() => {
    return (
        props.pagination?.links?.filter((link) => link.url && !['previous', 'next'].some((keyword) => link.label.toLowerCase().includes(keyword))) ||
        []
    );
});
</script>

<template>
    <div v-if="pagination && pagination.total > pagination.per_page" class="pagination my-4 flex justify-start space-x-2">
        <Link
            v-if="pagination.current_page > 1"
            :href="getPageLink(pagination.current_page - 1)"
            class="bg-primary-foreground rounded px-4 py-2 text-white disabled:opacity-50"
        >
            Prev
        </Link>
        <Link
            v-for="(link, index) in visibleLinks"
            :aria-current="link.active ? 'page' : null"
            :aria-label="`Go to page ${link.label}`"
            :key="index"
            :href="link.url ?? ''"
            :class="['rounded px-4 py-2 text-white shadow-md', link.active ? 'bg-primary' : 'bg-primary-foreground']"
        >
            {{ link.label }}
        </Link>

        <Link
            v-if="pagination && pagination.current_page < pagination.last_page"
            :href="getPageLink(pagination.current_page + 1)"
            class="bg-primary-foreground rounded px-4 py-2 text-white disabled:opacity-50"
        >
            Next
        </Link>
    </div>
</template>

<style scoped>
.pagination a {
    transition: background-color 0.3s;
}
</style>
