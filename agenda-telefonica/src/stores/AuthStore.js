import {defineStore} from 'pinia';

export const useAuth = defineStore('auth', {
    state() {
        return {
            isAuth: false
        }
    },

    actions: {
        defineAuth() {
            this.isAuth = true;
        },
    }
})