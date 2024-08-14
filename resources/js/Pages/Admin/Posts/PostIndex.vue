
<script setup>
import AdminLayout from  '@/Layouts/AdminLayout.vue'
import { Link,useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { usePermissions } from '@/composables/permissions';
import {Table,LightButtonIcon,Button} from 'vue-component-cua'
import AddModal from './Modals/AddModal.vue';
import EditModal from './Modals/EditModal.vue';
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";

defineProps({
    posts:Object,
   
})
const {hasPermission} = usePermissions()
const toast = useToast();
const confirm = useConfirm();

const form = useForm({})
const selectedPost = ref('')

const showConfirmDeletePost  = ref(false)

const closeModal  = () => {
    showConfirmDeletePost.value = false;
}

const showAddModal =  ref(false)
const showModal  = () => {
    showAddModal.value = true;
}
const confirmDeletePost = (id) => {
        confirm.require({
            message: 'Etes vous sure de supprimez ? ',
            header: 'Suppression',
            icon: 'pi pi-info-circle',
            rejectLabel: 'Annuler',
            acceptLabel: 'Supprimer',
            rejectProps: {
                label: 'Annuler',
                severity: 'secondary',
                outlined: true
            },
            acceptProps: {
                label: 'Supprimer',
                severity: 'danger'
            },
            accept: () => {
                deletePost(id)
            },
            reject: () => {
                toast.add({ severity: 'error', summary: 'Annulé', detail: '  ', life: 3000 });

            }
    });
    }


const deletePost = (id) => {
    form.delete(route('posts.destroy',id),{
        onSuccess : closeModal()
    })
    form.reset();
}

const searchPosts = (searchQuery) => {
      router.get(route('posts.index'), { search_post: searchQuery }, {
        preserveState: true,
        replace: true
      });
    };

    const headers = ref([
    {
        display: true,
        title: "ID",
        toggle: false,
        align: "start",
    },
    {
        display: true,
        title: "Title",
        toggle: false,
        align: "start",
    },
    {
        display: true,
        title: "Action",
        toggle: false,
        align: "end",
    },
]);

const showEditModal = ref(false);
 
const showPostModal = () => {
    showAddModal.value = true;
};

const showPostEditModal = (permission) => {
    showEditModal.value = true;
    selectedPost.value = permission
}

</script>

<template>
    <AdminLayout>
        <div class="flex justify-between m-5">
            <h1>posts Index</h1>
            
            
             
            <Button @click="showPostModal"  v-if="hasPermission('create post')" color="primary" >
                Create
            </Button>

           
        </div>
       <!-- <div class="mx-5">
    
        
        <div class="relative overflow-x-auto p-3 shadow-sm sm:rounded-lg">
            <div class="flex items-center justify-end flex-column md:flex-row flex-wrap space-y-4 md:space-y-0 py-4 bg-white dark:bg-gray-900">
                
                <div class="flex">
                    
                    <form @submit.prevent="searchPosts" method="get">
                        <input type="text" v-model="searchQuery" id="table-search-users" class=" mx-2 pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for posts">
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
                <tbody>
                    <tr v-for="(post,index) in posts " :key="index" class="bg-white   dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                           {{post.id}}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                    {{post.title}}
                                </span>

                            </div>
                        </td>
                        <td class="px-6  py-4">
                            <Link  v-if="hasPermission('update post')" :href="route('posts.edit',post.id)"  class="font-medium mx-2 text-blue-600 dark:text-blue-500 hover:underline">edit</Link>
                            <button v-if="hasPermission('delete post')" @click="confirmDeletePost" class="font-medium text-red-500 dark:text-red-500 hover:underline">delete</button>

                             <Modal :show="showConfirmDeletePost" @close="closeModal">
                                    <div class="p-6">
                                        <h2 class="text-lg font-medium text-gray-900">
                                            Are you sure you want to delete your post?
                                        </h2>
                                      

                                        <div class="mt-4">
                                            <DangerButton  class="me-2" @click="deletePost(post.id)">Delete</DangerButton>
                                            <SecondaryButton @click="closeModal">Cancel</SecondaryButton>

                                        </div>
                                    </div>
                            </Modal>

                        </td>
                         
                    </tr>
                   
                </tbody>
            </table>
        </div>
       

       </div> -->
    
       <div class="mx-5">
            <div class="relative overflow-x-auto mb-3">
                <Table
                    :headers="headers"
                    :data="posts"
                    :checkable="false"
                    @onSelect="selectItems"
                    @onSearch="searchPosts"
                    @onChangeCount="changeCount"
                    :selectedCount="$page.props.rows"
                >
                    <template #column0="{ entity }">
                        {{ entity.id }}
                    </template>
                    <template #column1="{ entity }">
                        {{ entity.title }}
                    </template>

                    <template #column2="{ entity }">
                        <LightButtonIcon
                        v-if="hasPermission('delete post')"
                            icon="pi-trash"
                            size="sm"
                            @click="confirmDeletePost(entity)"
                            class="mr-1"
                            color="light"
                        />
                        <LightButtonIcon
                            v-if="hasPermission('update post')"
                            @click="showPostEditModal(entity)"
                            icon="pi-pencil"
                            size="sm"
                            class="mr-1"
                            color="light"
                        />
                    </template>
                </Table>
            </div>
        </div>
    </AdminLayout>

    <AddModal
        v-if="showAddModal"
        :visible="showAddModal"
         @onClose="showAddModal = false"
        />
    <EditModal
        :visible="showEditModal"
        :post="selectedPost"
        @onClose="showEditModal = false"
        v-if="showEditModal" 
    /> 
</template>

<style lang="css" scoped>

</style>