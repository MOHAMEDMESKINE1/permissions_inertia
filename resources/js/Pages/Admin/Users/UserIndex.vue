
<script setup>
import AdminLayout from  '@/Layouts/AdminLayout.vue'
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import {
Title,
Text,
Button,
CheckBox ,
Table,
LightButtonIcon ,
DropDownButton,
TextInput
}from 'vue-component-cua'
defineProps({
    users:Object,
})
const form = useForm({})
const showConfirmDeleteUser = ref(false)

const closeModal  = () => {
    showConfirmDeleteUser.value = false;
}
const confirmDeleteUser  = () => {
    showConfirmDeleteUser.value = true;
}

const deleteUser = (id) => {
    form.delete(route('users.destroy',id),{
        onSuccess : closeModal()
    })
    form.reset();
}
const searchQuery = ref('')
const searchUsers = () => {
      router.get(route('users.index'), { search_user: searchQuery.value }, {
        preserveState: true,
        replace: true
      });
    };

const headers = ref([
    {
        display : true,
        title:'Id',
        toggle:true,

    },
    {
        display: true,
        title:'Nom',
        toggle:true,

    },
    {
        display: true,
        title:'Email',
        toggle:true,

    }
])


</script>

<template>
    <AdminLayout>
        <div class="flex justify-between m-5">
            <Title type="h5">Permissions </Title>
            <Link :href="route('users.create')">
                <Button color="primary">
                    Create
                </Button>

            </Link>
        </div>
            <div class="relative overflow-x-auto p-3 shadow-sm sm:rounded-lg">
            <div class="flex items-center justify-end flex-column md:flex-row flex-wrap space-y-4 md:space-y-0 py-4 bg-white dark:bg-gray-900">
                
                
                    
                <form @submit.prevent="searchUsers" method="get">
                    
                
                    <div class="flex">
                        <TextInput  type="text" v-model="searchQuery" id="table-search-users"  placeholder="Search for users"></TextInput>
                    
                    <Button  type="submit">
                        Search
                    </button>
                    </div>
                </form>
                    
                
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
                <tbody>
                    <tr v-for="(role,index) in users " :key="index" class="bg-white   dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                           {{role.id}}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                    {{role.name}}
                                </span>

                            </div>
                        </td>
                        <td class="px-6  py-4">
                            <Link :href="route('users.edit',role.id)"  class="font-medium mx-2 text-blue-600 dark:text-blue-500 hover:underline">edit</Link>
                            <button @click="confirmDeleteUser" class="font-medium text-red-500 dark:text-red-500 hover:underline">delete</button>


                            <Modal :show="showConfirmDeleteUser" @close="closeModal">
                              <div class="p-6">
                                <Title type="h5" >
                                    Are you sure you want to delete your User?
                                </Title>
                               

                                <div class="mt-4">
                                    <Button color="error" class="me-2" @click="deleteUser(role.id)">Delete</Button>
                                    <Button @click="closeModal">Cancel</Button>

                                </div>
                              </div>
                            </Modal>
                        </td>
                         
                    </tr>
                   
                </tbody>
            </table>
            
        </div>
    </AdminLayout>
</template>

<style lang="css" scoped>

</style>