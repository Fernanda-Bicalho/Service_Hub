<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router} from '@inertiajs/vue3';
import { computed } from 'vue';
import { onMounted, ref } from 'vue';


const props = defineProps({
    tickets: Object,
    filters: Object,
    form: Object,
    projects: Array
});

// 🎨 Status visual
const statusMap = {
    pending: { label: 'Pendente', color: 'bg-yellow-100 text-yellow-800' },
    processing: { label: 'Processando', color: 'bg-blue-100 text-blue-800' },
    done: { label: 'Concluído', color: 'bg-green-100 text-green-800' },
    error: { label: 'Erro', color: 'bg-red-100 text-red-800' },
};

// 📌 Formulário
const form = useForm({
    ticket_title: '',
    ticket_description: '',
    project_id: '',
    ticket_attachment: null,
    
});

// 📎 Upload handler
const handleFile = (e) => {
    form.ticket_attachment = e.target.files[0];
};

// 🚀 Submit
const submit = () => {
    form.post(route('tickets.store'), {
        forceFormData: true,
        onSuccess: (page) => {
            // page.props.tickets agora contém o ticket recém-criado
            form.reset();
        },
    });
};

// 🔍 Filtro
const search = (e) => {
    router.get(route('tickets.index'), {
        search: e.target.value
    }, { preserveState: true });
};


const ticketsData = ref(props.tickets);

// função para atualizar a lista
const fetchTickets = () => {
    router.get(route('tickets.index'), {}, {
        preserveState: true,
        only: ['tickets'], // só atualiza os tickets
    });
};

onMounted(() => {
    // Atualiza a cada 5 segundos
    setInterval(fetchTickets, 5000);
});

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800">
                Gestão de Tickets
            </h2>
        </template>

        <div class="py-10">
            <div class="mx-auto max-w-7xl space-y-8 sm:px-6 lg:px-8">

                <!-- 🔥 FORM -->
                <div class="bg-white shadow-sm rounded-lg border p-6">
                    <h3 class="text-lg font-semibold mb-4">Criar Ticket</h3>

                    <form @submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label class="text-sm font-medium">Título</label>
                            <input v-model="form.ticket_title" type="text"
                                class="mt-1 w-full rounded border-gray-300 focus:ring-indigo-500" />
                            <p v-if="form.errors.ticket_title" class="text-red-500 text-xs">
                                {{ form.errors.ticket_title }}
                            </p>
                        </div>

                    <div>
                       <label class="text-sm font-medium">Projeto</label>
                        <select 
                         v-model="form.project_id"
                         class="mt-1 w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 transition-all"
                         >
                         <option value="" disabled>Selecione um projeto...</option>
                         <option v-for="project in projects" :key="project.id" :value="project.id">
                            {{ project.project_title }}
                           </option>
                     </select>
                 </div>

                        <div class="md:col-span-2">
                            <label class="text-sm font-medium">Descrição</label>
                            <textarea v-model="form.ticket_description"
                                class="mt-1 w-full rounded border-gray-300"></textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-sm font-medium"></label>
                            <input type="file" @change="handleFile" />
                        </div>

                        <div class="md:col-span-2">
                            <button type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                                {{ form.processing ? 'Salvando...' : 'Criar Ticket' }}
                            </button>
                            
                        </div>

                    </form>
                </div>

                <!-- 🔍 FILTRO -->
                <div class="flex justify-between items-center">
                    <input
                        type="text"
                        placeholder="Buscar ticket..."
                        class="border rounded px-3 py-2 w-64"
                        :value="filters.search"
                        @input="search"
                    />
                </div>

                <!-- 📊 LISTA -->
                <div class="bg-white shadow-sm rounded-lg border overflow-hidden">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100 text-left">
                            <tr>
                                <th class="p-3">Título</th>
                                <th>Projeto</th>
                                <th>Status</th>
                                <th>Usuário</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="ticket in tickets?.data || []" :key="ticket.id" class="border-t hover:bg-gray-50">

                                <td class="p-3 font-medium">
                                    {{ ticket.ticket_title }}
                                </td>

                                <td>
                                    {{ ticket.project?.project_title }}
                                </td>

                                <td>
                                    <span
                                        :class="['px-2 py-1 rounded text-xs font-semibold',
                                        statusMap[ticket.ticket_status]?.color]">
                                        {{ statusMap[ticket.ticket_status]?.label }}
                                    </span>
                                </td>

                                <td>
                                    {{ ticket.user?.name }}
                                </td>

                                <td>
                                    <a
                                        :href="route('tickets.show', ticket.id)"
                                        class="text-indigo-600 hover:underline"
                                    >
                                        Ver
                                    </a>
                                </td>

                            </tr>

                            <tr v-if="tickets.data.length === 0">
                                <td colspan="5" class="text-center p-6 text-gray-500">
                                    Nenhum ticket encontrado
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- 📄 PAGINAÇÃO -->
                <div class="flex gap-2">
                    <button
                        v-for="link in tickets.links"
                        :key="link.label"
                        v-html="link.label"
                        @click="link.url && router.visit(link.url)"
                        :class="[
                            'px-3 py-1 border rounded text-sm',
                            link.active ? 'bg-indigo-600 text-white' : ''
                        ]"
                    />
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>