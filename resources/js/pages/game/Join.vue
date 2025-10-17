<script setup lang="ts">
import { router, useForm, usePage } from '@inertiajs/vue3';
import { useEchoPresence, useEchoPublic } from '@laravel/echo-vue';
import { onMounted, ref } from 'vue';

const props = defineProps({
    isLoggedIn: {
        type: Boolean,
    },
    username: {
        type: String,
    },
    gameRound: {
        type: Number,
    },
    game: {
        type: Object,
    },
    food_item_submitted:{
        type: Boolean
    }
});

const form = useForm({
    username: '',
});

const addFoodItem = useForm({
    main: '',
    side: '',
    drink: '',
});

const presenceUsers = ref<string[]>([]);

function loginAnnon() {
    form.post('/loginAnnon', {
        preserveUrl: true,
    });
}

function submitBreakfast() {
    addFoodItem.post('/submit-food-in-game/' + props.game.id, {
        preserveScroll: true,
    });
}

const { channel: presenceChannel } = useEchoPresence('waiting-room2');

onMounted(() => {
    const channel = presenceChannel();

    channel.here((users) => {
        presenceUsers.value = users
            .map((user) => user?.username)
            .filter((username): username is string => Boolean(username));
    });

    channel.joining((joinedUser) => {
        const username = joinedUser?.username;
        if (username && !presenceUsers.value.includes(username)) {
            presenceUsers.value = [...presenceUsers.value, username];
        }
    });

    channel.leaving((leftUser) => {
        const username = leftUser?.username;
        if (username) {
            presenceUsers.value = presenceUsers.value.filter(
                (name) => name !== username,
            );
        }
    });
});

    const page = usePage();
    const flashMessage = page.props.flash?.success;

    onMounted(()=>{
        console.log(flashMessage);
    })


    useEchoPublic('waiting-room', ".GameStarted", (e)=>{
    console.log("the game has started")
    router.get('/')
    })

</script>

<template>
    <Head title="Join Battle" />

   <div 
    v-if="flashMessage"
    class="max-w-md mx-auto mt-4 p-4 text-center text-white rounded-lg shadow-md
           bg-green-500 border border-green-600
           transition-all duration-300 ease-in-out"
>
    {{ flashMessage }}
</div>

    <div
        class="flex min-h-screen flex-col items-center justify-center bg-gradient-to-b from-yellow-50 to-yellow-100 p-4"
    >
        <h1
            class="pt-4 pb-10 text-center text-4xl font-extrabold text-yellow-800 drop-shadow-md"
        >
            Join the Breakfast Battle! 
        </h1>

        <div
            v-if="presenceUsers.length"
            class="mb-8 w-full max-w-lg rounded-2xl bg-white/80 p-6 text-center shadow-md backdrop-blur"
        >
            <h2 class="mb-3 text-xl font-semibold text-yellow-800">
                Waiting Room
            </h2>
            <p class="mb-4 text-sm text-gray-600">Currently hanging out:</p>
            <ul class="flex flex-wrap justify-center gap-2">
                <li
                    v-for="user in presenceUsers"
                    :key="user"
                    class="rounded-full bg-yellow-100 px-4 py-1 text-sm font-medium text-yellow-800 shadow"
                >
                    {{ user }}
                </li>
            </ul>
        </div>

        <!-- Pre-start welcome + breakfast form -->
        <div
            v-if="isLoggedIn && gameRound === 0"
            class="flex w-full max-w-lg flex-col gap-6 rounded-2xl bg-white p-8 shadow-xl"
        >
            <p class="text-center text-lg font-medium text-gray-800">
                Welcome <span class="font-bold">{{ username }}</span
                >! We are in the pre-start round. Enter your breakfast below:
            </p>
            
            <div class="text-black" v-if="food_item_submitted">
                Your breakfast menu has been submitted awaiting others...
            </div>

            <form v-if="!food_item_submitted" @submit.prevent="submitBreakfast" class="flex flex-col gap-4">
                <div class="flex flex-col">
                    <label class="mb-1 font-semibold text-gray-700" for="main"
                        >Main Dish</label
                    >
                    <input
                        id="main"
                        type="text"
                        v-model="addFoodItem.main"
                        placeholder="E.g., Pancakes"
                        class="rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-gray-800 placeholder-gray-400 focus:border-yellow-300 focus:ring-2 focus:ring-yellow-400 focus:outline-none"
                    />
                    <p
                        v-if="addFoodItem.errors.main"
                        class="mt-1 text-sm text-red-500"
                    >
                        {{ addFoodItem.errors.main }}
                    </p>
                </div>

                <div class="flex flex-col">
                    <label class="mb-1 font-semibold text-gray-700" for="side"
                        >Side Dish</label
                    >
                    <input
                        id="side"
                        type="text"
                        v-model="addFoodItem.side"
                        placeholder="E.g., Bacon"
                        class="rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-gray-800 placeholder-gray-400 focus:border-yellow-300 focus:ring-2 focus:ring-yellow-400 focus:outline-none"
                    />
                    <p
                        v-if="addFoodItem.errors.side"
                        class="mt-1 text-sm text-red-500"
                    >
                        {{ addFoodItem.errors.side }}
                    </p>
                </div>

                <div class="flex flex-col">
                    <label class="mb-1 font-semibold text-gray-700" for="drink"
                        >Drink</label
                    >
                    <input
                        id="drink"
                        type="text"
                        v-model="addFoodItem.drink"
                        placeholder="E.g., Orange Juice"
                        class="rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-gray-800 placeholder-gray-400 focus:border-yellow-300 focus:ring-2 focus:ring-yellow-400 focus:outline-none"
                    />
                    <p
                        v-if="addFoodItem.errors.drink"
                        class="mt-1 text-sm text-red-500"
                    >
                        {{ addFoodItem.errors.drink }}
                    </p>
                </div>

                <button
                    type="submit"
                    class="rounded-lg bg-yellow-500 px-4 py-2 font-bold text-white shadow-md transition hover:bg-yellow-600"
                >
                    Submit Breakfast
                </button>
            </form>
        </div>

        <!-- Login form -->
        <div
            v-if="!isLoggedIn"
            class="w-full max-w-sm rounded-2xl bg-white p-8 shadow-xl"
        >
            <p class="mb-4 text-center text-lg font-medium text-gray-700">
                You are not logged in. To join, just enter a username:
            </p>

            <form @submit.prevent="loginAnnon" class="flex flex-col gap-4">
                <input
                    type="text"
                    placeholder="Enter a username"
                    v-model="form.username"
                    class="rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-gray-800 placeholder-gray-400 focus:border-yellow-300 focus:ring-2 focus:ring-yellow-400 focus:outline-none"
                />
                <p
                    v-if="form.errors.username"
                    class="mt-1 text-sm text-red-500"
                >
                    {{ form.errors.username }}
                </p>

                <button
                    type="submit"
                    class="rounded-lg bg-indigo-600 px-4 py-2 font-semibold text-white shadow-md transition hover:bg-indigo-700"
                >
                    Join
                </button>
            </form>
        </div>
    </div>
</template>
