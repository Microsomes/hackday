<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Card, CardContent } from '@/components/ui/card';

const props = defineProps({
    food_items: {
        type: Object
    }
});

// Map food types to colors
const typeColors: Record<string, string> = {
    fruit: 'bg-green-500 text-white',
    vegetable: 'bg-yellow-500 text-black',
    meat: 'bg-red-500 text-white',
    default: 'bg-gray-500 text-white',
};
</script>

<template>
  <Head title="You Won!" />

  <div class="min-h-screen bg-gradient-to-b from-purple-800 via-purple-700 to-purple-600 py-12 px-4">
    <!-- Header -->
    <h2 class="text-center text-4xl md:text-5xl font-extrabold text-white pb-12 drop-shadow-lg">
      No Stealing! Sabotage by Killing the Game
    </h2>

    <!-- User Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <div
        v-for="(items, username) in food_items.userFoodItem"
        :key="username"
      >
        <Card class="bg-gray-800 text-white shadow-2xl hover:shadow-purple-600 transition duration-300 rounded-xl">
          <CardContent class="p-6">
            <!-- Username -->
            <h3 class="text-2xl font-bold mb-6 text-center">{{ username }}</h3>

            <!-- Food Items List -->
            <ul class="space-y-4">
              <li
                v-for="(foodItem, index) in items"
                :key="index"
                class="flex justify-between items-center p-3 rounded-lg bg-gray-700 hover:bg-gray-600 transition"
              >
                <span class="font-semibold">{{ foodItem.food_name }}</span>
                <span
                  class="px-3 py-1 rounded-full text-sm font-bold"
                  :class="typeColors[foodItem.type] || typeColors.default"
                >
                  {{ foodItem.type }}
                </span>
              </li>
            </ul>
          </CardContent>
        </Card>
      </div>
    </div>
  </div>
</template>
