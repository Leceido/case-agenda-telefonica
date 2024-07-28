import {defineStore} from 'pinia';

export const useContactIdStore = defineStore('contactId', {
    state() {
        return {
            contactId: null,
            changeContact: false,
        }
    },

    actions: {
        defineId(contact) {
            this.contactId = contact;
        },
        defineStateContact(bool) {
            this.changeContact = bool
        }
    },

    getters: {
        showId() {
            return this.contactId;
        }
    }
})