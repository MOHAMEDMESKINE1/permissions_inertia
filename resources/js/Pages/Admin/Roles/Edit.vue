<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import VueMultiselect from "vue-multiselect";
import { onMounted,watch } from "vue";

const props = defineProps({
    role: {
        Object,
        required: true,
    },
    permissions: Array,
});
onMounted(()=>{
    form.permissions =props.role?.permissions;
})
watch(
    ()=>props.role,
    ()=>form.permissions = props.role?.permissions
)
const form = useForm({
    id: props.role.id,
    name: props.role.name,
    permissions: [],
});

const submit = () => {
    form.put(route("roles.update", form));
};
</script>

<template>
    <Head title="Edit Role" />
    <AdminLayout>
        <div class="flex justify-between m-5">
            <h1>Edit Role</h1>

            <Link :href="route('roles.index')">
                <button
                    type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                >
                    Back
                </button>
            </Link>
        </div>
        <div class="mx-5">
            <div
                class="p-6 bg-white  mx-auto  dark:bg-gray-800 dark:border-gray-700"
            >
                <form @submit.prevent="submit" class="">
                    <div>
                        <InputLabel for="name" value="name" />

                        <TextInput
                            id="name"
                            type="name"
                            class="mt-1 p-2 border block w-full"
                            v-model="form.name"
                            autofocus
                            autocomplete="username"
                        />

                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="flex justify-start mt-4">
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

                    <div class="flex justify-start mt-4">
                        <PrimaryButton
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Save
                        </PrimaryButton>
                    </div>
                </form>
            </div>
            <div class=" m-3 ">
                <h1 class="my-2">Permissions Role</h1>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">NAME</th>

                            <th scope="col" class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody v-if="role.permissions.length">
                        <tr
                            v-for="(RolePermission, index) in role.permissions"
                            :key="index"
                            class="bg-white dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                        >
                            <td class="px-6 py-4">
                                {{ RolePermission.id }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <span
                                        class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300"
                                    >
                                        {{ RolePermission.name }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <Link 
                                    :href="route('roles.permissions.destroy',
                                    [role.id, RolePermission.id])"
                                    method="delete"
                                    class="font-medium text-red-500 dark:text-red-500 hover:underline">
                                    
                            Revoke</Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
