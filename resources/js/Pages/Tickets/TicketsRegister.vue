<!--<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

// Inicializamos o formulário com os campos que você usa no Service/Controller
const form = useForm({
    ticket_subject: '',
    ticket_description: '',
    project_id: '',
    // Adicione outros campos se necessário
});

const submit = () => {
    // Envia para a rota 'tickets.store' que você já tem no Controller
    form.post(route('tickets.store'), {
        onSuccess: () => form.reset(), // Limpa o form se der certo
    });
};
</script>

<template>
    <Head title="Criar Ticket" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Novo Chamado
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6 text-gray-900">

                        <form @submit.prevent="submit" class="space-y-6 max-w-xl">
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Assunto do Ticket</label>
                                <input
                                    v-model="form.ticket_subject"
                                    type="text"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    placeholder="Ex: Erro ao carregar página"
                                    required
                                />
                                <div v-if="form.errors.ticket_subject" class="text-red-600 text-sm mt-1">
                                    {{ form.errors.ticket_subject }}
                                </div>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700">Descrição Detalhada</label>
                                <textarea
                                    v-model="form.ticket_description"
                                    rows="4"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    placeholder="Descreva o problema aqui..."
                                ></textarea>
                                <div v-if="form.errors.ticket_description" class="text-red-600 text-sm mt-1">
                                    {{ form.errors.ticket_description }}
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    {{ form.processing ? 'Enviando...' : 'Salvar Ticket' }}
                                </button>

                                <Transition
                                    enter-active-class="transition ease-in-out"
                                    enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out"
                                    leave-to-class="opacity-0"
                                >
                                    <p v-if="form.recentlySuccessful" class="text-sm text-green-600">
                                        Ticket enviado com sucesso!
                                    </p>
                                </Transition>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>-->