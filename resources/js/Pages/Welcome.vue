<template>
    <div class="min-h-screen bg-slate-900 text-white font-sans selection:bg-indigo-500">
      <nav class="fixed w-full z-50 top-0 px-6 py-4">
        <div class="max-w-7xl mx-auto backdrop-blur-md bg-white/5 border border-white/10 rounded-2xl px-6 py-3 flex justify-between items-center">
          <div class="text-2xl font-bold bg-gradient-to-r from-indigo-400 to-cyan-400 bg-clip-text text-transparent">
            ServiceHub
          </div>
  
          <div v-if="canLogin" class="flex gap-4 items-center">
            
            <Link
              v-if="$page.props.auth.user"
              :href="route('dashboard')"
              class="bg-indigo-600 hover:bg-indigo-500 px-5 py-2 rounded-xl text-sm font-semibold transition shadow-lg shadow-indigo-500/20 text-white border border-indigo-400/20"
            >
              Acessar Painel
            </Link>
  
            <template v-else>
              <Link
                :href="route('login')"
                class="text-sm font-semibold text-slate-300 hover:text-white transition px-3"
              >
                Log in
              </Link>
  
              <Link
                v-if="canRegister"
                :href="route('register')"
                class="bg-indigo-600 hover:bg-indigo-500 px-5 py-2 rounded-xl text-sm font-semibold transition shadow-lg shadow-indigo-500/20 text-white border border-indigo-400/20"
              >
                Registrar
              </Link>
            </template>
  
          </div>
        </div>
      </nav>
  
      <header class="pt-40 pb-16 px-6">
        <div class="max-w-7xl mx-auto text-center">
          <span class="inline-block px-4 py-1.5 mb-6 text-xs font-semibold tracking-wider uppercase bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 rounded-full">
            Nova Geração de Suporte
          </span>
          <h1 class="text-5xl md:text-7xl font-extrabold mb-6 tracking-tight">
            Transforme reclamações em <br />
            <span class="text-indigo-400">clientes satisfeitos.</span>
          </h1>
          <p class="text-slate-400 text-lg md:text-xl max-w-2xl mx-auto mb-10">
            Gerencie tickets, automatize respostas e analise o sentimento dos seus usuários em uma única plataforma modular e veloz.
          </p>
        </div>
      </header>
  
      <section class="py-20 px-6 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="md:col-span-2 p-8 rounded-3xl bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 hover:border-indigo-500/50 transition group">
            <div class="h-12 w-12 bg-indigo-500/20 rounded-xl flex items-center justify-center mb-6 text-indigo-400 group-hover:scale-110 transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
              </svg>
            </div>
            <h3 class="text-2xl font-bold mb-3">Triagem com IA</h3>
            <p class="text-slate-400">Nossa inteligência artificial categoriza automaticamente a urgência e o tom da reclamação antes mesmo de um humano abrir o ticket.</p>
          </div>
  
          <div class="p-8 rounded-3xl bg-slate-800/50 border border-slate-700 flex flex-col justify-between">
            <div>
              <h3 class="text-xl font-bold mb-3">Multi-Channel</h3>
              <p class="text-slate-400 text-sm">Centralize WhatsApp, E-mail e Chat em um só lugar.</p>
            </div>
            <div class="mt-8 flex -space-x-2">
              <div class="w-10 h-10 rounded-full bg-green-500 border-2 border-slate-900 flex items-center justify-center text-[10px] font-bold">WA</div>
              <div class="w-10 h-10 rounded-full bg-blue-500 border-2 border-slate-900 flex items-center justify-center text-[10px] font-bold">MAIL</div>
              <div class="w-10 h-10 rounded-full bg-indigo-500 border-2 border-slate-900 flex items-center justify-center text-[10px] font-bold">API</div>
            </div>
          </div>
        </div>
      </section>
  
      <footer class="py-10 border-t border-slate-800 text-center text-slate-500 text-sm">
        <p>&copy; {{ new Date().getFullYear() }} ServiceHub - Todos os direitos reservados.</p>
      </footer>
    </div>
  </template>
  
  <script setup>
  import { Link } from '@inertiajs/vue3';
  
  // Props recebidas do Laravel/Inertia
  defineProps({
      canLogin: {
          type: Boolean,
      },
      canRegister: {
          type: Boolean,
      },
  });
  </script>
  
  <style scoped>
  .min-h-screen {
    background-image: 
      radial-gradient(circle at 0% 0%, rgba(79, 70, 229, 0.15) 0%, transparent 25%),
      radial-gradient(circle at 100% 100%, rgba(6, 182, 212, 0.1) 0%, transparent 25%);
  }
  
  /* Garante que o scroll seja suave */
  html {
    scroll-behavior: smooth;
  }
  </style>