<script setup lang="ts">
import RelatedLayout from '@/layouts/RelatedLayout.vue';
import { Task } from '@/types';
import { Link } from '@inertiajs/vue3';
import { CheckCircle, PencilLine, Timer, TimerResetIcon } from 'lucide-vue-next';
import CardList from '../../CardList.vue';

defineProps<{
    tasks?: Task[] | [];
    projectName?: string;
    title: string;
}>();
</script>

<template>
    <RelatedLayout :title="title" :data="tasks" :view-all-route="`/tasks?search=${projectName}&sortBy=created_at&sortOrder=desc&trashed=false`">
        <template #icon>
            <PencilLine class="text-primary mr-2 h-5 w-5" />
        </template>
        <template #main>
            <div v-if="tasks?.length === 0" class="text-center text-gray-500">
                <p>No related tasks available.</p>
            </div>
            <CardList v-else v-for="task in tasks" :key="task.id" class="flex items-center font-mono text-sm">
                <span
                    :class="[
                        'h-4 w-4 rounded-full',
                        task?.priority === 'medium' ? 'bg-yellow-400' : task?.priority === 'low' ? 'bg-green-400' : 'bg-red-500',
                    ]"
                />
                <Link :href="route('tasks.show', task?.id)" class="hover:text-primary col-span-2 font-mono text-sm capitalize hover:underline">{{
                    task?.title
                }}</Link>
                <span class="col-span-2 rounded-lg font-mono text-sm shadow-sm">
                    <CheckCircle v-if="task?.status === 'completed'" class="mr-2 h-5 w-5 text-green-500" />
                    <Timer v-if="task?.status === 'pending'" class="mr-2 h-5 w-5 text-white" />
                    <TimerResetIcon v-if="task?.status === 'in_progress'" class="mr-2 h-5 w-5 text-yellow-500" />
                </span>
            </CardList>
        </template>
    </RelatedLayout>
</template>
