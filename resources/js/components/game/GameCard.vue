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

export default defineComponent({
    components: {
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
                    <CardTitle><h2 class="text-center">Drink</h2></CardTitle>
                </CardHeader>

                <ContextMenu>
                    <ContextMenuTrigger>
                        <CardContent> 1 x Latte </CardContent>
                    </ContextMenuTrigger>
                    <ContextMenuContent>
                        <ContextMenuItem class="text-xl"
                            >🥷🏻 Steal</ContextMenuItem
                        >
                        <ContextMenuItem class="text-xl"
                            >🔄 Swap</ContextMenuItem
                        >
                    </ContextMenuContent>
                </ContextMenu>
            </Card>
            <Card class="mt-4 mb-4">
                <CardHeader>
                    <CardTitle><h2 class="text-center">Main</h2></CardTitle>
                </CardHeader>
                <CardContent> 1 x Pancakes w/ Bacon </CardContent>
            </Card>
            <Card>
                <CardHeader>
                    <CardTitle><h2 class="text-center">Side</h2></CardTitle>
                </CardHeader>
                <CardContent> 1 x Latte </CardContent>
            </Card>
        </CardContent>
        <CardFooter class="flex justify-between px-6 pb-6"> </CardFooter>
    </Card>
</template>
