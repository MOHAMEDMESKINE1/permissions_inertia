<script setup>
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';

 import {
    Modal,
    Label,
    TextInput,
    Button,
    LabelValidation,
    Select  
 } from 'vue-component-cua'
 import {
      
     router,
        useForm,
        usePage
} from '@inertiajs/vue3';
import { computed, onMounted, ref, watch } from 'vue';
import { useModal } from '@/utils/useUtils';

const props = defineProps(['visible','role']);
const page = usePage();
const isLoading = ref(false)
const permissions = computed(()=> page.props.permissions)
const toast = useToast();

// form  to edit role  data
const editRoleForm = useForm({
    name:props.role.name,
    permissions:props.role.permissions
})
const editRole = () => {
    editRoleForm.put(route('roles.update',props.role.id),{
        onSuccess : () => {
            onClose(true);
            toast.add({ severity: 'success', summary: ' Bien Modifié', detail: '', life: 3000 });
            editRoleForm.reset()
        },
        only:[
            'permissions'
        ]
    })
}


const emit = defineEmits(['onClose']);

const { modalVisible, onClose } = useModal(props.visible,emit);

const closeModal = () => {
  modalVisible.value = false;
  onClose();
};


onMounted(()=>{
    router.reload({
        only:['permissions'],
        onBefore : () => isLoading.value = true,
        onFinish : () => isLoading.value = false,
    })
 
})
</script>

 <template>
   <Modal  v-model:visible="modalVisible"  header='Modifier un role' size="md">
            <div class="p-6">
                <div class='my-3'>
                    <Label for='name'>Name</Label>
                    <TextInput v-model="editRoleForm.name" id='name' class='mt-1 block w-full' placeholder='name ...' />
                    <LabelValidation v-if="editRoleForm.errors.name" class='mt-2' type='error'>
                        {{ editRoleForm . errors . name }}</LabelValidation>
                </div>
                <div class="my-3" v-if="!isLoading">
                    
                    <Select v-model='editRoleForm.permissions' 
                   
                    :selectItem='editRoleForm.permissions'
                    :Items='permissions' 
                    filter 
                    :options='permissions' 
                    display='chip' 
                    optionLabel='name'
                    ariaLabel="name"  
                    placeholder='Sélectionner une permission' /> 

                    <LabelValidation v-if="editRoleForm.errors.name" class='mt-2' type='error'>
                        {{ editRoleForm . errors . name }}</LabelValidation>
                </div>
                <div v-else>
                    loading permissions ...
                </div>
            </div>

     
                <template #footer>
                    <div class="mt-4">
                        <Button color="success" class="me-2" @click="editRole" :disabled="editRoleForm.processing">Enregistrer</Button>
                        <Button   @click="closeModal">Cancel</Button>
                    </div>
                </template>
        </Modal>
        <Toast />
 </template>
 

 
 <style lang="scss" scoped>
 
 </style>