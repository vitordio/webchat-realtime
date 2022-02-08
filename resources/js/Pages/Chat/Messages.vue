<template>
    <div class="w-full p-6 flex flex-col overflow-y-scroll" id="div_messages" style="min-height: 30rem; max-height: 30rem">
        <div
            v-for="message in messages" :key="message.id"
            :class="(message.from === $page.props.user.id) ? 'text-right' : ''"
            class="w-full mb-3 message"
        >
            <div
                :class="(message.from === $page.props.user.id) ? 'bg-green-200' : 'bg-orange-100'"
                class="inline-block p-2 rounded-md max-w-4xl"
            >
                <div class="flex items-end">
                    <span class="mr-2">
                        {{ message.content }}
                    </span>
                    <span class="block mt-2 text-xs text-gray-500">
                        {{ formatDateMessage(message.created_at) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: {
            messages: {
                type: Object
            }
        }
    })
</script>