
<script setup>
import AdminLayout from  '@/Layouts/AdminLayout.vue'
import { Link, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';

defineProps({
    permissions:Array,
 })
const form = useForm({})
const showConfirmDeletePermission  = ref(false)
const closeModal  = () => {
    showConfirmDeletePermission.value = false;
}
const confirmDeletePermission  = () => {
    showConfirmDeletePermission.value = true;
}
const deletePermission = (id) => {
    form.delete(route('permissions.destroy',id),{
        onSuccess : closeModal()
    })
    form.reset();
}

const searchQuery = ref('')
const searchPermissions = () => {
      router.get(route('permissions.index'), { search_permission: searchQuery.value }, {
        preserveState: true,
        replace: true
      });
    };
</script>

<template>
    <AdminLayout>
        <div class="flex justify-between m-5">
            <h1>Permissions </h1>
            <Link :href="route('permissions.create')">
                <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Create
                </button>

            </Link>
        </div>
       <div class="mx-5">
    
        
        <div class="relative overflow-x-auto p-3 shadow-sm sm:rounded-lg">
            <div class="flex items-center justify-end flex-column md:flex-row flex-wrap space-y-4 md:space-y-0 py-4 bg-white dark:bg-gray-900">
                
                 <div class="flex">
                    
                    <form @submit.prevent="searchPermissions" method="get">
                        <input type="text" v-model="searchQuery" id="table-search-users" class=" mx-2 pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for permissions">
                        <button type="submit" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">
                            Search
                        </button>
                    </form>
                </div>
            </div>
            <table class="w-full  text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            NAME
                        </th>
                      
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody  v-if="permissions.length">
                    <tr v-for="(permission,index) in permissions " :key="index" class="bg-white   dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                           {{permission.id}}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                    {{permission.name}}
                                </span>

                            </div>
                        </td>
                        <td class="px-6  py-4">
                            <Link :href="route('permissions.edit',permission.id)"  class="font-medium mx-2 text-blue-600 dark:text-blue-500 hover:underline">edit</Link>
                            <!-- <Link @click="confirmUserDeletion" :href="route('permissions.destroy',permission.id)"  method="delete" class="font-medium text-red-500 dark:text-red-500 hover:underline">delete</Link> -->
                            <button @click="confirmDeletePermission" class="font-medium text-red-500 dark:text-red-500 hover:underline">delete</button>

                            <!-- modal show -->
                            <Modal :show="showConfirmDeletePermission" @close="closeModal">
                                    <div class="p-6">
                                        <h2 class="text-lg font-medium text-gray-900">
                                            Are you sure you want to delete your Permission?
                                        </h2>
                                       

                                        <div class="mt-4">
                                            <DangerButton class="me-2" @click="deletePermission(role.id)">Delete</DangerButton>
                                            <SecondaryButton @click="closeModal">Cancel</SecondaryButton>

                                        </div>
                                    </div>
                            </Modal>

                        </td>
                         
                    </tr>
                   
                </tbody>
            </table>
        </div>
       

       </div>
    </AdminLayout>
</template>

<style lang="css" scoped>

</style>