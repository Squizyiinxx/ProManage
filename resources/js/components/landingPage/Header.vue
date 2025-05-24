<script setup lang="ts">
import { ref } from 'vue';
const isMobile = ref(false);
const toggleSidebar = () => {
    isMobile.value = !isMobile.value;
};
</script>

<template>
    <nav class="bg-card/80 border-border fixed top-0 right-0 left-0 z-50 border-b backdrop-blur-md">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center gap-2 text-xl font-bold">
                    <img src="/assets/logoPro.png" alt="Promanage Logo" class="h-12 w-12" />
                    <span>ProManage</span>
                </div>

                <div class="hidden items-center space-x-8 md:flex">
                    <a href="#features" class="hover:text-primary font-medium transition">Fitur</a>
                    <a href="#testimonials" class="hover:text-primary font-medium transition">Testimoni</a>
                    <a href="#pricing" class="hover:text-primary font-medium transition">Harga</a>
                    <a href="#contact" class="hover:text-primary font-medium transition">Kontak</a>
                    <a href="/login" class="text-primary hover:text-primary/80 font-medium transition">Masuk</a>
                    <a
                        href="/register"
                        class="bg-primary text-primary-foreground hover:bg-primary/90 rounded-md px-4 py-2 text-sm font-medium transition"
                    >
                        Daftar Sekarang
                    </a>
                </div>

                <div class="md:hidden">
                    <button
                        @click="toggleSidebar"
                        class="text-foreground hover:text-primary hover:bg-muted focus:ring-ring rounded-md p-2 focus:ring-2 focus:outline-none"
                    >
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path v-if="!isMobile" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div v-if="isMobile" class="border-border bg-card border-t md:hidden">
            <div class="space-y-2 px-4 py-3">
                <a href="#features" class="hover:bg-muted block rounded-md px-3 py-2 text-base font-medium">Feature</a>
                <a href="#testimonials" class="hover:bg-muted block rounded-md px-3 py-2 text-base font-medium">Testimonials</a>
                <a href="#pricing" class="hover:bg-muted block rounded-md px-3 py-2 text-base font-medium">Pricing</a>
                <a href="#contact" class="hover:bg-muted block rounded-md px-3 py-2 text-base font-medium">Contact</a>
                <a href="/login" class="text-primary hover:bg-muted block rounded-md px-3 py-2 text-base font-medium">Masuk</a>
                <a
                    href="/register"
                    class="bg-primary text-primary-foreground hover:bg-primary/90 block w-full rounded-md px-3 py-2 text-base font-medium"
                >
                    Register Now
                </a>
            </div>
        </div>
    </nav>
</template>
