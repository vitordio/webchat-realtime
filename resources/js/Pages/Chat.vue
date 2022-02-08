<template>
    <app-layout title="Chat">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Chat
            </h2>
        </template>

        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-sm flex -mt-10" style="min-height: 40rem; max-height: 40rem">
                <!-- Listagem de usuários -->
                <div class="w-3/12 bg-gray-200 bg-opacity-25 border-r border-gray-200 overflow-y-scroll">
                    <!-- Informações do usuário logado -->
                    <logged-user-info />

                    <!-- Filtro de busca das mensagens -->
                    <search-conversations />
                    
                    <ul>
                        <li
                            v-for="user in users" :key="user.id"
                            @click="loadMessages(user.id)"
                            :class="(userActive && userActive.id === user.id) ? 'bg-gray-200 bg-opacity-50' : ''"
                            class="px-6 py-4 text-md text-grey-600 leading-7 font-semibold border-b border-gray-200 hover:bg-gray-200 hover:bg-opacity-50 hover:cursor-pointer"
                        >
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="mr-4">
                                        <img :src="user.profile_photo_url" :alt="user.name" class="rounded-full h-10 w-10 object-cover">
                                    </div>

                                    <span>{{ user.name }}</span>
                                </div>
                                <span class="ml-3 w-2 h-2 rounded-full bg-whatsApp-secondary text-sm text-white flex justify-center items-center" v-if="user.notification"></span>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Box de Mensagens -->
                <div
                    class="w-9/12 flex flex-col justify-between"
                    style="min-height: 40rem; max-height: 40rem"
                    :class="{ 'bg-wpp bg-contain' : userActive }"
                    v-if="userActive"
                >
                    <!-- Barra de informações do usuário clicado -->
                    <user-active-profile-info :userActive="userActive" />

                    <!-- Mensagens -->
                    <messages :messages="messages" />

                    <!-- Input do texto da mensagem -->
                    <div
                        class="w-full bg-gray-200 p-6 border-t border-gray-200"
                    >
                        <form @submit.prevent="sendMessage">
                            <div class="flex items-center overflow-hidden">
                                <svg-icon type="mdi" :size="28" :path="iconPaths.emoji" class="mr-3 text-gray-500"></svg-icon>
                                <svg-icon type="mdi" :size="28" :path="iconPaths.attachment" class="mr-3 text-gray-500"></svg-icon>

                                <input
                                    v-model="form.message"
                                    type="text"
                                    placeholder="Mensagem"
                                    class="flex-1 mr-2 px-4 py-3 text-sm border-0 focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md focus:shadow-none"
                                >
                                <button
                                    type="submit"
                                    class="text-gray-500 px-2 py-3"
                                    :class="{ 'opacity-25' : form.processing }"
                                >
                                    <svg-icon type="mdi" :size="20" :path="iconPaths.sendMessage"></svg-icon>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Componente quando nenhuma conversa está selecionada  -->
                <no-open-chat v-else />
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'

    import SvgIcon from '@jamescoyle/vue-icon'
    import {
        mdiEmoticonOutline,
        mdiPaperclip,
        mdiSend,
    } from '@mdi/js'

    import NoOpenChat from './Chat/NoOpenChat.vue';
    import LoggedUserInfo from './Chat/LoggedUserInfo.vue';
    import SearchConversations from './Chat/SearchConversations.vue';
    import UserActiveProfileInfo from './Chat/UserActiveProfileInfo.vue';
    import Messages from './Chat/Messages.vue';

    export default defineComponent({
        components: {
            AppLayout,
            SvgIcon,
            NoOpenChat,
            LoggedUserInfo,
            SearchConversations,
            UserActiveProfileInfo,
            Messages
        },

        data() {
            return {
                users: [],
                messages: [],
                userActive: null,
                value: '',
                form: this.$inertia.form({
                    message: '',
                    to: '',
                }),
                iconPaths: {
                    emoji: mdiEmoticonOutline,
                    attachment: mdiPaperclip,
                    sendMessage: mdiSend,
                }
            }
        },

        mounted() {
            axios.get(route('users'))
                .then(response => {
                    this.users = response.data.users;
                });

            // Conexão com o canal do usuário
            Echo.private(`user.${this.$page.props.user.id}`)
                .listen('.SendMessage', async (broadcastData) => {
                    /**
                     * Se o usuário que está ativo (com o chat aberto) for o mesmo
                     * que enviou a mensagem, vou adicionar no array de mensagens
                     * 
                     * Se não for o usuário que está ativo no chat, exibimos a bolinha
                     * de mensagens pendentes ao lado do nome do usuário
                     */
                    const message = broadcastData.message

                    if(this.userActive && this.userActive.id === message.from) {
                        await this.pushMessage(message);
                        this.scrollToBottom()
                    } else {
                        const user = this.users.filter((user) => {
                            if(user.id === message.from)
                                return user
                        });
                        
                        if(user)
                            user[0]['notification'] = true;
                    }
                });
        },

        methods: {
            loadMessages: async function(userId) {
                axios.get(route('users.show', userId))
                    .then(response => {
                        this.userActive = response.data.user
                    })

                await axios.get(route('messages', userId))
                    .then(response => {
                        this.messages = Object.values(response.data.messages)
                    })

                const user = this.users.filter((user) => {
                    if(user.id === userId)
                        return user
                });

                if(user)
                    user[0]['notification'] = false;

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
                            const message = {
                                'from': this.$page.props.user.id,
                                'to': this.userActive.id,
                                'content': this.form.message,
                                'created_at': new Date().toISOString(),
                                'updated_at': new Date().toISOString()
                            }

                            this.pushMessage(message)
                            this.form.reset()
                        },

                        onFinish: () => this.scrollToBottom()
                    })
            },

            scrollToBottom() {
                const divMessage = document.getElementById("div_messages");
                divMessage.scrollTop = divMessage.scrollHeight;
            },

            pushMessage(message) {
                this.messages.push(message)
            },
        }
    })
</script>