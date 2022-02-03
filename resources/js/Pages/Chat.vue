<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Chat
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg flex" style="min-height: 35rem; max-height: 35rem">
                    <!-- Listagem de usuários -->
                    <div class="w-3/12 bg-gray-200 bg-opacity-25 border-r border-gray-200 overflow-y-scroll">
                        <ul>
                            <li
                                v-for="user in users" :key="user.id"
                                @click="loadMessages(user.id)"
                                :class="(userActive && userActive.id === user.id) ? 'bg-gray-200 bg-opacity-50' : ''"
                                class="p-6 text-lg text-grey-600 leading-7 font-semibold border-b border-gray-200 hover:bg-gray-200 hover:bg-opacity-50 hover:cursor-pointer"
                            >
                                <p class="flex items-center justify-between">
                                    {{ user.name }}
                                    <span class="ml-3 w-2 h-2 rounded-full bg-blue-500" v-if="userActive && userActive.id === user.id"></span>
                                </p>
                            </li>
                        </ul>
                    </div>

                    <!-- Box de Mensagens -->
                    <div class="w-9/12 flex flex-col justify-between" style="min-height: 35rem; max-height: 35rem">
                        <!-- Mensagens -->
                        <div class="w-full p-6 flex flex-col overflow-y-scroll" id="div_messages">
                            <div
                                v-for="message in messages" :key="message.id"
                                :class="(message.from === $page.props.user.id) ? 'text-right' : ''"
                                class="w-full mb-3 message"
                            >
                                <p
                                    :class="(message.from === $page.props.user.id) ? 'bg-indigo-300' : 'bg-gray-300'"
                                    class="inline-block p-2 rounded-md max-w-4xl bg-opacity-25"
                                >
                                    {{ message.content }}
                                </p>
                                <span class="block mt-2 text-xs text-gray-500">
                                    {{ formatDate(message.created_at) }}
                                </span>
                            </div>
                        </div>

                        <!-- Input do texto da mensagem -->
                        <div
                            v-if="userActive"
                            class="w-full bg-gray-200 bg-opacity-25 p-6 border-t border-gray-200"
                        >
                            <form @submit.prevent="sendMessage">
                                <div class="flex overflow-hidden">
                                    <input
                                        v-model="form.message"
                                        type="text"
                                        class="flex-1 mr-2 px-4 py-2 text-sm border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md focus:shadow-none"
                                    >
                                    <button
                                        type="submit"
                                        class="bg-indigo-500 rounded-md hover:bg-indigo-600 text-white px-6 py-2"
                                        :class="{ 'opacity-25' : form.processing }"
                                    >
                                        Enviar
                                    </button>
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

        data() {
            return {
                users: [],
                messages: [],
                userActive: null,
                form: this.$inertia.form({
                    message: '',
                    to: '',
                })
            }
        },

        mounted() {
            axios.get(route('users'))
                .then(response => {
                    this.users = response.data.users;
                });
        },

        methods: {
            loadMessages: async function(userId) {
                axios.get(route('users.show', userId))
                    .then(response => this.userActive = response.data.user)

                await axios.get(route('messages', userId))
                    .then(response => {
                        this.messages = Object.values(response.data.messages)
                    } )

                this.scrollToBottom()
            },

            sendMessage() {
                this.form
                    .transform(data => ({
                        ...data,
                        to: this.userActive.id
                    }))
                    .post(route('sendMessage'), {
                        preserveScroll: true,
                        onSuccess: () => {
                            this.messages.push({
                                'from': this.$page.props.user.id,
                                'to': this.userActive.id,
                                'content': this.form.message,
                                'created_at': new Date().toISOString(),
                                'updated_at': new Date().toISOString()
                            })

                            this.form.reset()
                        },

                        onFinish: () => this.scrollToBottom()
                    })
            },

            scrollToBottom() {
                const divMessage = document.getElementById("div_messages");
                divMessage.scrollTop = divMessage.scrollHeight;
            }
        }
    })
</script>