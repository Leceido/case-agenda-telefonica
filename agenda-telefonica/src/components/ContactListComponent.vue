<script>
    import { storeToRefs } from 'pinia';
    import {useContactIdStore} from '../../src/stores/ContactIdStore';
    import { watch } from 'vue';
    import { useEditFormStore } from '@/stores/EditFormStore';
import { useAuth } from '@/stores/AuthStore';

    export default {
        
        data() {
            const contactPinia = useContactIdStore();
            const { changeContact } = storeToRefs(contactPinia)

            watch(changeContact, (newValue, oldValue) => { 
                if (this.changeContact) {
                    this.fetchContacts() 
                }
            })
            
            return {
                contacts: [],
                activeContactId: null,
                contactIdStore: useContactIdStore(),
                createFormStore: useEditFormStore(),
                changeContact,
                auth: useAuth()
            };
        },
        mounted() {
            this.fetchContacts();
        },
        methods: {
            async fetchContacts() {
                const token = localStorage.getItem('token');
                try {
                    this.contacts = []
                    const response = await fetch('http://127.0.0.1:8000/contact', {
                        method: 'GET',
                        headers: {
                            'Content-type': 'application/json',
                            'Accept': 'application/json',
                            'Authorization' : `Bearer ${token}`
                        }
                    });
                    const data = await response.json();
                    this.auth.defineAuth(true)
                    this.contacts = data.contacts;
                } catch (error) {
                    console.error('Erro ao buscar contatos:', error);
                }
            },
            setActiveContact(contact) {
                const copyContact = JSON.parse(JSON.stringify(contact));
                this.activeContactId = contact.id;
                this.contactIdStore.defineId(copyContact);
                this.createFormStore.defineEdit(false)
            },
            createContactForm() {
                this.createFormStore.defineCreate(true)
            }
        },
    };
</script>

<template>
    <div class="" :class="{'hidden md:block' : this.contactIdStore.contactId || createFormStore.isCreate}">
        <div class="p-4 flex flex-row justify-between">
            <h1 class="text-3xl md:text-xl lg:text-3xl font-semibold">Contatos</h1>
            <i @click="createContactForm()" class="material-icons text-3xl hover:text-gray-600 cursor-pointer">person_add</i>
        </div>
        <div class="my-4">
            <ul class="overflow-y-scroll max-h-screen md:max-h-[68vh]" v-if="contacts.length > 0">
                <li 
                    v-for="contact in contacts" 
                    :key="contact.id" 
                    :class="{ 'bg-gray-50': activeContactId === contact.id}"
                    @click="setActiveContact(contact)"
                    class="border-b-[1px] border-gray-200 py-4 text-xl hover:bg-gray-50 flex flex-row items-center space-x-3 p-4 cursor-pointer"
                >
                    <div class="w-10 h-10 min-w-10 bg-gray-600 text-white rounded-full text-center">
                        <img v-if="contact.image != null" class="w-10 h-10 rounded-full object-cover" :src="contact.image" alt="" >
                        <div v-else class="flex justify-center items-center w-10 h-10"> {{ contact.name[0] }}</div>
                    </div>
                    <div>
                        <h1 class="md:max-w-[10ch] lg:max-w-[15ch] xl:max-w-[20ch] truncate" >{{ contact.name }}</h1>
                    </div>
                </li>
            </ul>
            <div v-else>
                <div class="flex flex-col justify-center items-center space-y-8 text-xl">
                    <h1>Ainda não tem contatos</h1>
                    <div class="text-3xl hover:text-gray-600 cursor-pointer" @click="createContactForm()">Criar Contato <i class="material-icons">person_add</i></div>
                </div>
                
            </div>
        </div>
    </div>
  </template>
  