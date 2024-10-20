<script setup>
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';

 import {
    Modal,
    Label,
    TextArea,
    TextInput,
    Button,
    FileInput,
    LabelValidation,
   
 } from 'vue-component-cua'
 import {useForm} from '@inertiajs/vue3';
 import { useModal } from '@/utils/useUtils';

const props = defineProps(['visible']);
const toast = useToast();

const addFormTag =useForm({
    name:'',
    
   
});
const addTag = () => {
    addFormTag.post(route('tags.store'),{
        onSuccess : () => {
            onClose(true)
            toast.add({ severity: 'success', summary: ' Bien Ajouté', detail: '', life: 3000 });
            addFormTag.reset()

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
   <Modal  v-model:visible="modalVisible"  header='Ajouter un tag' size="md">
            <div class="p-6">
                
                    <div>
                        <Label for="name">name</Label>

                        <TextInput
                            id="name"
                            type="name"
                            class="mt-1 p-2 border block w-full"
                            v-model="addFormTag.name"
                            autofocus
                            autocomplete="name"
                        />

                        <LabelValidation v-if="addFormTag.errors.name" class='mt-2' type='error'>
                            {{ addFormTag . errors . name }}</LabelValidation>
                    </div>
 
            </div>

     
                <template #footer>
                    <div class="mt-4">
                        <Button  @click="addTag" class="mx-2" color="success"  :class="{ 'opacity-25': addFormTag.processing }" :disabled="addFormTag.processing">
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