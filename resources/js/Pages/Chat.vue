<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Chat
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg flex min-h-screen max-h-screen">
                    <!-- Listagem de usuários -->
                    <div class="w-3/12 bg-gray-200 bg-opacity-25 border-r border-gray-200 overflow-y-scroll">
                      <ul>
                            <li class="p-6 text-lg text-grey-600 leading-7 font-semibold border-b border-gray-200 hover:bg-gray-200 hover:bg-opacity-50 hover:cursor-pointer">
                                <p class="flex items-center justify-between">
                                    Vitor R G Dio
                                    <span class="ml-3 w-2 h-2 rounded-full bg-blue-500"></span>
                                </p>
                            </li>
                            <li class="p-6 text-lg text-grey-600 leading-7 font-semibold border-b border-gray-200 hover:bg-gray-200 hover:bg-opacity-50 hover:cursor-pointer">
                                <p class="flex items-center justify-between">
                                    Inara Reis
                                    <span class="ml-2 w-2 h-2 rounded-full bg-blue-500"></span>
                                </p>
                            </li>
                        </ul>
                    </div>

                    <!-- Box de Mensagens -->
                    <div class="w-9/12 flex flex-col justify-between">
                        <!-- Mensagens -->
                        <div class="w-full p-6 flex flex-col overflow-y-scroll">
                            <div class="w-full mb-3 text-right">
                                <p class="inline-block p-2 rounded-md max-w-4xl bg-indigo-300 bg-opacity-25">
                                    Olá
                                </p>
                                <span class="block mt-2 text-xs text-gray-500">
                                    01/02/2022 18:01
                                </span>
                            </div>

                            <div class="w-full mb-3">
                                <p class="inline-block p-2 rounded-md max-w-4xl bg-gray-300 bg-opacity-25">
                                    Oi, resposta
                                </p>
                                <span class="block mt-2 text-xs text-gray-500">
                                    01/02/2022 18:01
                                </span>
                            </div>
                        </div>

                        <!-- Input do texto da mensagem -->
                        <div class="w-full bg-gray-200 bg-opacity-25 p-6 border-t border-gray-200">
                            <form>
                                <div class="flex overflow-hidden">
                                    <input type="text" class="flex-1 mr-2 px-4 py-2 text-sm border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md focus:shadow-none">
                                    <button type="submit" class="bg-indigo-500 rounded-md hover:bg-indigo-600 text-white px-6 py-2">Enviar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'

    export default defineComponent({
        components: {
            AppLayout,
        },
    })
</script>