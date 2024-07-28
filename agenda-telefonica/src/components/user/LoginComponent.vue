<script>
import { useAuth } from '@/stores/AuthStore';
import MessageComponent from '../MessageComponent.vue';

export default {
    data() {
        return {
            email: '',
            password: '',
            msg: '',
            type: null,
            auth: useAuth()
        }
    },
    methods: {
        async login() {
            console.log(this.email, this.password);
            try {
                const response = await fetch('http://127.0.0.1:8000/user/login', {
                    method: 'POST',
                    headers: {
                        'Content-type': 'application/json',
                    },
                    body: JSON.stringify({
                        'email': this.email,
                        'password': this.password
                    })
                })
                const data = await response.json();
                if (response.ok) {
                    localStorage.setItem('token', data.data.token)
                    localStorage.setItem('user', JSON.stringify(data.user))
                    this.auth.defineAuth(true)
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
                console.log(error);
            }
        }
    },
    components: {
        MessageComponent
    }
}
</script>

<template>
    <div class='flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8'>
        <MessageComponent :msg="msg" :type="type" v-show="msg, type"/>
        <div class="sm:mx-auto sm:w-full sm:max-w-sms">
            <h2 class="mt-10 text-center text-2xl font-black leading-9 tracking-tight text-gray-900">
                Faça login na sua conta
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <div class="space-y-6">
                <div>
                    <label htmlFor="email" class="block text-sm font-medium leading-6 text-gray-900">
                        E-mail:
                    </label>
                    <div class='mt-2'>
                        <input type="email" id='email' name="email" required autoComplete='off' v-model="this.email"
                            class="block w-full bg-gray-200 rounded-md border-0 px-1 py-1.5 text-primary-l_green shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-l_orange sm:text-sm sm:leading-6" />
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label htmlFor="password" class="block text-sm font-medium leading-6 text-gray-900">
                            Senha:
                        </label>
                        <div class="text-sm">
                            <a href="#" class="font-semibold text-gray-900 hover:text-gray-600">
                                Esqueceu a senha?
                            </a>
                        </div>
                    </div>
                    <div class="mt-2">
                        <input type="password" name="password" id="password" required v-model="this.password"
                            class="block w-full bg-gray-200 rounded-md border-0 px-1 py-1.5 text-primary-l_green shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-l_orange sm:text-sm sm:leading-6" />
                    </div>
                </div>

                <div>
                    <button @click="login()"
                        class="flex w-full justify-center rounded-md bg-gray-600 text-white px-3 py-1.5 text-sm font-semibold leading-6 text-primary-l_green shadow-sm hover:bg-gray-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Login
                    </button>
                </div>
            </div>
            <p class="mt-10 text-center text-sm text-gray-500">
                Não possui conta?
                <a href='/user/register' class="font-semibold leading-6 text-gray-900 hover:text-gray-600">
                    Cadastre-se agora
                </a>
            </p>
        </div>
    </div>
</template>