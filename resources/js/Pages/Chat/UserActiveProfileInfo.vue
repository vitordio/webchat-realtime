<template>
    <div
        class="w-full flex bg-gray-100 p-4"
    >
        <div class="flex items-center justify-between w-full">
            <div class="flex items-center">
                <div class="mr-4">
                    <img :src="userActive.profile_photo_url" :alt="userActive.name" class="rounded-full h-10 w-10 object-cover">
                </div>

                <span>{{ userActive.name }}</span>
            </div>
            <div class="flex text-gray-700">
                <svg-icon type="mdi" :size="22" :path="iconPaths.search" class="mr-3"></svg-icon>
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
        mdiMagnify,
    } from '@mdi/js'

    export default defineComponent({
        components: {
            SvgIcon,
        },

        props: {
            userActive: {
                type: Object
            }
        },

        data() {
            return {
                iconPaths: {
                    dots: mdiDotsVertical,
                    search: mdiMagnify,
                }
            }
        },
    })
</script>