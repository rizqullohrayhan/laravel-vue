<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Post } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { toast } from 'vue-sonner';
import { onMounted, watch } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Posts',
        href: '/posts',
    },
];

defineProps<{ posts: Post[] }>();

interface Flash {
    success?: null;
    error?: null;
}

onMounted(() => {
    watch(() => usePage().props.flash as Flash,
        (flash: Flash) => {
            if (flash?.success) {
                toast.success(flash.success);
                flash.success = null;
            }
            if (flash?.error) {
                toast.error(flash.error);
                flash.error = null;
            }
        },
        { immediate: true }
    );
})
</script>

<template>

    <Head title="Posts" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex justify-end">
                <Link href="/posts/create" class="text-indigo-500 hover:text-indigo-600">Create Post</Link>
            </div>
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <Table>
                    <TableCaption>A list of your recent post.</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-[100px]">
                                ID
                            </TableHead>
                            <TableHead>Title</TableHead>
                            <TableHead>Image</TableHead>
                            <TableHead class="text-right">
                                Action
                            </TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="post in posts" :key="post.id">
                            <TableCell class="font-medium">
                                {{ post.id }}
                            </TableCell>
                            <TableCell>{{ post.title }}</TableCell>
                            <TableCell>
                                <img :src="post.image ?? ''" alt="" class="h-12 w-12 rounded object-cover">
                            </TableCell>
                            <TableCell class="flex justify-end gap-2">
                                <Link :href="route('posts.edit', post.id)" class="text-yellow-500 hover:text-yellow-600">Edit</Link>
                                <Link :href="route('posts.destroy', post.id)" method="delete" as="button" class="text-red-500 hover:text-red-600 hover:cursor-pointer">Delete</Link>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
