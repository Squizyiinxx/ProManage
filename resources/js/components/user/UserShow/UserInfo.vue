<script setup lang="ts">
import CardList from '@/components/CardList.vue';
import Card from '@/layouts/Card.vue';
import { RoleProps, User } from '@/types';
import { CheckCircle, Folder, Mail, Workflow, XCircle } from 'lucide-vue-next';

defineProps<{
    user: User<RoleProps>;
    title?: string;
}>();
</script>

<template>
    <Card>
        <template #icon>
            <Folder class="text-primary mr-2 h-5 w-5" />
        </template>
        <template #main>
            <div class="mb-6 space-y-3">
                <CardList title="User ID">
                    <span class="col-span-2 font-mono text-sm">{{ user.id }}</span>
                </CardList>
                <CardList title="User Name"> <Workflow class="mr-2 h-5 w-5 text-blue-500" /> {{ user.name }} </CardList>
                <CardList title="Email"> <Mail class="mr-2 h-5 w-5 text-yellow-500" /> {{ user.email }} </CardList>
                <CardList title="Active">
                    <component
                        :is="user.is_active ? CheckCircle : XCircle"
                        :class="['mr-2 h-5 w-5', user.is_active ? 'text-green-500' : 'text-red-400']"
                    />
                    {{ user.is_active ? 'Active' : 'Inactive' }}
                </CardList>
            </div>
        </template>
    </Card>
</template>
