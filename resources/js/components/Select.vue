<script setup lang="ts">
import { useVModel } from '@vueuse/core';
import { CheckCheck, ChevronDown, ChevronUp } from 'lucide-vue-next';
import {
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectItemIndicator,
    SelectItemText,
    SelectLabel,
    SelectPortal,
    SelectRoot,
    SelectScrollDownButton,
    SelectScrollUpButton,
    SelectSeparator,
    SelectTrigger,
    SelectValue,
    SelectViewport,
} from 'reka-ui';

const props = defineProps<{
    defaultValue?: string | number;
    modelValue?: string | number;
    title?: string;
    options: any[] | null;
}>();

const emits = defineEmits<{
    (e: 'update:modelValue', payload: string | number): void;
}>();

const modelValue = useVModel(props, 'modelValue', emits, {
    passive: true,
    defaultValue: props.defaultValue,
});
</script>

<template>
    <SelectRoot v-model="modelValue">
        <SelectTrigger
            class="bg-primary data-[placeholder]:text-accent-foreground inline-flex h-[35px] w-full items-center justify-between gap-[5px] rounded-lg border px-[15px] text-sm leading-none shadow-sm outline-none"
            aria-label="Customise options"
        >
            <SelectValue class="text-primary-foreground" :placeholder="`Select ${props.title}...`" />
            <ChevronDown />
        </SelectTrigger>

        <SelectPortal>
            <SelectContent
                class="bg-primary-foreground data-[side=top]:animate-slideDownAndFade hover:data-[side=top]:animate-slideDownAndFade data-[side=right]:animate-slideLeftAndFade data-[side=bottom]:animate-slideUpAndFade data-[side=left]:animate-slideRightAndFade z-[100] min-w-[160px] rounded-lg border shadow-sm will-change-[opacity,transform]"
                :side-offset="5"
            >
                <SelectScrollUpButton class="text-violet11 flex h-[25px] cursor-default items-center justify-center bg-white">
                    <ChevronUp class="text-primary h-4 w-4" />
                </SelectScrollUpButton>

                <SelectViewport class="p-[5px]">
                    <SelectLabel class="text-mauve11 px-[25px] text-xs leading-[25px]">
                        <span class="text-primary-foreground text-xs leading-none">Select {{ props.title }}</span>
                    </SelectLabel>
                    <SelectGroup>
                        <SelectItem
                            v-for="(option, index) in props.options"
                            :key="index"
                            class="text-foreground data-[disabled]:text-muted data-[highlighted]:bg-primary data-[highlighted]:text-primary-foreground relative flex h-[25px] items-center rounded-[3px] pr-[35px] pl-[25px] text-xs leading-none select-none data-[disabled]:pointer-events-none data-[highlighted]:cursor-pointer data-[highlighted]:outline-none"
                            :value="option?.id || option?.uuid"
                        >
                            <SelectItemIndicator class="absolute left-0 inline-flex w-[25px] items-center justify-center">
                                <CheckCheck class="text-primary h-4 w-4" />
                            </SelectItemIndicator>
                            <SelectItemText class="text-sm font-bold">
                                {{ option.name }}
                            </SelectItemText>
                        </SelectItem>
                    </SelectGroup>
                    <SelectSeparator class="bg-green6 m-[5px] h-[1px]" />
                </SelectViewport>

                <SelectScrollDownButton class="text-violet11 flex h-[25px] cursor-default items-center justify-center bg-white">
                    <ChevronDown class="text-primary-foreground h-4 w-4" />
                </SelectScrollDownButton>
            </SelectContent>
        </SelectPortal>
    </SelectRoot>
</template>
