
<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {  useForm, router } from "@inertiajs/vue3";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import ConfirmDialog from 'primevue/confirmdialog';
import Toast from 'primevue/toast';
import { ref } from "vue";
import AddModal from "@/Pages/Admin/Permissions/Modals/AddModal.vue";
import EditModal from "@/Pages/Admin/Permissions/Modals/EditModal.vue";
import {
    Table,
    DropDownButton,
    LightButtonIcon,
    Button,
    Pagination
} from "vue-component-cua";
const props = defineProps({
    
    permissions: Array,
});
const confirm = useConfirm();
const toast = useToast();
const form = useForm({});


const deletePermission = (id) => {
    form.delete(route("permissions.destroy", id), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'bien Surpprimé', detail: ' ', life: 3000 });
        },
       
    });
  
};
const confirmDelete = (id) => {
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
                deletePermission(id)
            },
            reject: () => {
                toast.add({ severity: 'error', summary: 'Annulé', detail: '  ', life: 3000 });

            }
    });
    }

const searchPermissions = (searchQuery) => {
    router.get(
        route("permissions.index"),
        { search_permission: searchQuery },
        {
            preserveState: true,
            replace: true,
        }
    );
};
const changeCount = (rows) => {
     router.post(route("set.rows"), { rows: rows.value });
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
        title: "Name",
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

const showAddModal = ref(false);
const showEditModal = ref(false);
const selectedPermission = ref(null);

const showPermissionModal = () => {
    showAddModal.value = true;
};

const showPermissionEditModal = (permission) => {
    showEditModal.value = true;
    selectedPermission.value = permission
}

</script>
<template>
    <AdminLayout>
        <div class="flex justify-between m-5">
            <h1>Permission Index</h1>

            <Button class="justify-end" @click="showPermissionModal">Ajouter Permission</Button>
        </div>
        <div class="mx-5">
            <div class="relative overflow-x-auto mb-3">
                <Table
                    :headers="headers"
                    :data="permissions.data"
                    :checkable="false"
                    @onSelect="selectItems"
                    @onSearch="searchPermissions"
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
                            @click="confirmDelete(entity)"
                            class="mr-1"
                            color="light"
                        />
                        <LightButtonIcon
                            @click="showPermissionEditModal(entity)"
                            icon="pi-pencil"
                            size="sm"
                            class="mr-1"
                            color="light"
                        />
                    </template>
                </Table>
            </div>
        </div>
        <AddModal
            :visible="showAddModal"
            @onClose="showAddModal = false"
        />

        <EditModal
            :visible="showEditModal"
            :permission="selectedPermission"
            @onClose="showEditModal = false"
            v-if="showEditModal" 
        />
        <div class="flex justify-end me-5">
            <Pagination :links="permissions.meta.links" :item="dev"/>
        </div>
    </AdminLayout>
</template>

<style lang="css" scoped>

</style>