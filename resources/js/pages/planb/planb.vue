<script setup lang="ts">
import { Card, CardContent } from '@/components/ui/card';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';

type FoodItem = {
    food_name: string;
    type: string;
};

interface FoodItemsPayload {
    userFoodItem: Record<string, FoodItem[]>;
}

const props = defineProps<{
    food_items?: FoodItemsPayload;
}>();

const typeColors: Record<string, string> = {
    fruit: 'bg-green-500 text-white',
    vegetable: 'bg-yellow-500 text-black',
    meat: 'bg-red-500 text-white',
    default: 'bg-gray-500 text-white',
};

const userFoodItem = computed<Record<string, FoodItem[]>>(() => {
    if (
        props.food_items?.userFoodItem &&
        typeof props.food_items.userFoodItem === 'object'
    ) {
        return props.food_items.userFoodItem;
    }

    return {};
});

const playerStats = computed(() => {
    const entries = Object.entries(userFoodItem.value);

    return entries
        .map(([username, items]) => {
            const safeItems = Array.isArray(items) ? items : [];

            return {
                username,
                items: safeItems,
                total: safeItems.length,
                variety: new Set(safeItems.map((item) => item.type)).size,
            };
        })
        .sort((a, b) => {
            if (b.total !== a.total) {
                return b.total - a.total;
            }

            if (b.variety !== a.variety) {
                return b.variety - a.variety;
            }

            return a.username.localeCompare(b.username);
        });
});

const topScore = computed(() => playerStats.value[0]?.total ?? 0);

const winners = computed(() =>
    playerStats.value.filter(
        (player) => player.total === topScore.value && topScore.value > 0,
    ),
);

const totalFoodItems = computed(() =>
    playerStats.value.reduce((sum, player) => sum + player.total, 0),
);

const celebratoryMessage = computed(() => {
    if (!winners.value.length) {
        return 'Everyone gave it their best shot!';
    }

    if (winners.value.length === 1) {
        return `${winners.value[0].username} steals the spotlight!`;
    }

    if (winners.value.length === 2) {
        return `${winners.value[0].username} & ${winners.value[1].username} share the crown!`;
    }

    return 'A legendary team-up! Multiple champions emerge.';
});
</script>

<template>
    <Head title="Game Over" />

    <div class="end-screen">
        <div class="hero-gradient" aria-hidden="true" />
        <div class="floating-orb orb-one" aria-hidden="true" />
        <div class="floating-orb orb-two" aria-hidden="true" />
        <div class="floating-orb orb-three" aria-hidden="true" />

        <div class="content-wrapper">
            <section class="hero-section">
                <p class="eyebrow">Sabotage Complete</p>
                <h1 class="headline">
                    No Stealing! <span class="highlight">Game Over</span>
                </h1>
                <p class="lede">
                    {{ celebratoryMessage }}
                </p>

                <div class="stats-panel">
                    <div class="stat-card">
                        <span class="stat-label">Players</span>
                        <span class="stat-value">{{ playerStats.length }}</span>
                    </div>
                    <div class="stat-card stat-card--pulse">
                        <span class="stat-label">Total Food Items</span>
                        <span class="stat-value">{{ totalFoodItems }}</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-label">Top Score</span>
                        <span class="stat-value">{{ topScore }}</span>
                    </div>
                </div>
            </section>

            <section v-if="playerStats.length" class="leaderboard-section">
                <h2 class="section-title">Leaderboard</h2>
                <TransitionGroup name="board" tag="ul" class="leaderboard">
                    <li
                        v-for="(player, index) in playerStats"
                        :key="player.username"
                        :class="[
                            'score-card',
                            winners.some(
                                (winner) => winner.username === player.username,
                            )
                                ? 'score-card--winner'
                                : '',
                        ]"
                    >
                        <span class="score-rank" aria-hidden="true">
                            #{{ index + 1 }}
                        </span>
                        <div class="score-content">
                            <span class="score-name">{{
                                player.username
                            }}</span>
                            <span class="score-meta">
                                {{ player.total }} items ·
                                {{ player.variety }} types
                            </span>
                            <div
                                v-if="player.items.length"
                                class="score-foods"
                                role="list"
                            >
                                <span
                                    v-for="(
                                        foodItem, foodIndex
                                    ) in player.items"
                                    :key="`${player.username}-${foodIndex}-${foodItem.food_name}`"
                                    class="score-food-tag"
                                    role="listitem"
                                >
                                    {{ foodItem.food_name }}
                                </span>
                            </div>
                        </div>
                    </li>
                </TransitionGroup>
            </section>

            <section class="players-grid-section">
                <h2 class="section-title">Player Collections</h2>
                <div class="players-grid">
                    <div
                        v-for="(items, username) in userFoodItem"
                        :key="username"
                        class="player-card"
                        :class="
                            winners.some(
                                (winner) => winner.username === username,
                            )
                                ? 'player-card--champion'
                                : ''
                        "
                    >
                        <Card class="player-card-inner">
                            <CardContent class="player-card-content">
                                <h3 class="player-name">{{ username }}</h3>

                                <ul class="food-list">
                                    <li
                                        v-for="(foodItem, index) in items"
                                        :key="index"
                                        class="food-item"
                                    >
                                        <span class="food-name">{{
                                            foodItem.food_name
                                        }}</span>
                                        <span
                                            class="food-tag"
                                            :class="
                                                typeColors[foodItem.type] ||
                                                typeColors.default
                                            "
                                        >
                                            {{ foodItem.type }}
                                        </span>
                                    </li>
                                </ul>
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

<style scoped>
.end-screen {
    position: relative;
    min-height: 100vh;
    background: #0f172a;
    color: #f8fafc;
    overflow: hidden;
    padding: 6rem 1.5rem 4rem;
    display: flex;
    justify-content: center;
}

.content-wrapper {
    position: relative;
    z-index: 10;
    width: 100%;
    max-width: 1100px;
    display: flex;
    flex-direction: column;
    gap: 4rem;
}

.hero-gradient {
    position: absolute;
    inset: 0;
    background:
        radial-gradient(
            circle at top,
            rgba(129, 140, 248, 0.35),
            rgba(15, 23, 42, 0.95)
        ),
        radial-gradient(
            circle at 10% 90%,
            rgba(244, 114, 182, 0.3),
            transparent 55%
        ),
        radial-gradient(
            circle at 90% 10%,
            rgba(129, 230, 217, 0.25),
            transparent 45%
        );
    animation: gradientShift 20s ease infinite;
    opacity: 0.9;
}

.floating-orb {
    position: absolute;
    border-radius: 9999px;
    filter: blur(0);
    mix-blend-mode: screen;
    opacity: 0.6;
}

.orb-one {
    width: 280px;
    height: 280px;
    background: rgba(79, 70, 229, 0.35);
    top: 12%;
    left: 5%;
    animation: float 16s ease-in-out infinite;
}

.orb-two {
    width: 360px;
    height: 360px;
    background: rgba(244, 114, 182, 0.28);
    bottom: 10%;
    right: 8%;
    animation: float 18s ease-in-out infinite reverse;
}

.orb-three {
    width: 220px;
    height: 220px;
    background: rgba(34, 211, 238, 0.22);
    bottom: 18%;
    left: 20%;
    animation: float 22s ease-in-out infinite;
}

.hero-section {
    text-align: center;
    display: grid;
    gap: 1.5rem;
    animation: fadeSlide 0.9s ease forwards;
}

.eyebrow {
    letter-spacing: 0.4em;
    text-transform: uppercase;
    font-size: 0.75rem;
    color: rgba(224, 231, 255, 0.75);
}

.headline {
    font-size: clamp(2.5rem, 6vw, 3.75rem);
    font-weight: 800;
    letter-spacing: -0.02em;
}

.highlight {
    color: #a855f7;
    text-shadow: 0 0 20px rgba(168, 85, 247, 0.4);
}

.lede {
    max-width: 620px;
    margin: 0 auto;
    font-size: 1.1rem;
    line-height: 1.7;
    color: rgba(226, 232, 240, 0.85);
}

.stats-panel {
    display: flex;
    justify-content: center;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.stat-card {
    padding: 1rem 1.5rem;
    border-radius: 1.5rem;
    background: rgba(30, 41, 59, 0.65);
    border: 1px solid rgba(148, 163, 184, 0.1);
    box-shadow: 0 18px 50px -25px rgba(15, 23, 42, 0.55);
    backdrop-filter: blur(14px);
    min-width: 160px;
    animation: fadeIn 0.9s ease both;
}

.stat-card--pulse {
    animation:
        fadeIn 0.9s ease both,
        pulse 3s ease-in-out infinite;
}

.stat-label {
    display: block;
    font-size: 0.75rem;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: rgba(148, 163, 184, 0.85);
    margin-bottom: 0.35rem;
}

.stat-value {
    font-size: 1.75rem;
    font-weight: 700;
}

.section-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: rgba(226, 232, 240, 0.95);
    margin-bottom: 1.75rem;
    text-align: center;
    letter-spacing: 0.02em;
}

.leaderboard-section {
    animation: fadeSlide 1.2s ease forwards;
}

.leaderboard {
    display: grid;
    gap: 1rem;
    max-width: 640px;
    margin: 0 auto;
}

.score-card {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    padding: 1.1rem 1.35rem;
    border-radius: 1.25rem;
    background: rgba(30, 41, 59, 0.7);
    border: 1px solid rgba(99, 102, 241, 0.18);
    box-shadow: 0 16px 40px -20px rgba(129, 140, 248, 0.35);
    backdrop-filter: blur(12px);
}

.score-card--winner {
    background: linear-gradient(
        135deg,
        rgba(168, 85, 247, 0.72),
        rgba(59, 130, 246, 0.65)
    );
    color: #f8fafc;
    box-shadow: 0 20px 60px -15px rgba(168, 85, 247, 0.6);
}

.score-rank {
    font-size: 1.4rem;
    font-weight: 700;
    width: 42px;
    text-align: center;
    color: rgba(226, 232, 240, 0.75);
}

.score-card--winner .score-rank {
    color: rgba(15, 23, 42, 0.85);
}

.score-content {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.score-name {
    font-size: 1.15rem;
    font-weight: 600;
}

.score-meta {
    font-size: 0.85rem;
    color: rgba(203, 213, 225, 0.85);
}

.score-foods {
    display: flex;
    flex-wrap: wrap;
    gap: 0.45rem;
    margin-top: 0.75rem;
}

.score-food-tag {
    padding: 0.3rem 0.65rem;
    border-radius: 9999px;
    background: rgba(148, 163, 184, 0.16);
    border: 1px solid rgba(148, 163, 184, 0.22);
    font-size: 0.75rem;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    color: rgba(226, 232, 240, 0.9);
}

.score-card--winner .score-food-tag {
    background: rgba(15, 23, 42, 0.18);
    border-color: rgba(15, 23, 42, 0.24);
    color: rgba(15, 23, 42, 0.9);
}

.players-grid-section {
    animation: fadeSlide 1.4s ease forwards;
}

.players-grid {
    display: grid;
    gap: 1.5rem;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
}

.player-card {
    animation: floatUp 1.1s ease both;
}

.player-card--champion {
    animation:
        floatUp 1.1s ease both,
        glow 2.8s ease-in-out infinite;
}

.player-card-inner {
    background: rgba(15, 23, 42, 0.65) !important;
    border-radius: 1.5rem !important;
    border: 1px solid rgba(148, 163, 184, 0.15);
    backdrop-filter: blur(18px);
    box-shadow: 0 20px 48px -20px rgba(15, 23, 42, 0.7);
    transition:
        transform 0.4s ease,
        box-shadow 0.4s ease;
}

.player-card:hover .player-card-inner {
    transform: translateY(-6px) scale(1.01);
    box-shadow: 0 28px 64px -22px rgba(59, 130, 246, 0.45);
}

.player-card-content {
    padding: 1.75rem;
    display: grid;
    gap: 1rem;
}

.player-name {
    font-size: 1.35rem;
    font-weight: 700;
    text-align: center;
}

.food-list {
    display: grid;
    gap: 0.75rem;
}

.food-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 0.9rem;
    border-radius: 0.9rem;
    background: rgba(30, 41, 59, 0.75);
    border: 1px solid rgba(148, 163, 184, 0.12);
    transition:
        transform 0.3s ease,
        background 0.3s ease;
}

.food-item:hover {
    transform: translateY(-4px);
    background: rgba(59, 130, 246, 0.12);
}

.food-name {
    font-weight: 600;
}

.food-tag {
    padding: 0.35rem 0.8rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.08em;
}

.board-enter-active,
.board-leave-active {
    transition: all 0.45s ease;
}

.board-enter-from,
.board-leave-to {
    opacity: 0;
    transform: translateY(18px) scale(0.97);
}

.board-move {
    transition: transform 0.35s ease;
}

@keyframes gradientShift {
    0% {
        transform: scale(1) rotate(0deg);
    }
    50% {
        transform: scale(1.05) rotate(2deg);
    }
    100% {
        transform: scale(1) rotate(0deg);
    }
}

@keyframes float {
    0%,
    100% {
        transform: translateY(0) translateX(0);
    }
    50% {
        transform: translateY(-24px) translateX(18px);
    }
}

@keyframes fadeSlide {
    0% {
        opacity: 0;
        transform: translateY(24px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    0% {
        opacity: 0;
        transform: scale(0.95);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes pulse {
    0%,
    100% {
        box-shadow: 0 18px 50px -25px rgba(129, 140, 248, 0.1);
    }
    50% {
        box-shadow: 0 18px 50px -10px rgba(129, 140, 248, 0.45);
    }
}

@keyframes floatUp {
    0% {
        opacity: 0;
        transform: translateY(24px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes glow {
    0%,
    100% {
        box-shadow: 0 20px 60px -18px rgba(168, 85, 247, 0.3);
    }
    50% {
        box-shadow: 0 20px 60px -12px rgba(59, 130, 246, 0.55);
    }
}

@media (max-width: 640px) {
    .stat-card {
        min-width: 140px;
    }

    .leaderboard {
        gap: 0.75rem;
    }

    .score-card {
        padding: 1rem;
        flex-direction: column;
        align-items: flex-start;
    }

    .score-rank {
        width: auto;
        font-size: 1.1rem;
    }

    .score-foods {
        gap: 0.35rem;
    }

    .score-food-tag {
        font-size: 0.7rem;
    }
}
</style>
