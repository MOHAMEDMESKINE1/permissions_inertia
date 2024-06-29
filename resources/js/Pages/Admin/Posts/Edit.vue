
<script setup>
import AdminLayout from  '@/Layouts/AdminLayout.vue'
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
})
const form =useForm({
    title:props.post.title,
});
const submit = () => {
    form.put(route('posts.update',props.post.id));
};
</script>

<template>
     <Head title="Edit Post" />
    <AdminLayout>
        <div class="flex justify-between m-5">
            <h1>posts Index</h1>
            
            
            <Link :href="route('posts.index')">
                <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Back
                </button>
            </Link>
        </div>
       <div class="mx-5">
        <div class="p-6 bg-white border border-gray-200  mx-auto rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <form @submit.prevent="submit" class="">
                    <div>
                        <InputLabel for="title" value="title" />

                        <TextInput
                            id="title"
                            type="title"
                            class="mt-1 p-2 border block w-full"
                            v-model="form.title"
                            
                            autofocus
                            autocomplete="title"
                        />

                        <InputError class="mt-2" :message="form.errors.title" />
                    </div>

                    <div class="flex  justify-start mt-4">
                    
                        <PrimaryButton  :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Save
                        </PrimaryButton>
                    </div>
                </form>
        </div>
       </div>
    </AdminLayout>
</template>

