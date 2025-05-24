<script setup lang="ts">
import { pricingPlans } from '@/constants';
import { onMounted, ref } from 'vue';
import PricingCard from './PricingCard.vue';

const isPricingVisible = ref(false);

onMounted(() => {
    const observer = new IntersectionObserver(
        ([entry]) => {
            if (entry.isIntersecting) {
                isPricingVisible.value = true;
                observer.disconnect();
            }
        },
        { threshold: 0.1 },
    );

    const section = document.getElementById('pricing');
    if (section) observer.observe(section);

    return () => observer.disconnect();
});
</script>

<template>
    <section id="pricing" class="bg-muted/50 py-16 md:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mx-auto mb-16 max-w-3xl text-center">
                <h2 class="mb-4 text-3xl font-bold">Paket Harga Transparan</h2>
                <p class="text-muted-foreground text-lg">Pilih paket yang sesuai dengan kebutuhan bisnis Anda</p>
            </div>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <PricingCard :plan="pricingPlans.starter" :animate="isPricingVisible" class="transition-all duration-200 hover:shadow-md" />

                <PricingCard
                    :plan="pricingPlans.professional"
                    :animate="isPricingVisible"
                    :delay="200"
                    :is-recommended="true"
                    class="z-10 scale-105 shadow-md"
                />

                <PricingCard
                    :plan="pricingPlans.enterprise"
                    :animate="isPricingVisible"
                    :delay="400"
                    class="transition-all duration-200 hover:shadow-md"
                />
            </div>
        </div>
    </section>
</template>
