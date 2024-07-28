<script>
  import { useEditFormStore } from '@/stores/EditFormStore';
  import { useContactIdStore } from '../../src/stores/ContactIdStore';
  import NavContactComponent from '../components/NavContactComponent.vue';
  import LandingPageComponent from './LandingPageComponent.vue';
  
  export default {
    data() {
      return {
        contactIdStore: useContactIdStore(),
        editFormStore: useEditFormStore(),
        contact: null,
        isInputDisabled: true,
        msg: null,
        imageForm: null,
        imageUrl: null
      }
    },
    methods: {
      closeContact() {
        this.contactIdStore.defineId(null);
        this.imageUrl = null
      },
      handleFileChange(event) {
        const file = event.target.files[0];
        this.contactIdStore.contactId.image = file
        this.imageUrl = URL.createObjectURL(file);
      }
    },
    components: {
      NavContactComponent,
      LandingPageComponent,

    }
  }
</script>


<template>
  <div v-if="contactIdStore.contactId" class="flex justify-center items-center mx-4 md:mx-20">
    <div class="flex flex-col space-y-8 w-full my-5 md:my-10">
      <div>
        <NavContactComponent/>
      </div>
      <div class="flex justify-center items-center">
        <div v-if="contactIdStore.contactId.image != null">
          <label for="image">
            <input name="image" id="image" type="file" accept="image/*" @change="handleFileChange" hidden :disabled="!this.editFormStore.isEdit" >
            <img 
              v-if="this.imageUrl != null"
              :src="this.imageUrl" 
              alt="imagem"
              class="w-40 h-40 rounded-full border-2 border-gray-200 object-cover"
              :class="{ 'contrast-100 hover:contrast-75 brightness-100 hover:brightness-125 cursor-pointer': this.editFormStore.isEdit}"
            >
            <img
              v-else
              :src="contactIdStore.contactId.image" 
              alt="imagem"
              class="w-40 h-40 rounded-full border-2 border-gray-200 object-cover"
              :class="{ 'contrast-100 hover:contrast-75 brightness-100 hover:brightness-125 cursor-pointer': this.editFormStore.isEdit}"
            >
          </label>
        </div>
        <div v-else class="bg-gray-600 rounded-full w-40 h-40 flex items-center justify-center text-4xl">
          <label for="image">
            <input name="image" id="image" type="file" accept="image/*" @change="handleFileChange" hidden :disabled="!this.editFormStore.isEdit" >
            <div class="w-40 h-40 rounded-full border-2 
                                border-gray-200 bg-gray-600 text-white 
                                flex items-center justify-center" :class="{ 'contrast-100 hover:contrast-75 brightness-100 hover:brightness-125 cursor-pointer': this.editFormStore.isEdit}">
              {{ contactIdStore.contactId.name[0] }}
            </div>
          </label>
        </div>
      </div>
      <div class="bg-gray-50 rounded-lg p-2">
        <div>
          Nome: 
          <input 
            class="p-2 bg-gray-50 w-3/4"
            :class="{ 'bg-white border-gray-500 border-2 rounded-lg': this.editFormStore.isEdit}"
            :disabled="!this.editFormStore.isEdit" 
            type="text" 
            min="1" 
            max="15" 
            name="name" 
            id="name" 
            v-model="contactIdStore.contactId.name" 
          >
        </div>
      </div>
      <div class="bg-gray-50 rounded-lg p-2">
        <div>
          Telefone: 
          <input 
            class="p-2 bg-gray-50 w-3/4"
            :class="{ 'bg-white border-gray-500 border-2 rounded-lg': this.editFormStore.isEdit}"
            type="text" 
            min="1" 
            max="15" 
            name="phone" 
            id="phone" 
            v-model="contactIdStore.contactId.phone" 
            :disabled="!this.editFormStore.isEdit" 
          >
        </div>
      </div>
      <div class="bg-gray-50 rounded-lg p-2">
        <div>
          E-mail: 
          <input 
            class="p-2 bg-gray-50 w-3/4"
            :class="{ 'bg-white border-gray-500 border-2 rounded-lg': this.editFormStore.isEdit}" 
            type="email" 
            name="email" 
            id="email" 
            v-model="contactIdStore.contactId.email" 
            :disabled="!this.editFormStore.isEdit" 
          >
        </div>
      </div>
    </div>
  </div>
  <div v-else class="hidden md:block">
    <LandingPageComponent />
  </div>
</template>