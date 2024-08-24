
<script setup>
import AdminLayout from  '@/Layouts/AdminLayout.vue'
import AddModal from './Modals/AddModal.vue';
import EditModal from './Modals/EditModal.vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";

import { ref } from 'vue';
import {
Title,
Text,
Button,
CheckBox ,
Table,
Pagination,
LightButtonIcon ,
DropDownButton,
TextInput
}from 'vue-component-cua'
defineProps({
    tags:Object,
})
const confirm = useConfirm();
const toast = useToast();
const form = useForm({})

const showAddModal = ref(false);
const showEditModal = ref(false);
const selectedTag = ref(null);

const showUserModal = () => {
    showAddModal.value = true;
};


const showUserEditModal = (user) => {
    showEditModal.value = true;
    selectedTag.value = user
}
const showConfirmDeleteUser = ref(false)

const closeModal  = () => {
    showConfirmDeleteUser.value = false;
}

const headers = ref([
    {
        display : true,
        title:'Id',
        toggle:true,
        align: "start",

    },
    {
        display: true,
        title:'Nom',
        toggle:true,
        align: "start",

    },
    {
        display: true,
        title:'Action',
        toggle:true,
        align: "end",

    }
])


const searchTags = (searchQuery) => {
    router.get(
        route("tags.index"),
        { search_tag: searchQuery },
        {
            preserveState: true,
            replace: true,
        }
    );
};

const changeCount = (rows) => {
     router.post(route("set.rows"), { rows: rows.value });
}

const deleteUser = (id) => {
    form.delete(route('tags.destroy',id),{
        onSuccess : closeModal()
    })
    form.reset();
}
 
const confirmDeleteUser = (id) => {
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
                deleteUser(id)
            },
            reject: () => {
                toast.add({ severity: 'error', summary: 'Annulé', detail: '  ', life: 3000 });

            }
    });
}

</script>

<template>
    <AdminLayout>
        <div class="flex justify-between m-5">
            <Title type="h5">Permissions </Title>
            <Button color="primary" @click="showUserModal">
                Create
            </Button>    
        </div>
            <div class="relative overflow-x-auto p-3 shadow-sm sm:rounded-lg">
                <Table
                    :headers="headers"
                    :data="tags.data"
                    :checkable="false"
                    @onSelect="selectItems"
                    @onSearch="searchTags"
                    @onChangeCount="changeCount"
                    :selectedCount="$page.props.rows"
                >
                    <template #column0="{ entity }">
                        {{ entity.id }}
                    </template>
                    <template #column1="{ entity }">
                        {{ entity.name }}
                    </template>

                    <template #column2="{ entity }">
                        <LightButtonIcon
                            icon="pi-trash"
                            size="sm"
                            @click="confirmDeleteUser(entity)"
                            class="mr-1"
                            color="light"
                        />
                        <LightButtonIcon
                            @click="showUserEditModal(entity)"
                            icon="pi-pencil"
                            size="sm"
                            class="mr-1"
                            color="light"
                        />
                    </template>
                </Table>
            </div>
            <div class="flex justify-end me-5">
                <Pagination :links="tags.meta.links" :type="Link"/>
            </div>
    </AdminLayout>
    <AddModal
        v-if="showAddModal"
        :visible="showAddModal"
         @onClose="showAddModal = false"
        />
    <EditModal
    v-if="showEditModal" 
    :visible="showEditModal"
    :tag="selectedTag"
    @onClose="showEditModal = false"
   
/> 
</template>

<style lang="css" scoped>

</style>