<script setup>
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';

 import {
    Modal,
    Label,
    TextInput,
    Button,
    FileInput,
    LabelValidation,
   
 } from 'vue-component-cua'
 import {useForm} from '@inertiajs/vue3';
 import { useModal } from '@/utils/useUtils';

const props = defineProps(['visible','post']);
const toast = useToast();

const form =useForm({
    title:'',
    image:''
   
});
const addPost = () => {
    form.post(route('posts.store'),{
        onSuccess : () => {
            onClose(true)
            toast.add({ severity: 'success', summary: ' Bien Ajouté', detail: '', life: 3000 });
            form.reset()

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
   <Modal  v-model:visible="modalVisible"  header='Ajouter un role' size="md">
            <div class="p-6">
                
                    <div>
                        <Label for="title">Title</Label>

                        <TextInput
                            id="title"
                            type="title"
                            class="mt-1 p-2 border block w-full"
                            v-model="form.title"
                            autofocus
                            autocomplete="title"
                        />

                        <LabelValidation v-if="form.errors.title" class='mt-2' type='error'>
                            {{ form . errors . title }}</LabelValidation>
                    </div>

                    <div>
                        <Label for="image">Image</Label>

                        <FileInput   @input="form.image=$event.target.files[0]" id='image-file' />

                        <LabelValidation v-if="form.errors.image" class='mt-2' type='error'>
                            {{ form . errors . image }}</LabelValidation>
                    </div>

                   
                
            </div>

     
                <template #footer>
                    <div class="mt-4">
                        <Button  @click="addPost" class="mx-2" color="success"  :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
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