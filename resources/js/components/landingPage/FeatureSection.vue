<script setup lang="ts">
import { features } from '@/constants';
import { onMounted, ref } from 'vue';
import CardFeature from './CardFeature.vue';

const isFeatureVisible = ref(false);

onMounted(() => {
    setTimeout(() => {
        isFeatureVisible.value = true;
    }, 100);
});
</script>

<template>
    <section id="features" class="bg-muted/50 py-16 md:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mx-auto mb-16 max-w-3xl text-center">
                <h2 class="mb-4 text-3xl font-bold">Fitur</h2>
                <p class="text-muted-foreground text-lg">Semua yang Anda butuhkan dalam satu platform manajemen proyek yang terunifikasi.</p>
            </div>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <CardFeature
                    v-for="(feature, index) in features"
                    :key="index"
                    :title="feature.title"
                    :description="feature.description"
                    :is-feature-visible="isFeatureVisible"
                    :delay="feature.delay"
                >
                    <template #icon>
                        <component :is="feature.icon" class="h-6 w-6" />
                    </template>
                </CardFeature>
            </div>
        </div>
    </section>
</template>
