<template>
    <div
        class="w-full flex bg-gray-100 p-4"
    >
        <div class="flex items-center justify-between w-full">
            <div class="flex items-center">
                <div class="mr-4">
                    <img :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" class="rounded-full h-10 w-10 object-cover">
                </div>
            </div>
            <div class="flex text-gray-700">
                <svg-icon type="mdi" :size="22" :path="iconPaths.message" class="mr-3"></svg-icon>
                <svg-icon type="mdi" :size="22" :path="iconPaths.dots"></svg-icon>
            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'

    import SvgIcon from '@jamescoyle/vue-icon'
    import {
        mdiDotsVertical,
        mdiAndroidMessages,
    } from '@mdi/js'

    export default defineComponent({
        components: {
            SvgIcon,
        },

        data() {
            return {
                iconPaths: {
                    dots: mdiDotsVertical,
                    message: mdiAndroidMessages,
                }
            }
        },
    })
</script>