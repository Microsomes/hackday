<script lang="ts">
import { defineComponent } from 'vue';
import {
    Card,
    CardContent,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import {
    ContextMenu,
    ContextMenuContent,
    ContextMenuItem,
    ContextMenuTrigger,
} from '@/components/ui/context-menu';
import { Button } from '@/components/ui/button';

export default defineComponent({
    components: {
        Button,
        CardTitle,
        ContextMenuTrigger,
        CardHeader,
        ContextMenuItem,
        Card,
        CardFooter,
        ContextMenu,
        ContextMenuContent,
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
                    <ButtonGroup class="flex items-center justify-center">
                        <Button class="mr-4 bg-blue-100 text-black">🥷🏻 Steal</Button>
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
                    <ButtonGroup class="flex items-center justify-center">
                        <Button class="mr-4 bg-blue-100 text-black">🥷🏻 Steal</Button>
                        <Button class="bg-blue-100 text-black">🔄 Swap</Button>
                    </ButtonGroup>
                </CardContent>
            </Card>
            <Card>
                <CardHeader>
                    <CardTitle><h2 class="text-center">🍩 Side</h2></CardTitle>
                </CardHeader>
                <CardContent>
                    <p class="mb-2">Hash Brown</p>
                    <ButtonGroup class="flex items-center justify-center">
                        <Button class="bg-blue-100 text-black">🛡️Shield</Button>
                    </ButtonGroup>
                </CardContent>
            </Card>
            <Button class="mt-4 w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                Confirm
            </Button>
        </CardContent>
        <CardFooter class="flex justify-between px-6 pb-6"> </CardFooter>
    </Card>
</template>
