<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { ButtonGroup } from '@/components/ui/button-group';
import GameCard from '@/components/game/GameCard.vue';
</script>

<template>
        <Head title="Breakfast Battle!" />
        <h1 class="text-4xl pb-10 pt-4 text-center">Breakfast Battle!</h1>
        <div class="flex items-center justify-center pb-4">
            <GameCard class="ml-4 mr-4" />
            <GameCard class="ml-4 mr-4" />
        </div>
        <div class="fixed bottom-0 left-0 right-0 p-4 bg-gray-100 text-white text-center">
            <div class="flex items-center justify-center">
                <ButtonGroup class="flex items-center">
                    <Button class="bg-transparent text-4xl">🥷🏻</Button>
                    <Button class="bg-transparent text-4xl">🔄</Button>
                    <Button class="bg-transparent text-4xl">🛡️</Button>
                </ButtonGroup>
            </div>
        </div>
</template>
