
<script setup>
import AdminLayout from  '@/Layouts/AdminLayout.vue'
import { Link,useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { usePermissions } from '@/composables/permissions';
import {
    Table,
    LightButtonIcon,
    Button,
    Pagination,
    Avatar
} from 'vue-component-cua'
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
        title: "Comment",
        toggle: false,
        align: "start",
    },
    {
        display: true,
        title: "Image",
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

const showPostEditModal = (post) => {
    showEditModal.value = true;
    selectedPost.value = post
}
const changeCount = (rows) => {
     router.post(route("set.rows"), { rows: rows.value });
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
    
       <div class="mx-5">
            <div class="relative overflow-x-auto mb-3">
                <Table
                    :headers="headers"
                    :data="posts.data"
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
                        <div v-for="comment in entity?.comments" :key="comment.id">
                         
                         <span>{{ comment.body ?? '-'}}</span>
                     

                    </div>
                    </template>
                    <template #column3="{ entity }">
                        <Avatar v-if="entity.post_image" type='img' :src='entity.post_image' size='md' alt='avatar' rounded='md' />
                        <Avatar v-else   :text="entity.title" size='md' alt='avatar' rounded='md' />
                        
                     </template>

                    <template #column4="{ entity }">
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
            <div class="flex justify-end me-5">
                <Pagination :links="posts.meta.links" :type="Link"/>
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