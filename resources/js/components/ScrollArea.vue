<script setup lang="ts">
import { ScrollAreaRoot, ScrollAreaScrollbar, ScrollAreaThumb, ScrollAreaViewport } from 'reka-ui';

defineProps<{
    title?: string;
}>();
</script>

<template>
    <ScrollAreaRoot class="relative h-[300px] w-full overflow-hidden rounded-lg border shadow-sm" style="--scrollbar-size: 10px">
        <div class="absolute top-0 z-10 h-6 w-full" />
        <ScrollAreaViewport class="h-full w-full rounded">
            <div class="px-5 py-[15px]">
                <div class="text-grass11 text-sm leading-tight font-semibold">
                    {{ title }}
                </div>
                <slot />
            </div>
        </ScrollAreaViewport>
        <ScrollAreaScrollbar
            class="bg-accent hover:bg-accent-foreground group z-20 flex touch-none p-0.5 transition-colors duration-200 ease-out select-none data-[orientation=horizontal]:h-2.5 data-[orientation=horizontal]:flex-col data-[orientation=vertical]:w-2.5"
            orientation="vertical"
        >
            <ScrollAreaThumb
                class="bg-primary group-hover:bg-accent relative flex-1 rounded-[10px] before:absolute before:top-1/2 before:left-1/2 before:h-full before:min-h-[44px] before:w-full before:min-w-[44px] before:-translate-x-1/2 before:-translate-y-1/2 before:content-['']"
            />
        </ScrollAreaScrollbar>
        <ScrollAreaScrollbar
            class="bg-accent hover:bg-accent-foreground flex touch-none p-0.5 transition-colors duration-[160ms] ease-out select-none data-[orientation=horizontal]:h-2.5 data-[orientation=horizontal]:flex-col data-[orientation=vertical]:w-2.5"
            orientation="horizontal"
        >
            <ScrollAreaThumb
                class="bg-primary relative flex-1 rounded-[10px] before:absolute before:top-1/2 before:left-1/2 before:h-full before:min-h-[44px] before:w-full before:min-w-[44px] before:-translate-x-1/2 before:-translate-y-1/2 before:content-['']"
            />
        </ScrollAreaScrollbar>
    </ScrollAreaRoot>
</template>
