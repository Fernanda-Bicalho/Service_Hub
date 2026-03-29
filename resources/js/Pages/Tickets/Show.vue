<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';

const props = defineProps({
    ticket: Object
});

// 🎨 Status visual
const statusMap = {
    pending: { label: 'Pendente', color: 'bg-yellow-100 text-yellow-800' },
    processing: { label: 'Processando', color: 'bg-blue-100 text-blue-800' },
    done: { label: 'Concluído', color: 'bg-green-100 text-green-800' },
    error: { label: 'Erro', color: 'bg-red-100 text-red-800' },
};

// 🔙 voltar
const goBack = () => {
    router.visit(route('tickets.index'));
};
</script>

<template>
    <Head title="Detalhe do Ticket" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">
                    Detalhe do Ticket
                </h2>

                <button
                    @click="goBack"
                    class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300 text-sm"
                >
                    ← Voltar
                </button>
            </div>
        </template>

        <div class="py-10">
            <div class="mx-auto max-w-5xl space-y-6 sm:px-6 lg:px-8">

                <!-- 📌 CARD PRINCIPAL -->
                <div class="bg-white shadow rounded-lg p-6 border">

                    <div class="flex justify-between items-start mb-4">
                        <h1 class="text-2xl font-bold text-gray-900">
                            {{ ticket.ticket_title }}
                        </h1>

                        <span
                            :class="[
                                'px-3 py-1 rounded text-xs font-semibold',
                                statusMap[ticket.ticket_status]?.color
                            ]"
                        >
                            {{ statusMap[ticket.ticket_status]?.label }}
                        </span>
                    </div>

                    <p class="text-gray-600">
                        {{ ticket.ticket_description || 'Sem descrição' }}
                    </p>

                </div>

                <!-- 📊 INFORMAÇÕES -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- 🏢 Projeto -->
                    <div class="bg-white shadow rounded-lg p-5 border">
                        <h3 class="font-semibold text-gray-700 mb-2">
                            Projeto
                        </h3>

                        <p class="text-gray-900 font-medium">
                            {{ ticket.project?.project_title }}
                        </p>

                        <p class="text-sm text-gray-500">
                            Empresa: {{ ticket.project?.company?.company_name }}
                        </p>
                    </div>

                    <!-- 👤 Usuário -->
                    <div class="bg-white shadow rounded-lg p-5 border">
                        <h3 class="font-semibold text-gray-700 mb-2">
                            Responsável
                        </h3>

                        <p class="text-gray-900 font-medium">
                            {{ ticket.user?.name }}
                        </p>

                        <p class="text-sm text-gray-500">
                            {{ ticket.user?.email }}
                        </p>
                    </div>

                </div>

                <!-- 📎 ANEXO -->
                <div v-if="ticket.ticket_attachment" class="bg-white shadow rounded-lg p-5 border">
                    <h3 class="font-semibold text-gray-700 mb-2">
                        Anexo
                    </h3>

                    <a
                        :href="`/storage/${ticket.ticket_attachment}`"
                        target="_blank"
                        class="text-indigo-600 hover:underline text-sm"
                    >
                        Visualizar arquivo
                    </a>
                </div>

                <!-- ⚙️ PROCESSAMENTO -->
                <div class="bg-white shadow rounded-lg p-5 border">

                    <h3 class="font-semibold text-gray-700 mb-4">
                        Processamento
                    </h3>

                    <div v-if="ticket.detail">

                        <div class="text-sm text-gray-600 mb-2">
                            Processado em:
                            <strong>
                                {{ ticket.detail.ticket_details_processed_at }}
                            </strong>
                        </div>

                        <!-- 📊 JSON formatado -->
                        <div class="mt-4">
                            <h4 class="text-sm font-semibold mb-2">
                                Dados enriquecidos
                            </h4>

                            <pre class="bg-gray-900 text-green-400 text-xs p-4 rounded overflow-auto">
                               {{ JSON.stringify(JSON.parse(ticket.detail.ticket_details_enriched_data), null, 2) }}
                            </pre>
                        </div>

                    </div>

                    <div v-else class="text-gray-500 text-sm">
                        Ainda não processado...
                    </div>

                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>