<script setup lang="ts">
import CardList from '@/components/CardList.vue';
import Card from '@/layouts/Card.vue';
import { Client } from '@/types';
import { Building2, CheckCircle, Folder, MapPin, Phone, User2, Workflow, XCircle } from 'lucide-vue-next';

defineProps<{
    client: Client;
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
                <CardList title="Client ID">
                    <span class="col-span-2 font-mono text-sm">{{ client.id }}</span>
                </CardList>
                <CardList title="Client Name"> <Workflow class="mr-2 h-5 w-5 text-blue-500" /> {{ client.name }} </CardList>
                <CardList title="Email"> <User2 class="mr-2 h-5 w-5 text-blue-500" /> {{ client.email }} </CardList>
                <CardList title="Phone"> <Phone class="mr-2 h-5 w-5 text-blue-500" /> {{ client.phone || '-' }} </CardList>
                <CardList title="Company"> <Building2 class="mr-2 h-5 w-5 text-blue-500" /> {{ client.company }} </CardList>
                <CardList title="Address"> <MapPin class="mr-2 h-5 w-5 text-yellow-500" /> {{ client.address || '-' }} </CardList>
                <CardList title="Active">
                    <component
                        :is="client.is_active ? CheckCircle : XCircle"
                        :class="['mr-2 h-5 w-5', client.is_active ? 'text-green-500' : 'text-red-400']"
                    />
                    {{ client.is_active ? 'Active' : 'Inactive' }}
                </CardList>
            </div>
        </template>
    </Card>
</template>
