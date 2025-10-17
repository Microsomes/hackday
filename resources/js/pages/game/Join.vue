<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { useEchoPresence } from '@laravel/echo-vue';
import { onMounted } from 'vue';

const props = defineProps({
    isLoggedIn: {
        type: Boolean
    },
    username: {
        type: String
    },
    gameRound: {
        type: Number
    },
    game:{
        type: Object
    }
})

const form = useForm({
    username:''
})

const addFoodItem = useForm({
    main:"",
    side:"",
    drink:""
})

function loginAnnon(){
    form.post('/loginAnnon', {
        preserveUrl:true
    })
}

function submitBreakfast() {
    addFoodItem.post('/submit-food-in-game/'+ props.game.id, {
        preserveScroll: true
    })
}

onMounted(()=>{
})

    const { channel:precenseChannel } = useEchoPresence('waiting-room2');

    onMounted(()=>{
        precenseChannel().here(function(u){
            console.log(u)
        })

        precenseChannel().joining(function(joinedUser){
            console.log("someone joined:", joinedUser)
        })

         precenseChannel().leaving(function(leftUser){
            console.log("someone joined:", leftUser)
        })

    })

</script>

<template>
    <Head title="Join Battle" />

    <div class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-b from-yellow-50 to-yellow-100 p-4">
        <h1 class="text-4xl font-extrabold text-center pb-10 pt-4 text-yellow-800 drop-shadow-md">
            Join the Breakfast Battle!
        </h1>

        <!-- Pre-start welcome + breakfast form -->
        <div v-if="isLoggedIn && gameRound === 0" class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-lg flex flex-col gap-6">
            <p class="text-gray-800 text-lg text-center font-medium">
                Welcome <span class="font-bold">{{ username }}</span>! We are in the pre-start round. Enter your breakfast below:
            </p>

            <form @submit.prevent="submitBreakfast" class="flex flex-col gap-4">
                <div class="flex flex-col">
                    <label class="text-gray-700 font-semibold mb-1" for="main">Main Dish</label>
                    <input
                        id="main"
                        type="text"
                        v-model="addFoodItem.main"
                        placeholder="E.g., Pancakes"
    class="border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-300"
                    />
                    <p v-if="addFoodItem.errors.main" class="text-red-500 text-sm mt-1">{{ addFoodItem.errors.main }}</p>
                </div>

                <div class="flex flex-col">
                    <label class="text-gray-700 font-semibold mb-1" for="side">Side Dish</label>
                    <input
                        id="side"
                        type="text"
                        v-model="addFoodItem.side"
                        placeholder="E.g., Bacon"
    class="border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-300"
                    />
                    <p v-if="addFoodItem.errors.side" class="text-red-500 text-sm mt-1">{{ addFoodItem.errors.side }}</p>
                </div>

                <div class="flex flex-col">
                    <label class="text-gray-700 font-semibold mb-1" for="drink">Drink</label>
                    <input
                        id="drink"
                        type="text"
                        v-model="addFoodItem.drink"
                        placeholder="E.g., Orange Juice"
    class="border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-300"
                    />
                    <p v-if="addFoodItem.errors.drink" class="text-red-500 text-sm mt-1">{{ addFoodItem.errors.drink }}</p>
                </div>

                <button 
                    type="submit"
                    class="bg-yellow-500 text-white font-bold rounded-lg px-4 py-2 hover:bg-yellow-600 transition shadow-md"
                >
                    Submit Breakfast
                </button>
            </form>
        </div>

        <!-- Login form -->
        <div v-if="!isLoggedIn" class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-sm">
            <p class="text-gray-700 mb-4 text-center text-lg font-medium">
                You are not logged in. To join, just enter a username:
            </p>
            
            <form @submit.prevent="loginAnnon" class="flex flex-col gap-4">
                <input 
                    type="text" 
                    placeholder="Enter a username" 
                    v-model="form.username" 
    class="border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-300"
                />
                <p v-if="form.errors.username" class="text-red-500 text-sm mt-1">{{ form.errors.username }}</p>

                <button 
                    type="submit"
                    class="bg-indigo-600 text-white font-semibold rounded-lg px-4 py-2 hover:bg-indigo-700 transition shadow-md"
                >
                    Join
                </button>
            </form>
        </div>
    </div>
</template>
