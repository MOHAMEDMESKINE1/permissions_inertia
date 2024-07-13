<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {  useForm, router } from "@inertiajs/vue3";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import ConfirmDialog from 'primevue/confirmdialog';
import Toast from 'primevue/toast';
import { ref } from "vue";
import AddModal from "@/Pages/Admin/Roles/Modals/AddModal.vue";
import EditModal from "@/Pages/Admin/Roles/Modals/EditModal.vue";
import {
    Table,
    DropDownButton,
    LightButtonIcon,
    Button,
    Pagination
} from "vue-component-cua";
const props = defineProps({
    roles: Object,
    permissions: Array,
});
const confirm = useConfirm();
const toast = useToast();
const form = useForm({});


const deleteRole = (id) => {
    form.delete(route("roles.destroy", id), {
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
                deleteRole(id)
            },
            reject: () => {
                toast.add({ severity: 'error', summary: 'Annulé', detail: '  ', life: 3000 });

            }
    });
    }

const searchRoles = (searchQuery) => {
    router.get(
        route("roles.index"),
        { search_role: searchQuery },
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
const selectedRole = ref(null);

const showRoleModal = () => {
    showAddModal.value = true;
};

const showRoleEditModal = (role) => {
    showEditModal.value = true;
    selectedRole.value = role
}

</script>

<template>
    <AdminLayout>
        <div class="flex justify-between m-5">
            <h1>Roles Index</h1>

            <Button class="justify-end" @click="showRoleModal"
                >Ajouter Role</Button
            >
        </div>
        <div class="mx-5">
            <div class="relative overflow-x-auto mb-3">
                <Table
                    :headers="headers"
                    :data="roles.data"
                    :checkable="false"
                    @onSelect="selectItems"
                    @onSearch="searchRoles"
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
                            @click="showRoleEditModal(entity)"
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
            :permissions="permissions"
            @onClose="showAddModal = false"
        />

        <EditModal
            :visible="showEditModal"
            :role="selectedRole"

            :permissions="permissions"
            @onClose="showEditModal = false"
            v-if="showEditModal" 
        />
        <!-- confirm & toast -->
            <ConfirmDialog/>
            <Toast/>
        <!-- confirm & toast -->

        <div class="flex justify-end me-5">
            <Pagination :links="roles.meta.links"/>
        </div>
    </AdminLayout>
</template>

<style lang="css" scoped></style>
