
<script setup>
import AdminLayout from  '@/Layouts/AdminLayout.vue'
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import VueMultiselect from "vue-multiselect";
import { onMounted,watch } from "vue";



const props= defineProps({
    user:Object,
    roles:Array,
    permissions:Array,
    required:true
})

const form =useForm({
    id:props.user.id,
    name:props.user.name,
    email:props.user.email,
    password:props.user.password,
    password_confirmation: '',
    roles:[],
    permissions:[]
});


const submit = () => {
    form.put(route('users.update',form));
};

onMounted(()=>{
    form.roles =props.user?.roles
    form.permissions =props.user?.permissions;
})
watch(
    ()=>props.user,
    ()=>{
        form.permissions = props.user?.permissions,
        form.roles = props.user?.roles
    }
)
</script>

<template>
    <Head title="Edit User" />

    <AdminLayout>
        <div class="flex justify-between m-5">
            <h1>Edit User</h1>
            
            
            <Link :href="route('users.index')">
                <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Back
                </button>

            </Link>
        </div>
        <div class="p-6 m-5  dark:bg-gray-800 dark:border-gray-700">

            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="name" value="Name" />

                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        
                        autofocus
                        autocomplete="name"
                    />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mt-4">
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        
                        autocomplete="username"
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Password" />

                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        
                        autocomplete="new-password"
                    />

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password_confirmation" value="Confirm Password" />

                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password_confirmation"
                        
                        autocomplete="new-password"
                    />

                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>
                <div class=" mt-4">
                    <InputLabel for="role" value="Role" />
                    <VueMultiselect
                        v-model="form.roles"
                        :options="roles"
                        :multiple="true"
                        :close-on-select="true"
                        placeholder="Pick some"
                        label="name"
                        track-by="name"
                    />
                </div>
                <div class=" mt-4">
                    <InputLabel for="permissions" value="Permissions" />
                    <VueMultiselect
                        v-model="form.permissions"
                        :options="permissions"
                        :multiple="true"
                        :close-on-select="true"
                        placeholder="Pick some"
                        label="name"
                        track-by="name"
                    />
                </div>
                <div class="flex items-center justify-end mt-4">
                   

                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Save
                    </PrimaryButton>
                </div>
            </form>
        </div>
         <!---user roles-->
         <div class=" m-3 ">
                <h1 class="my-2">Roles User</h1>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">NAME</th>

                            <th scope="col" class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody v-if="user.roles.length">
                        <tr
                            v-for="(userRole, index) in user.roles"
                            :key="index"
                            class="bg-white dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                        >
                            <td class="px-6 py-4">
                                {{ userRole.id }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <span
                                        class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300"
                                    >
                                        {{ userRole.name }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                               
                                    <Link
                                    :href="
                                    route('users.roles.destroy', [
                                        user.id,
                                        userRole.id,
                                    ])
                                    "
                                    method="DELETE"
                                    as="button"
                                    class="text-red-400 hover:text-red-600"
                                    preserve-scroll>Revoke</Link
                                
                                    >
                                 
                            </td>
                            
                        </tr>
                    </tbody>
                </table>
        </div>
        <!---user permissions-->

        <div class=" m-3 ">
                <h1 class="my-2">Permissions User</h1>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">NAME</th>

                            <th scope="col" class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody v-if="user.permissions.length">
                        <tr
                            v-for="(userPermission, index) in user.permissions"
                            :key="index"
                            class="bg-white dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                        >
                            <td class="px-6 py-4">
                                {{ userPermission.id }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <span
                                        class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300"
                                    >
                                        {{ userPermission.name }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                 <Link
                                    :href="
                                    route('users.permissions.destroy', [
                                        user.id,
                                        userPermission.id,
                                    ])
                                    "
                                    method="DELETE"
                                    as="button"
                                    class="text-red-400 hover:text-red-600"
                                    preserve-scroll>Revoke</Link
                                > 
                            </td>
                        </tr>
                    </tbody>
                </table>
        </div>
    </AdminLayout>
</template>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
