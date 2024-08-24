<script setup>
import Toast from 'primevue/toast';
 import {
    Modal,
    Label,
    TextInput,
    Button,
    LabelValidation,
    TextArea,
    FileInput
 } from 'vue-component-cua'
 import {router, useForm} from '@inertiajs/vue3';
 import { useModal } from '@/utils/useUtils';
 import { useToast } from "primevue/usetoast";

const props = defineProps(['visible','tag']);
const toast = useToast();
 
const editTagForm =useForm({
   name: props.tag.name,
   _method: 'patch',
});
 console.log(editTagForm);
const editTag = () => {
    editTagForm.post(route('tags.update',props.tag.id),{
        onSuccess : () => {
            onClose(true)
            toast.add({ severity: 'success', summary: 'Bien Modifié', detail: '', life: 3000 });
            editTagForm.reset()

        }
    });
};


const emit = defineEmits(['onClose']);
const { modalVisible, onClose } = useModal(props.visible,emit);

const closeModal = () => {
  modalVisible.value = false;
  onClose();
};

</script>

 <template>
   <Modal  v-model:visible="modalVisible"  header='modifier tag' size="md">
            <div class="p-6">
                
                    <div>
                        <Label for="name">name</Label>

                        <TextInput
                            id="name"
                            type="name"
                            class="mt-1 p-2 border block w-full"
                            v-model="editTagForm.name"
                            autofocus
                            autocomplete="name"
                        />

                        <LabelValidation v-if="editTagForm.errors.name" class='mt-2' type='error'>
                            {{ editTagForm . errors . name }}</LabelValidation>
                    </div>
                    

                   
                
            </div>

     
                <template #footer>
                    <div class="mt-4">
                        <Button  @click="editTag" class="mx-2" color="success"  :class="{ 'opacity-25': editTagForm.processing }" :disabled="editTagForm.processing">
                            Enregistrer
                        </Button>
                        <Button   @click="closeModal">Cancel</Button>
                    </div>
                </template>
           
        </Modal>
        <Toast />
 </template>
 

 
 <style lang="scss" scoped>
 
 </style>