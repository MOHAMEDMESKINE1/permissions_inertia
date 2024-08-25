<script setup>
import Toast from 'primevue/toast';
 import {
    Modal,
    Label,
    TextInput,
    Button,
    LabelValidation,
    TextArea,
    Select,
    FileInput
 } from 'vue-component-cua'
 import {router, useForm, usePage} from '@inertiajs/vue3';
 import { useModal } from '@/utils/useUtils';
 import { useToast } from "primevue/usetoast";
import { computed, onMounted, ref } from 'vue';

const props = defineProps(['visible','post']);
const toast = useToast();
const page = usePage();
const tags = computed(()=> page.props.tags)

const isLoading = ref(false);
const editPostForm =useForm({
   title: props.post.title,
   body: props.post.comments.map(comment => comment.body),
   tags: props.post.tags,
   image: '',
   _method: 'patch',
});
 const editPost = () => {
    editPostForm.post(route('posts.update',props.post.id),{
        onSuccess : () => {
            onClose(true)
            toast.add({ severity: 'success', summary: 'Bien Modifié', detail: '', life: 3000 });
            editPostForm.reset()

        },
        only:['tags']
    });
};


const emit = defineEmits(['onClose']);
const { modalVisible, onClose } = useModal(props.visible,emit);

const closeModal = () => {
  modalVisible.value = false;
  onClose();
};
onMounted(()=>{
    router.reload({
        only:['tags'],
        onBefore : ()=> isLoading.value = true,
        onFinish : () => isLoading.value = false

    })
})
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
                        <Label for="comment">comment</Label>

                       <TextArea
                            id="comment"
                            type="comment"
                            class="mt-1 p-2 border block w-full"
                            v-model="editPostForm.body"
                            autofocus
                            autocomplete="comment"
                        /> 
                        

                        <LabelValidation v-if="editPostForm.errors.body" class='mt-2' type='error'>
                            {{ editPostForm . errors . body }}</LabelValidation>
                    </div>
                    <div>
                        <Label for="image">Image</Label>

                        <FileInput   @input="editPostForm.image=$event.target.files[0]" id='image-file' />
                         
                        <LabelValidation v-if="editPostForm.errors.image" class='mt-2' type='error'>
                            {{ editPostForm . errors . image }}</LabelValidation>
                    </div>
                    <div v-if="!isLoading" class="mt-3">
                        <Select 
                        v-model='editPostForm.tags' 
                        :selectItem='editPostForm.tags'
                        :Items='tags' 
                        :options='tags'
                        filter 
                        display='chip' 
                        optionLabel='name'
                         
                        placeholder='Sélectionner une tag' /> 

                        <LabelValidation v-if="editPostForm.errors.tags" class='mt-2' type='error'>
                            {{ editPostForm . errors . tags }}</LabelValidation>
                    </div>
                    <div v-else>
                        loading tags ...

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