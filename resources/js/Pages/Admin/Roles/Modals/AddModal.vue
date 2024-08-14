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
        Head,
        Link,
        router,
        useForm,
        usePage
} from '@inertiajs/vue3';
import { computed, onMounted,defineEmits,defineProps, ref, watch } from 'vue';
import { useModal } from '@/utils/useUtils';
 
const props = defineProps(['visible']);
const emit = defineEmits(['onClose']);
const { modalVisible, onClose } = useModal(props.visible,emit);

const closeModal = () => {
  modalVisible.value = false;
  onClose();
};



const page = usePage();
const isLoading = ref(false)
const permissions = computed(()=> page.props.permissions)
const toast = useToast();
const addRoleForm = useForm({
    name:'',
    permissions:[]
})

const addRole = () => {
    addRoleForm.post(route('roles.store'),{
        onSuccess : () => {
            onClose(true)
            toast.add({ severity: 'success', summary: ' Bien Ajouté', detail: '', life: 3000 });
            addRoleForm.reset()
        },
        only : ['permissions']
    })
}

onMounted(()=>{
    router.reload({
        only:['permissions'],
        onBefore : ()=> isLoading.value = true,
        onFinish : () => isLoading.value = false
    })
})
</script>

 <template>
   <Modal  v-model:visible="modalVisible"  header='Ajouter un role' size="md">
            <div class="p-6">
                <h1>{{ message }}</h1>
                <div class='my-3'>
                    <Label for='name'>Name</Label>
                    <TextInput v-model="addRoleForm.name" id='name' class='mt-1 block w-full' placeholder='name ...' />
                    <LabelValidation v-if="addRoleForm.errors.name" class='mt-2' type='error'>
                        {{ addRoleForm . errors . name }}</LabelValidation>
                </div>
                <div v-if="!isLoading" class="my-3">
                    
                    <Select v-model='addRoleForm.permissions' 
                    optionValue="id" 
                    :selectItem='addRoleForm.permissions'
                    :Items='permissions' 
                    filter 
                    :options='permissions' 
                    display='chip' 
                    optionLabel='name'
                    placeholder='Sélectionner une permission' /> 

                    <LabelValidation v-if="addRoleForm.errors.name" class='mt-2' type='error'>
                        {{ addRoleForm . errors . name }}</LabelValidation>
                </div>
                 <div v-else>
                    <p>loading permissions ...</p>

                 </div>
            </div>

     
                <template #footer>
                    <div class="mt-4">
                        <Button color="success" class="me-2" @click="addRole" :disabled="addRoleForm.processing">Enregistrer</Button>
                        <Button   @click="closeModal">Cancel</Button>
                    </div>
                </template>
        </Modal>
        <Toast />
 </template>
 

 
 <style lang="scss" scoped>
 
 </style>