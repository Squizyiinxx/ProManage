<script setup lang="ts">
import { ChevronDown } from 'lucide-vue-next';
import { AccordionContent, AccordionHeader, AccordionItem, AccordionRoot, AccordionTrigger } from 'reka-ui';

defineProps<{
    data: any[];
    title: string;
}>();
</script>

<template>
    <AccordionRoot
        class="bg-sidebar w-full rounded-lg border shadow-[0_2px_10px] shadow-black/5"
        default-value="item-1"
        type="multiple"
        :collapsible="true"
    >
        <div v-if="data.length > 0">
            <template v-for="item in data" :key="item.name">
                <AccordionItem
                    class="mt-px overflow-hidden first:mt-0 first:rounded-t-[7px] last:rounded-b-[7px] focus-within:relative focus-within:z-10 focus-within:shadow-[0_0_0_2px] focus-within:shadow-slate-800/50"
                    :value="item.name"
                >
                    <AccordionHeader class="flex">
                        <AccordionTrigger
                            class="text-foreground shadow-priamary bg-secondary group flex h-[45px] flex-1 cursor-pointer items-center justify-between px-5 text-sm leading-none outline-none"
                        >
                            <span class="text-lg font-semibold capitalize">{{ item.name }}</span>
                            <ChevronDown
                                class="text-foreground transition-transform duration-200 ease-in-out group-data-[state=open]:rotate-180"
                                width="20"
                                height="20"
                            />
                        </AccordionTrigger>
                    </AccordionHeader>
                    <AccordionContent
                        class="text-foreground bg-accent data-[state=open]:animate-accordion-down data-[state=closed]:animate-accordion-up overflow-hidden text-sm"
                    >
                        <div class="px-5 py-4">
                            {{ item.name }}
                        </div>
                    </AccordionContent>
                </AccordionItem>
            </template>
        </div>
    </AccordionRoot>
</template>
