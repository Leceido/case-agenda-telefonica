<script setup>
    let isAuth = false 
    if (localStorage.getItem('token')) {
        isAuth = true
    }
    const user = JSON.parse(localStorage.getItem('user'))

    function logout() {
        localStorage.removeItem('token')
        localStorage.removeItem('user')
        location.reload()
    }
</script>

<template>

    <div v-if="isAuth" class="flex justify-between p-4 md:px-20">
        <div class="text-xl md:text-3xl font-bold">
            Olá! {{ user.name }}
        </div>
        <div @click="logout" class="flex flex-row justify-center items-center text-xl cursor-pointer hover:text-gray-600">
            <i class="material-icons md:text-3xl font-bold">logout</i>
        </div>
    </div>
    <div v-else="" class="flex justify-between p-4 md:px-20">
        <div class="text-xl md:text-3xl font-bold">
            Seja Bem Vindo
        </div>
        <div class="flex flex-col justify-center items-center text-xl cursor-pointer hover:text-gray-600">
            <a href="/user/register">Cadastrar</a>
        </div>
    </div>
</template>