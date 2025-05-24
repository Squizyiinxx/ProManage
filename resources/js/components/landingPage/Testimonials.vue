<script setup lang="ts">
import TestimonialCard from './TestimonialCard.vue';

const isTestimonialVisible = true;
</script>

<template>
    <section id="testimonials" class="py-16 md:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mx-auto mb-16 max-w-3xl text-center">
                <h2 class="mb-4 text-3xl font-bold">Apa Kata Klien Kami</h2>
                <p class="text-muted-foreground text-lg">Perusahaan terkemuka telah meningkatkan produktivitas mereka dengan ProManage</p>
            </div>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <TestimonialCard
                    name="Sarah Johnson"
                    title="CTO, TechVision Corp"
                    :stars="3"
                    :isTestimonialVisible="isTestimonialVisible"
                    message="ProManage telah mengubah cara tim kami mengelola proyek. Dengan fitur impor/ekspor Excel dan notifikasi realtime, efisiensi kami meningkat lebih dari 40%. Sangat direkomendasikan!"
                    :delay="0"
                />

                <TestimonialCard
                    name="Andi Wijaya"
                    title="Project Manager, InoCorp"
                    :stars="5"
                    message="Sistem role & permission management ProManage sangat fleksibel untuk struktur tim kami yang kompleks. Tracking histori perubahan membuat akuntabilitas tim meningkat drastis."
                    :delay="200"
                />

                <TestimonialCard
                    name="Dian Sastro"
                    title="CEO, CreativeHub"
                    :stars="4"
                    message="Dengan dashboard intuitif dan laporan stok realtime, kami bisa mengambil keputusan cepat tanpa kehilangan momentum bisnis. Dukungan teknis mereka juga sangat responsif."
                    :delay="400"
                />
            </div>
        </div>
    </section>
</template>
