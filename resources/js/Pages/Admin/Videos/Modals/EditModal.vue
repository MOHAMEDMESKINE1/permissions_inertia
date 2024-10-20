<script setup>
import Toast from 'primevue/toast';
 import {
    Modal,
    Label,
    TextInput,
    Button,
    LabelValidation,
    FileInput,
    TextArea
 } from 'vue-component-cua'
 import {router, useForm} from '@inertiajs/vue3';
 import { useModal } from '@/utils/useUtils';
 import { useToast } from "primevue/usetoast";

const props = defineProps(['visible','video']);
const toast = useToast();

const editVideoForm =useForm({
   title: props.video.title,
   description: props.video.description,
   body: props.video.comments.map(comment => comment.body),
   video: '',
   _method: 'patch',
});

const editVideo = () => {
    editVideoForm.post(route('videos.update',props.video.id),{
        onSuccess : () => {
            onClose(true)
            toast.add({ severity: 'success', summary: 'Bien Modifié', detail: '', life: 3000 });
            editVideoForm.reset()

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
                            v-model="editVideoForm.title"
                            autofocus
                            autocomplete="title"
                        />

                        <LabelValidation v-if="editVideoForm.errors.title" class='mt-2' type='error'>
                            {{ editVideoForm . errors . title }}</LabelValidation>
                    </div>
                    <div class="mb-2">
                        <Label for="description">Description</Label>

                        <TextArea v-model="editVideoForm.description" placeholder='write description ...'/>

                        <LabelValidation v-if="editVideoForm.errors.description" class='mt-2' type='error'>
                            {{ editVideoForm . errors . description }}</LabelValidation>
                    </div>
                    <div>
                        <Label for="comment">comment</Label>

                       <TextArea
                            id="comment"
                            type="comment"
                            class="mt-1 p-2 border block w-full"
                            v-model="editVideoForm.body"
                            autofocus
                            autocomplete="comment"
                        /> 
                        

                        <LabelValidation v-if="editVideoForm.errors.body" class='mt-2' type='error'>
                            {{ editVideoForm . errors . body }}</LabelValidation>
                    </div>
                    <div>
                        <Label for="video">video</Label>

                        <FileInput   @input="editVideoForm.video=$event.target.files[0]" id='video-file' />
                         
                        <LabelValidation v-if="editVideoForm.errors.video" class='mt-2' type='error'>
                            {{ editVideoForm . errors . video }}</LabelValidation>
                    </div>

                   
                
            </div>

     
                <template #footer>
                    <div class="mt-4">
                        <Button  @click="editVideo" class="mx-2" color="success"  :class="{ 'opacity-25': editVideoForm.processing }" :disabled="editVideoForm.processing">
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