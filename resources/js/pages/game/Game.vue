<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { ButtonGroup } from '@/components/ui/button-group';
import GameCard from '@/components/game/GameCard.vue';
import { useEchoPublic } from '@laravel/echo-vue';
import { Card, CardContent } from '@/components/ui/card';

import { ref, onMounted, onUnmounted } from 'vue';

// Use a reactive reference for the countdown value
const count = ref<number>(20);
let countdownInterval: ReturnType<typeof setInterval>;

onMounted(() => {
    // Start the countdown timer when the component is mounted
    countdownInterval = setInterval(() => {
        if (count.value > 0) {
            count.value--;
        } else {
            // Stop the timer when the count reaches zero
            clearInterval(countdownInterval);
        }
    }, 1000);
});

onUnmounted(() => {
    // Clear the interval when the component is unmounted to prevent memory leaks
    clearInterval(countdownInterval);
});
</script>

<template>
    <Head title="Breakfast Battle!" />
    <h2 class="pt-4 pb-5 text-center text-4xl">⭐️ ROUND 1 ⭐️</h2>
    <div class="flex items-center justify-center pb-4">
        <Card>
            <CardContent class="text-3xl">
                <span v-if="count > 0">⏱️ {{ count }}</span>
                <span v-else>Time's up!</span>
            </CardContent>
        </Card>
    </div>
    <div class="flex items-center justify-center pb-4">
<!--        <GameCard v-for="player in players" :key="player.id" class="mr-4 ml-4" />-->
        <GameCard class="mr-4 ml-4" />
    </div>
</template>
