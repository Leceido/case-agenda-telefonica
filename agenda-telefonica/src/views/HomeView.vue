<script setup>
  import ContactList from '../components/ContactListComponent.vue'
  import ContactComponent from '../components/ContactComponent.vue'
  import CreateUserComponent from '@/components/CreateUserComponent.vue';
</script>

<template>
  <main>
    <CreateUserComponent />
    <div class="flex justify-center items-center md:mx-10 lg:mx-20 md:my-10">
      <div class="md:flex md:flex-row bg-white rounded-xl w-full h-screen md:h-[80vh]">
        <div class="border-r-[1px] border-gray-200 md:w-1/4">
          <ContactList />
        </div>
        <div class="md:w-3/4">
          <ContactComponent />
        </div>
      </div>
    </div>
    
    
  </main>
</template>
