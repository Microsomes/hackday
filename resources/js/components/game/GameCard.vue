<script lang="ts">
    import { defineComponent, defineEmits } from 'vue';
    import {
        Card,
        CardContent,
        CardFooter,
        CardHeader,
        CardTitle,
    } from '@/components/ui/card';
    import { Button } from '@/components/ui/button';

    export default defineComponent({
        components: {
            Button,
            CardTitle,
            CardHeader,
            Card,
            CardFooter,
            CardContent,
        },
    });
</script>

<template>
    <Card class="w-[350px]">
        <CardHeader>
            <CardTitle><h2 class="text-center text-3xl">Nick</h2></CardTitle>
        </CardHeader>
        <CardContent>
            <Card>
                <CardHeader>
                    <CardTitle><h2 class="text-center">☕️ Drink</h2></CardTitle>
                </CardHeader>
                <CardContent>
                    <p class="mb-2">Latte</p>
                    <ButtonGroup class="round1 flex items-center justify-center">
                        <Button class="mr-4 bg-blue-100 text-black"
                        >🥷🏻 Steal</Button
                        >
                        <Button class="bg-blue-100 text-black">🔄 Swap</Button>
                    </ButtonGroup>
                </CardContent>
            </Card>
            <Card class="mt-2 mb-2">
                <CardHeader>
                    <CardTitle><h2 class="text-center">🥯 Main</h2></CardTitle>
                </CardHeader>
                <CardContent>
                    <p class="mb-2">Pancakes w/ Bacon</p>
                    <ButtonGroup class="round2 flex items-center justify-center">
                        <Button class="mr-4 bg-blue-100 text-black"
                        >🥷🏻 Steal</Button
                        >
                        <Button
                            @click="emit('food-swap');"
                            class="bg-blue-100 text-black"
                        >🔄 Swap</Button
                        >
                    </ButtonGroup>
                </CardContent>
            </Card>
            <Card>
                <CardHeader>
                    <CardTitle><h2 class="text-center">🍩 Side</h2></CardTitle>
                </CardHeader>
                <CardContent>
                    <p class="mb-2">Hash Brown</p>
                    <ButtonGroup class="round3 flex items-center justify-center">
                        <Button class="bg-blue-100 text-black">🛡️Shield</Button>
                    </ButtonGroup>
                </CardContent>
            </Card>
        </CardContent>
        <CardFooter class="flex justify-between px-6 pb-6"> </CardFooter>
    </Card>
</template>
