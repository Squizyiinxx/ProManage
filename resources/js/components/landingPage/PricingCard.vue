<script setup lang="ts">
import { CheckIcon, XIcon } from 'lucide-vue-next';

defineProps({
    plan: {
        type: Object,
        required: true,
    },
    animate: {
        type: Boolean,
        default: false,
    },
    delay: {
        type: Number,
        default: 0,
    },
    isRecommended: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <div
        class="bg-card overflow-hidden rounded-lg border"
        :class="[
            {
                'animate-fadeUp': animate,
                'border-primary border-2': isRecommended,
                'border-border': !isRecommended,
            },
            { [`animation-delay-${delay}`]: delay },
        ]"
    >
        <div v-if="isRecommended" class="bg-primary text-primary-foreground py-2 text-center text-sm font-medium">REKOMENDASI</div>
        <div class="p-6">
            <h3 class="mb-2 text-xl font-semibold">{{ plan.name }}</h3>
            <p class="text-muted-foreground mb-4">{{ plan.description }}</p>

            <div class="mb-6">
                <span class="text-4xl font-bold">{{ plan.price }}</span>
                <span class="text-muted-foreground">{{ plan.interval }}</span>
            </div>
            <ul class="mb-6 space-y-3">
                <li
                    v-for="(feature, index) in plan.features"
                    :key="index"
                    class="flex items-center"
                    :class="{ 'text-muted-foreground': !feature.included }"
                >
                    <CheckIcon v-if="feature.included" class="text-secondary mr-2 h-5 w-5" />
                    <XIcon v-else class="mr-2 h-5 w-5" />
                    <span>{{ feature.text }}</span>
                </li>
            </ul>
        </div>

        <div class="bg-muted p-6">
            <a
                :href="plan.ctaLink"
                class="block w-full rounded-md px-4 py-2 text-center font-medium transition-colors duration-200"
                :class="[
                    plan.isPrimary
                        ? 'bg-primary text-primary-foreground hover:bg-primary/90 border border-transparent'
                        : 'border-border bg-card text-foreground hover:bg-muted border',
                ]"
            >
                {{ plan.ctaText }}
            </a>
        </div>
    </div>
</template>

<style scoped>
.animate-fadeUp {
    animation: fadeUp 0.6s ease-out forwards;
    opacity: 0;
}

@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animation-delay-200 {
    animation-delay: 0.2s;
}

.animation-delay-400 {
    animation-delay: 0.4s;
}
</style>
