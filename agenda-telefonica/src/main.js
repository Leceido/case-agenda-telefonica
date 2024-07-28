import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import {createPinia} from 'pinia';
import {useContactIdStore} from '@/stores/ContactIdStore'
import { useAuth } from './stores/AuthStore';

const pinia = createPinia()
const app = createApp(App)

app.use(pinia)

app.use(router)

if(localStorage.getItem('token')) {
    const auth = useAuth()
    auth.defineAuth(true)
    const token = localStorage.getItem('token')
    console.log(token);
    (async () => {
        const response = await fetch('http://127.0.0.1:8000/api/user', {
            method: 'GET',
            headers: {
                'Authorization' : `Bearer ${token}`
            }
        })
        const data = await response.json()
        if (!response.ok) {
            localStorage.removeItem('token')
            localStorage.removeItem('user')
        }
    })()
    
}

app.mount('#app')

const contactIdStore = useContactIdStore()
