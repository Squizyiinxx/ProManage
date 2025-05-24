<script setup lang="ts">
import { onMounted, ref } from 'vue';
import Trusted from './Trusted.vue';

const isVisible = ref(false);

onMounted(() => {
    setTimeout(() => {
        isVisible.value = true;
    }, 300);
});
</script>

<template>
    <section class="bg-background pt-32 pb-20 md:pt-40 md:pb-28">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 items-center gap-12 lg:grid-cols-2">
                <div class="space-y-8 transition-opacity duration-1000 ease-in-out" :class="{ 'opacity-100': isVisible, 'opacity-0': !isVisible }">
                    <div class="space-y-4">
                        <div class="bg-accent text-accent-foreground inline-flex items-center rounded-full px-3 py-1 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                            <span>Platform Management Project #1 in Indonesia</span>
                        </div>
                        <h1 class="text-4xl leading-tight font-bold tracking-tight md:text-5xl lg:text-6xl">
                            <span class="text-foreground">Management Project Modern.</span>
                            <span class="text-primary block">Smarter Team Collaboration.</span>
                        </h1>
                        <p class="text-muted-foreground max-w-xl text-lg md:text-xl">
                            Sebuah platform berbasis web terintegrasi untuk mengelola tim, klien, proyek, dan tugas. Tingkatkan hasil dan efisiensi
                            tim Anda sekarang.
                        </p>
                    </div>

                    <div class="flex flex-col gap-4 sm:flex-row">
                        <a
                            href="/register"
                            class="text-primary-foreground bg-primary hover:bg-primary/90 inline-flex items-center justify-center rounded-md px-6 py-3 text-base font-medium shadow transition"
                        >
                            Ayoo Daftar
                        </a>
                        <a
                            href="/demo"
                            class="border-border bg-card hover:bg-muted inline-flex items-center justify-center rounded-md border px-6 py-3 text-base font-medium transition"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"
                                />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Demo
                        </a>
                    </div>
                    <Trusted />
                </div>

                <div
                    class="relative transform transition-all duration-1000 ease-in-out"
                    :class="{ 'translate-x-0 opacity-100': isVisible, 'translate-x-10 opacity-0': !isVisible }"
                >
                    <div class="from-primary to-secondary absolute -inset-0.5 rounded-xl bg-gradient-to-r opacity-30 blur"></div>
                    <div class="bg-card border-border relative overflow-hidden rounded-xl border shadow-xl">
                        <div class="bg-sidebar-background aspect-[16/9] w-full p-4">
                            <div class="flex h-full overflow-hidden rounded-lg">
                                <div class="bg-sidebar-background border-sidebar-border hidden w-48 flex-shrink-0 border-r p-4 md:block">
                                    <div class="bg-sidebar-accent mb-6 h-8 w-32 rounded"></div>
                                    <div class="space-y-3">
                                        <div class="bg-sidebar-accent h-6 w-full rounded"></div>
                                        <div class="bg-sidebar-accent h-6 w-full rounded"></div>
                                        <div class="bg-sidebar-primary h-6 w-full rounded"></div>
                                        <div class="bg-sidebar-accent h-6 w-full rounded"></div>
                                        <div class="bg-sidebar-accent h-6 w-full rounded"></div>
                                    </div>
                                </div>
                                <div class="bg-background flex-1 p-4">
                                    <div class="bg-card border-border mb-4 flex h-10 w-full items-center rounded-md border px-4">
                                        <div class="bg-muted h-4 w-1/3 rounded"></div>
                                    </div>
                                    <div class="mb-4 grid grid-cols-1 gap-4 md:grid-cols-3">
                                        <div class="bg-card border-border rounded-md border p-4">
                                            <div class="bg-primary mb-2 h-4 w-16 rounded"></div>
                                            <div class="mb-2 text-xl font-bold">24</div>
                                            <div class="bg-muted h-2 w-full rounded"></div>
                                        </div>
                                        <div class="bg-card border-border rounded-md border p-4">
                                            <div class="bg-secondary mb-2 h-4 w-16 rounded"></div>
                                            <div class="mb-2 text-xl font-bold">18</div>
                                            <div class="bg-muted h-2 w-full rounded"></div>
                                        </div>
                                        <div class="bg-card border-border rounded-md border p-4">
                                            <div class="bg-muted-foreground mb-2 h-4 w-16 rounded"></div>
                                            <div class="mb-2 text-xl font-bold">7</div>
                                            <div class="bg-muted h-2 w-full rounded"></div>
                                        </div>
                                    </div>
                                    <div class="bg-card border-border mb-4 rounded-md border p-4">
                                        <div class="bg-muted mb-4 h-4 w-32 rounded"></div>
                                        <div class="bg-muted h-24 w-full rounded-md"></div>
                                    </div>
                                    <div class="bg-card border-border rounded-md border p-4">
                                        <div class="bg-muted mb-2 h-4 w-32 rounded"></div>
                                        <div class="space-y-2">
                                            <div class="bg-muted h-8 w-full rounded"></div>
                                            <div class="bg-accent h-8 w-full rounded"></div>
                                            <div class="bg-muted h-8 w-full rounded"></div>
                                            <div class="bg-muted h-8 w-full rounded"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-secondary absolute -right-4 -bottom-4 h-24 w-24 rounded-full opacity-40 blur-2xl"></div>
                    <div class="bg-primary absolute -top-4 -left-4 h-24 w-24 rounded-full opacity-40 blur-2xl"></div>
                </div>
            </div>
        </div>
    </section>
</template>
