import {defineStore} from 'pinia';

export const useEditFormStore = defineStore('editForm', {
    state() {
        return {
            isEdit: false,
            isCreate: false,
        }
    },

    actions: {
        defineEdit(bool) {
            this.isEdit = bool;
        },
        defineCreate(bool) {
            this.isCreate = bool;
        }
    },
})