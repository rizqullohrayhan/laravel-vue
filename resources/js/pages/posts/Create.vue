<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, PostForm } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label'
import { Textarea } from '@/components/ui/textarea';
import { LoaderCircle } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create Posts',
        href: '/posts',
    },
];

const form = useForm<PostForm>({
    title: '',
    content: '',
    image: null,
});

const imagePreview = ref<string | null>(null);

const submit = () => {
    form.post(route('posts.store'));
};

const handleImageInput = (e: Event) => {
    const target = e.target as HTMLInputElement;
    const file = target.files?.[0];
    if (file) {
        form.image = file;
        imagePreview.value = URL.createObjectURL(file);
    }
}
</script>

<template>
    <Head title="Create Posts" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="min-w-md mx-auto p-6 mt-8 bg-white dark:bg-neutral-800 shadow-lg rounded-xl">
                <form @submit.prevent="submit" class="flex flex-col gap-6">
                    <div class="grid gap-6">
                        <div class="grid gap-2">
                            <Label for="title">Title</Label>
                            <Input
                                id="title"
                                type="text"
                                required
                                autofocus
                                :tabindex="1"
                                autocomplete="title"
                                v-model="form.title"
                                placeholder="Input title here"
                            />
                            <InputError :message="form.errors.title" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="image">Image</Label>
                            <Input
                                id="image"
                                type="file"
                                accept=".jpg,.png,.jpeg"
                                required
                                :tabindex="2"
                                @change="handleImageInput"
                            />
                            <img v-if="imagePreview" :src="imagePreview" alt="Preview" class="h-12 w-12 object-cover rounded-full" />
                            <InputError :message="form.errors.image" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="content">Content</Label>
                            <Textarea
                                id="image"
                                type="text"
                                required
                                :tabindex="3"
                                autocomplete="content"
                                v-model="form.content"
                                placeholder="Input content here"
                            />
                            <InputError :message="form.errors.content" />
                        </div>

                        <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                            <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                            Create
                        </Button>
                    </div>

                </form>
            </div>
        </div>
    </AppLayout>
</template>
