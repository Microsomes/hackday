<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { useEchoPublic } from '@laravel/echo-vue';


useEchoPublic('waiting-room', ".GameStarted", (e)=>{
    console.log("a game has started")
    console.log(e);

    alert("game started")

})

</script>

<template>
    <Head title="Dashboard" />

    listening to event
</template>
