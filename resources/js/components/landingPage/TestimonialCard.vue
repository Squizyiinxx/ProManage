<script setup lang="ts">
import { Star } from 'lucide-vue-next';

const props = defineProps<{
    name: string;
    title: string;
    stars: number;
    message: string;
    delay: number;
    isTestimonialVisible: boolean;
}>();
</script>

<template>
    <div
        :class="
            `bg-card border-border rounded-lg border p-6 shadow-sm transition-opacity duration-1000 ease-in-out ` +
            (isTestimonialVisible ? `animate-fadeIn opacity-100` : `opacity-0`) +
            `delay-[${props.delay}ms]`
        "
    >
        <div class="mb-4 flex items-center">
            <img
                class="h-12 w-12 rounded-full object-cover"
                :src="`https://api.dicebear.com/8.x/thumbs/svg?seed=${encodeURIComponent(props.name)}`"
                :alt="`Avatar of ${props.name}`"
            />
            <div class="ml-4">
                <h4 class="font-semibold">{{ props.name }}</h4>
                <p class="text-muted-foreground text-sm">{{ props.title }}</p>
            </div>
        </div>

        <div class="mb-4 flex text-yellow-400">
            <span v-for="index in props.stars" :key="index" class="text-yellow-400">
                <Star class="h-6 w-6" />
            </span>
        </div>

        <p class="text-foreground">"{{ props.message }}"</p>
    </div>
</template>

<style scoped>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.6s ease-out forwards;
}

.delay-0ms {
    animation-delay: 0ms;
}

.delay-200ms {
    animation-delay: 200ms;
}

.delay-400ms {
    animation-delay: 400ms;
}
</style>
