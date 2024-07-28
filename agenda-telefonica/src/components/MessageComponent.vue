<script>
    export default {
        name: 'Message',
        props: {
            msg: String,
            type: String
        }
    }
</script>


<template>
    <div class="flex justify-center">
        <h1 :class="{'bg-red-500': type === 'error'}" class="bg-blue-500 p-2 rounded-lg text-white"> {{ msg }}</h1>
    </div>
</template>