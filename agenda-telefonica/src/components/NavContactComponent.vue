<script>
    import { useContactIdStore } from '@/stores/ContactIdStore';
    import {useEditFormStore} from '@/stores/EditFormStore';
    import MessageComponent from './MessageComponent.vue';


    export default {
        
        data() {
            return {
                contactIdStore: useContactIdStore(),
                editFormStore: useEditFormStore(),
                copyContact: null,
                msg: null,
                type: null
            }
        },
        methods: {
            closeContact() {
                this.contactIdStore.defineId(null);
            },
            async deleteContact(id) {
                const token = localStorage.getItem('token')
                try {
                    const response = await fetch(`http://127.0.0.1:8000/contact/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization':`Bearer ${token}`
                        }
                    })
                    if ((await response).ok) {
                        location.reload()
                    }
                } catch (error) {
                    console.error("Ocorreu um erro ao deletar", error);
                    this.$router.go()
                }
                
            },
            editContact() {
                if(this.editFormStore.isEdit) {
                    this.editFormStore.defineEdit(false);
                    this.contactIdStore.defineId(this.copyContact);
                } else {
                    this.editFormStore.defineEdit(true);
                    this.copyContact = JSON.parse(JSON.stringify(this.contactIdStore.contactId));
                }
            },
            async confirmEdit(id) {
                const token = localStorage.getItem('token')
                let formData = new FormData();
                formData.append('name', this.contactIdStore.contactId.name);
                formData.append('email', this.contactIdStore.contactId.email);
                formData.append('phone', this.contactIdStore.contactId.phone);
                formData.append('image', this.contactIdStore.contactId.image);

                try {
                    const response = await fetch(`http://127.0.0.1:8000/contact/${id}?_method=PUT`, {
                        method: 'POST',
                        headers: {
                            'Authorization':`Bearer ${token}`
                        },
                        body: formData
                    })
                    const data = await response.json()
                    if(response.status == 201){
                        this.editFormStore.defineEdit(false);
                        this.msg = data.message
                        this.contactIdStore.defineStateContact(true);
                        setTimeout(() => {
                            this.msg = ''
                            this.contactIdStore.defineStateContact(false);
                        }, 3000)
                    } else {
                        this.msg = data.message
                        this.type = 'error'
                        setTimeout(() => {
                            this.msg = ''
                            this.erro = null
                        }, 3000)
                    }
                } catch (error) {
                    console.error("Ocorreu um erro ao edit", error);
                    //this.$router.go()
                }
            },
        },
        components: {
            MessageComponent,
        }
    }
</script>

<template>
    <div class="flex flex-row w-full justify-between">
        <div class="">
            <div @click="closeContact()" class="flex flex-col justify-center items-center cursor-pointer hover:text-gray-600 ">
                <i class="material-icons text-4xl">close</i>
                <div class="text-sm">Fechar</div>
            </div>
        </div>
        <div v-if="this.editFormStore.isEdit === false" class="flex flex-row space-x-8">
            <div @click="editContact()" class="flex flex-col justify-center items-center cursor-pointer hover:text-gray-600">
                <i class="material-icons text-4xl">edit</i>
                <div class="text-sm">Editar</div>
            </div>
            <div @click="deleteContact(this.contactIdStore.contactId.id)" class="flex flex-col justify-center items-center cursor-pointer hover:text-gray-600">
                <i class="material-icons text-4xl">delete</i>
                <div class="text-sm">Deletar</div>
            </div>
        </div>
        <div v-else class="flex flex-row space-x-8">
            <div @click="editContact()" class="flex flex-col justify-center items-center cursor-pointer hover:text-gray-600">
                <i class="material-icons text-4xl">undo</i>
                <div class="text-sm">Descartar</div>
            </div>
            <div @click="confirmEdit(this.contactIdStore.contactId.id)" class="flex flex-col justify-center items-center cursor-pointer hover:text-gray-600">
                <i class="material-icons text-4xl">check</i>
                <div class="text-sm">Confirmar</div>
            </div>
        </div>
    </div>
    <MessageComponent :msg="msg" :type="type" v-show="msg, type"/>
</template>