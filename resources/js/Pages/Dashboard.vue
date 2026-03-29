<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router, usePage} from '@inertiajs/vue3';
import { computed } from 'vue';
import { onMounted, ref, watch } from 'vue';


const props = defineProps({
    tickets: Object,
    filters: Object,
    form: Object,
    projects: Array
});


const statusMap = {
    pending: { label: 'Pendente', color: 'bg-yellow-100 text-yellow-800' },
    processing: { label: 'Processando', color: 'bg-blue-100 text-blue-800' },
    done: { label: 'Concluído', color: 'bg-green-100 text-green-800' },
    error: { label: 'Erro', color: 'bg-red-100 text-red-800' },
};

const form = useForm({
    ticket_title: '',
    ticket_description: '',
    project_id: '',
    ticket_attachment: null,
    
});

const handleFile = (e) => {
    form.ticket_attachment = e.target.files[0];
};

const submit = () => {
    form.post(route('tickets.store'), {
        forceFormData: true,
        onSuccess: (page) => {
            form.reset();
            showToast('Ticket criado com sucesso!!!');
        },
    });
};

const search = (e) => {
    router.get(route('tickets.index'), {
        search: e.target.value
    }, { preserveState: true });
};


const ticketsData = ref(props.tickets);

const fetchTickets = () => {
    router.get(route('tickets.index'), {}, {
        preserveState: true,
        only: ['tickets'],
    });
};

onMounted(() => {
    setInterval(fetchTickets, 10000);
    if (page.props.flash?.success) {
        showToast(page.props.flash.success, 'success');
    }

});


/* TOAST */

const page = usePage();

const toasts = ref([]);

const showToast = (message, type = 'info') => {
    const id = Date.now();

    toasts.value.push({ id, message, type });

    setTimeout(() => {
        toasts.value = toasts.value.filter(t => t.id !== id);
    }, 4000);
};

const previousTickets = ref([]);

watch(
    () => props.tickets?.data,
    (newTickets) => {
        if (!previousTickets.value.length) {
            previousTickets.value = newTickets;
            return;
        }

        newTickets.forEach(ticket => {
            const old = previousTickets.value.find(t => t.id === ticket.id);

            if (old && old.ticket_status !== ticket.ticket_status) {

                if (ticket.ticket_status === 'done') {
                    showToast(`Ticket concluído`, 'success');
                }

                if (ticket.ticket_status === 'error') {
                    showToast(`Ticket falhou`, 'error');
                }

                if (ticket.ticket_status === 'processing') {
                    showToast(`Ticket em processamento`, 'info');
                }
            }
        });

        previousTickets.value = newTickets;
    },
    { deep: true }
);

/* TOAST */

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800">
                Gestão de Tickets
            </h2>
        </template>

        <div class="fixed top-5 right-5 space-y-2 z-50">
    <div
        v-for="toast in toasts"
        :key="toast.id"
        :class="[
            'px-4 py-3 rounded shadow-lg text-white text-sm font-semibold transition-all',
            toast.type === 'success' && 'bg-green-500',
            toast.type === 'error' && 'bg-red-500',
            toast.type === 'info' && 'bg-blue-500'
        ]"
    >
        {{ toast.message }}
    </div>
</div>

        <div class="py-10">
            <div class="mx-auto max-w-7xl space-y-8 sm:px-6 lg:px-8">

                
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

                <div class="flex justify-between items-center">
                    <input
                        type="text"
                        placeholder="Buscar ticket..."
                        class="border rounded px-3 py-2 w-64"
                        :value="filters.search"
                        @input="search"
                    />
                </div>

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