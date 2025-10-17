<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import GameCard from '@/components/game/GameCard.vue';
import { Card, CardContent } from '@/components/ui/card';

import { ref, onMounted, onUnmounted, watch} from 'vue';

// Use a reactive reference for the countdown value
let count = ref<number>(20);
let countdownInterval: ReturnType<typeof setInterval>;

const props = defineProps({
    allFoodItems: Array,
    actions_left: Array
});

watch(count, (newCount) => {
  if (newCount <= 0) {
    setInterval(nextRound, 2000);
  }
});

// const players = props.game.players;
let currentRound = 1
const players = props.allFoodItems.participants;
let allFoodItems = props.allFoodItems.userFoodItem;

const nextRound = (currentRound: number) => {
    const buttonGroupsToRemove = document.querySelectorAll('.round-' + currentRound);

    // Loop through the selected NodeList and remove each button
    buttonGroupsToRemove.forEach(buttonGroup => {
        buttonGroup.remove();
    });
    currentRound = currentRound + 1;
    resetClock();
};

const resetClock = () => {
    count.value = 20;
}

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

    {{ actions_left }}
    <h2 class="pt-4 pb-5 text-center text-4xl">
        ⭐️ ROUND {{ currentRound }} ⭐️
    </h2>
    <div class="flex items-center justify-center pb-4">
        <Card>
            <CardContent class="text-3xl">
                <span v-if="count > 0">⏱️ {{ count }}</span>
                <span v-else>Time's up!</span>
            </CardContent>
        </Card>
    </div>
    <div class="flex items-center justify-center pb-4">
        <GameCard v-for="player in players" :key="player.id" class="mr-4 ml-4" />
    </div>
</template>
