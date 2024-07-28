<script>
import { useEditFormStore } from '@/stores/EditFormStore';
import MessageComponent from './MessageComponent.vue';

export default {
    
    data() {
        return {
            createFormStore: useEditFormStore(),
            nameForm: '',
            phoneForm: '',
            emailForm: '',
            imageForm: '',
            imageUrl: null,
            msg: '',
            type: null
        }
    },
    methods: {
        closeForm() {
            this.createFormStore.defineCreate(false);
            this.nameForm = ''
            this.phoneForm = '',
            this.emailForm = '',
            this.imageForm = null,
            this.imageUrl = null
        },
        async createContact() {
            const token = localStorage.getItem('token')

            var formData = new FormData();
            const name = this.nameForm
            const email = this.emailForm
            const phone = this.phoneForm
            const image = this.imageForm
            
            formData.append('name', name)
            formData.append('email', email)
            formData.append('phone', phone)
            formData.append('image', image)
            
            try {
                const response = await fetch('http://127.0.0.1:8000/contact/', {
                    method:'POST',
                    headers: {
                        'Authorization':`Bearer ${token}`,
                    },
                    body: formData
                })
                const data = await response.json();
                if(response.status ===  201) {
                    console.log('Contato criado');
                    location.reload()
                } else {
                    this.msg = data.message
                    this.type = 'error'
                    setTimeout(() => {
                        this.msg = ''
                        this.erro = null
                    }, 3000)
                }

            } catch (error) {
                console.log(error, "Erro ao criar");
            }
        },
        handleFileChange(event) {
            const file = event.target.files[0];
            this.imageForm = file
            this.imageUrl = URL.createObjectURL(file);
        }
    },
    components: {
        MessageComponent,
    }
}
</script>

<template>
    <div v-if="this.createFormStore.isCreate" class="bg-black/90 w-full h-screen absolute top-0 left-0">
        <div class="md:absolute bg-gray-200 w-full h-screen md:top-[15%] md:left-1/4 md:w-2/4 md:h-auto p-4">
            <div class="flex">
                <div @click="closeForm()" class="flex flex-col cursor-pointer hover:text-gray-600 ">
                    <i class="material-icons text-4xl">close</i>
                    <div class="text-sm">Fechar</div>
                </div>
            </div>
            <div class="flex flex-col space-y-4">
                <MessageComponent :msg="msg" :type="type" v-show="msg, type"/>
                <div class="flex justify-center items-center">
                    <div v-if="this.imageUrl" class="relative w-40 h-40">
                        <label for="image">
                        <input name="image" id="image" type="file" accept="image/*" @change="handleFileChange" hidden>
                            <img
                                :src="imageUrl"
                                alt="imagem" 
                                class="w-40 h-40 rounded-full border-2 border-gray-600 object-cover cursor-pointer contrast-100 hover:contrast-75 brightness-100 hover:brightness-125"
                            >
                        </label>
                    </div>
                    <div v-else class="flex items-center justify-center text-lg">
                        <label for="image">
                            <input name="image" id="image" type="file" accept="image/*" @change="handleFileChange" hidden>
                            <div 
                                class="w-40 h-40 rounded-full border-2 
                                border-gray-200 bg-gray-600 text-white cursor-pointer contrast-100 hover:contrast-75 brightness-100 hover:brightness-125
                                flex items-center justify-center"
                            >
                                Inserir Foto
                        </div>
                            
                        </label>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-lg p-2">
                    <div>
                        Nome:
                        <input class="p-2 bg-gray-50 w-3/4" type="text" min="1" max="15" name="name" id="name" v-model="nameForm">
                    </div>
                </div>
                <div class="bg-gray-50 rounded-lg p-2">
                    <div>
                        Telefone:
                        <input class="p-2 bg-gray-50 w-3/4" type="text" min="1" max="15" name="phone" id="phone" v-model="phoneForm">
                    </div>
                </div>
                <div class="bg-gray-50 rounded-lg p-2">
                    <div>
                        E-mail:
                        <input class="p-2 bg-gray-50 w-3/4" type="email" name="email" id="email" v-model="emailForm">
                    </div>
                </div>
                <div class="text-center">
                    <button @click="createContact()" class="bg-black hover:bg-gray-600 text-white hover:text-gray-200 p-2 rounded-full">Criar Contato</button>
                </div>
            </div>

        </div>
    </div>
</template>