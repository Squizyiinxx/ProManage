<script setup lang="ts">
import { X } from 'lucide-vue-next';
import { DialogClose, DialogContent, DialogOverlay, DialogPortal, DialogRoot, DialogTitle } from 'reka-ui';

const props = defineProps<{
    open?: boolean;
}>();

const emit = defineEmits<{
    'update:open': [value: boolean];
}>();

const handleClose = () => {
    emit('update:open', false);
};
const handleOpen = () => {
    emit('update:open', true);
};
</script>

<template>
    <DialogRoot :open="props.open" @update:open="emit('update:open', $event)" aria-describedby="dialog">
        <button @click="handleOpen" class="flex cursor-pointer items-center">
            <slot name="trigger" />
        </button>
        <DialogPortal>
            <DialogOverlay class="data-[state=open]:overlayShow fixed inset-0 z-30 bg-neutral-900/50 backdrop-blur-sm" />
            <DialogTitle aria-label="Dialog Title" class="text-primary-foreground text-2xl leading-6 font-semibold">
                <slot name="title" />
            </DialogTitle>
            <DialogContent
                aria-describedby="content"
                class="data-[state=open]:contentShow bg-card fixed top-[50%] left-[50%] z-[100] max-h-[85vh] w-full max-w-2xl translate-x-[-50%] translate-y-[-50%] rounded-[12px] p-[25px] shadow-xl focus:outline-none"
            >
                <slot name="contentMain" />
                <DialogClose
                    as-child
                    class="group absolute top-[10px] right-[10px] inline-flex w-12 cursor-pointer appearance-none items-center justify-center rounded-full p-1"
                    aria-label="Close"
                >
                    <button @click="handleClose">
                        <X class="group-hover:text-primary size-5 text-white" />
                    </button>
                </DialogClose>
            </DialogContent>
        </DialogPortal>
    </DialogRoot>
</template>
