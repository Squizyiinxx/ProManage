<script setup lang="ts">
import FeatureSection from '@/components/landingPage/FeatureSection.vue';
import Footer from '@/components/landingPage/Footer.vue';
import Header from '@/components/landingPage/Header.vue';
import HeroSection from '@/components/landingPage/HeroSection.vue';
import PricingSection from '@/components/landingPage/PricingSection.vue';
import Testimonials from '@/components/landingPage/Testimonials.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div class="bg-background text-foreground min-h-screen overflow-x-hidden font-sans">
        <Header />
        <HeroSection />
        <FeatureSection />
        <Testimonials />
        <PricingSection />
        <Footer />
    </div>
</template>
