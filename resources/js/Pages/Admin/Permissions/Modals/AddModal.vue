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
        useForm
} from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps(['visible']);

const toast = useToast();
const addPermissionForm = useForm({
    name:'',
   
})

const addPermission = () => {
    addPermissionForm.post(route('permissions.store'),{
        onSuccess : () => {
            onClose(true)
            toast.add({ severity: 'success', summary: ' Bien Ajouté', detail: '', life: 3000 });
            addPermissionForm.reset()
        }
    })
}


//  onclose Modal
const emit = defineEmits(['onClose']);

const onClose = (value) => emit("onClose", value);

const modalVisible = ref(props.visible)
watch(() => props.visible, (newVal) => {
    modalVisible.value = newVal;
});

watch(modalVisible, (newVal) => {
    if (!newVal) {
        emit('onClose');
    }
});

</script>

 <template>
   <Modal  v-model:visible="modalVisible"  header='Ajouter une permission' size="md">
            <div class="p-6">
                <div class='my-3'>
                    <Label for='name'>Name</Label>
                    <TextInput v-model="addPermissionForm.name" id='name' class='mt-1 block w-full' placeholder='name ...' />
                    <LabelValidation v-if="addPermissionForm.errors.name" class='mt-2' type='error'>
                        {{ addPermissionForm . errors . name }}</LabelValidation>
                </div>
               
            </div>

     
                <template #footer>
                    <div class="mt-4">
                        <Button color="success" class="me-2" @click="addPermission" :disabled="addPermissionForm.processing">Enregistrer</Button>
                        <Button   @click="onClose">Cancel</Button>
                    </div>
                </template>
        </Modal>
        <Toast />
 </template>
 

 
 <style lang="scss" scoped>
 
 </style>