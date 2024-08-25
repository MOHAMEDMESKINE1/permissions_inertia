
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
    videos:Object,
   
})
const {hasPermission} = usePermissions()
const toast = useToast();
const confirm = useConfirm();

const form = useForm({})
const selectedVideo = ref('')

const showConfirmDeleteVideo  = ref(false)

const closeModal  = () => {
    showConfirmDeleteVideo.value = false;
}

const showAddModal =  ref(false)
 
const confirmDeleteVideo = (id) => {
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
                deleteVideo(id)
            },
            reject: () => {
                toast.add({ severity: 'error', summary: 'Annulé', detail: '  ', life: 3000 });

            }
    });
}


const deleteVideo = (id) => {
    form.delete(route('videos.destroy',id),{
        onSuccess : closeModal()
    })
    form.reset();
}

const searchVideos = (searchQuery) => {
      router.get(route('videos.index'), { search_video: searchQuery }, {
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
        title: "Description",
        toggle: false,
        align: "start",
    },
    {
        display: true,
        title: "Video",
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
 
const showVideoModal = () => {
    showAddModal.value = true;
};

const showVideoEditModal = (video) => {
    showEditModal.value = true;
    selectedVideo.value = video
}
const changeCount = (rows) => {
     router.post(route("set.rows"), { rows: rows.value });
}
</script>

<template>
    <AdminLayout>
        <div class="flex justify-between m-5">
            <h1>videos Index</h1>
            
            
             
            <Button @click="showVideoModal"  v-if="hasPermission('create video')" color="primary" >
                Create
            </Button>

           
        </div>
    
       <div class="mx-5">
            <div class="relative overflow-x-auto mb-3">
                <Table
                    :headers="headers"
                    :data="videos.data"
                    :checkable="false"
                    @onSelect="selectItems"
                    @onSearch="searchVideos"
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
                         <div v-for="comment in entity.comments" :key="comment.id">
                             <p>{{ comment.body ?? '-' }}</p>
                         </div>
                    </template>
                    <template #column3="{ entity }">
                        {{ entity.description }}
                    </template>
                    <template #column4="{ entity }">
                         
                        <iframe v-if="entity.video" class="rounded-md h-22 shadow-sm" :src="entity.video" frameborder="0"></iframe>
                        <p v-else>loading videos ...</p>
                        
                     </template>

                    <template #column5="{ entity }">
                        <LightButtonIcon
                        v-if="hasPermission('delete video')"
                            icon="pi-trash"
                            size="sm"
                            @click="confirmDeleteVideo(entity.id)"
                            class="mr-1"
                            color="light"
                        />
                        <LightButtonIcon
                            v-if="hasPermission('update video')"
                            @click="showVideoEditModal(entity)"
                            icon="pi-pencil"
                            size="sm"
                            class="mr-1"
                            color="light"
                        />
                    </template>
                </Table>
            </div>
            <div class="flex justify-end me-5">
                <Pagination :links="videos.meta.links" :type="Link"/>
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
        :video="selectedVideo"
        @onClose="showEditModal = false"
        v-if="showEditModal" 
    /> 
</template>

<style lang="css" scoped>

</style>