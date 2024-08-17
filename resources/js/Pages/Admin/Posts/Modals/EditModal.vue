<script setup>
import Toast from 'primevue/toast';
 import {
    Modal,
    Label,
    TextInput,
    Button,
    LabelValidation,
    FileInput
 } from 'vue-component-cua'
 import {router, useForm} from '@inertiajs/vue3';
 import { useModal } from '@/utils/useUtils';
 import { useToast } from "primevue/usetoast";

const props = defineProps(['visible','post']);
const toast = useToast();

const editPostForm =useForm({
   title: props.post.title,
   image: '',
   _method: 'patch',
});

const editPost = () => {
    editPostForm.post(route('posts.update',props.post.id),{
        onSuccess : () => {
            onClose(true)
            toast.add({ severity: 'success', summary: 'Bien Modifié', detail: '', life: 3000 });
            editPostForm.reset()

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
   <Modal  v-model:visible="modalVisible"  header='modifier post' size="md">
            <div class="p-6">
                
                    <div>
                        <Label for="title">Title</Label>

                        <TextInput
                            id="title"
                            type="title"
                            class="mt-1 p-2 border block w-full"
                            v-model="editPostForm.title"
                            autofocus
                            autocomplete="title"
                        />

                        <LabelValidation v-if="editPostForm.errors.title" class='mt-2' type='error'>
                            {{ editPostForm . errors . title }}</LabelValidation>
                    </div>
                    <div>
                        <Label for="image">Image</Label>

                        <FileInput   @input="editPostForm.image=$event.target.files[0]" id='image-file' />
                         
                        <LabelValidation v-if="editPostForm.errors.image" class='mt-2' type='error'>
                            {{ editPostForm . errors . image }}</LabelValidation>
                    </div>

                   
                
            </div>

     
                <template #footer>
                    <div class="mt-4">
                        <Button  @click="editPost" class="mx-2" color="success"  :class="{ 'opacity-25': editPostForm.processing }" :disabled="editPostForm.processing">
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