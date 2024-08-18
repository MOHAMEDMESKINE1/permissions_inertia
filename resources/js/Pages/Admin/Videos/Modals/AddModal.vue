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
    TextArea
   
 } from 'vue-component-cua'
 import { useForm} from '@inertiajs/vue3';
 import { useModal } from '@/utils/useUtils';

const props = defineProps(['visible','video']);
const toast = useToast();

const addFormVideo =useForm({
    title:'',
    description:'',
    video:''
   
});
const addVideo = () => {
    addFormVideo.post(route('videos.store'),{
        onSuccess : () => {
            onClose(true)
            toast.add({ severity: 'success', summary: ' Bien Ajouté', detail: '', life: 3000 });
            addFormVideo.reset()

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
   <Modal  v-model:visible="modalVisible"  header='Ajouter un video' size="md">
            <div class="p-6">
                
                    <div class="mb-2">
                        <Label for="title">Title</Label>

                        <TextInput
                            id="title"
                            type="title"
                            class="mt-1 p-2 border block w-full"
                            v-model="addFormVideo.title"
                            autofocus
                            autocomplete="title"
                        />

                        <LabelValidation v-if="addFormVideo.errors.title" class='mt-2' type='error'>
                            {{ addFormVideo . errors . title }}</LabelValidation>
                    </div>
                    <div class="mb-2">
                        <Label for="description">Description</Label>

                        <TextArea v-model="addFormVideo.description" placeholder='write description ...'/>

                        <LabelValidation v-if="addFormVideo.errors.description" class='mt-2' type='error'>
                            {{ addFormVideo . errors . description }}</LabelValidation>
                    </div>

                    <div class="mb-2">
                        <Label for="video">Video</Label>

                        <FileInput   @input="addFormVideo.video=$event.target.files[0] " id='video-file' />

                        <LabelValidation v-if="addFormVideo.errors.video" class='mt-2' type='error'>
                            {{ addFormVideo . errors . video }}</LabelValidation>
                    </div>

                   
                
            </div>

     
                <template #footer>
                    <div class="mt-4">
                        <Button  @click="addVideo" class="mx-2" color="success"  :class="{ 'opacity-25': addFormVideo.processing }" :disabled="addFormVideo.processing">
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