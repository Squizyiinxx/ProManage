<script setup lang="ts">
import Card from '@/layouts/Card.vue';
import { Link } from '@inertiajs/vue3';
import { ArrowRightIcon } from 'lucide-vue-next';

defineProps<{
    data?: Array<unknown>;
    viewAllRoute: string;
    title: string;
}>();
</script>

<template>
    <Card :title="title" class-props="w-full">
        <template #icon>
            <div>
                <slot name="icon" />
            </div>
        </template>
        <template #main>
            <div class="mb-6 space-y-3">
                <slot name="main" />
                <div class="flex w-full items-center justify-end">
                    <Link v-if="data?.length === 3" :href="viewAllRoute" class="text-primary flex items-center gap-x-2"
                        >View All <ArrowRightIcon class="h-5 w-5" />
                    </Link>
                </div>
            </div>
        </template>
    </Card>
</template>
