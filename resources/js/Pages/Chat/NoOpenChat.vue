<template>
    <div
        class="w-9/12 flex flex-col justify-center items-center space-y-8 px-72 border-b-4 border-whatsApp-secondary"
        style="min-height: 40rem; max-height: 40rem"
    >
        <img src="https://web.whatsapp.com/img/intro-connection-light_c98cc75f2aa905314d74375a975d2cf2.jpg" class="w-60 h-60" alt="">
        <h1 class="font-light text-3xl text-grey-100 text-center">Mantenha seu celular conectado</h1>
        <p class="text-sm text-grey-100 text-center border-b-2 border-grey-50 pb-8">O WhatsApp conecta ao seu celular para sincronizar suas mensagens. Para reduzir o uso de dados, conecte seu celular a uma rede Wi-Fi.</p>

        <div class="flex text-sm text-grey-100 text-center mt-8">
            <svg-icon type="mdi" :size="15" :path="iconPaths.computer"></svg-icon>
            <div>
                Faça chamadas a partir de um computador com o WhatsApp para Windows. <a href="https://www.whatsapp.com/download" target="_blank">Baixe aqui</a>
            </div>
        </div>

    </div>
</template>

<script>
    import { defineComponent } from 'vue'

    import SvgIcon from '@jamescoyle/vue-icon'
    import {
        mdiLaptop
    } from '@mdi/js'

    export default defineComponent({
        components: {
            SvgIcon,
        },

        data() {
            return {
                iconPaths: {
                    computer: mdiLaptop
                }
            }
        },
    })
</script>