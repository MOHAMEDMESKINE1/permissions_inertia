<script setup>
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';

 import {
    Modal,
    Label,
    TextArea,
    TextInput,
    Select,
    Button,
    FileInput,
    LabelValidation,
   
 } from 'vue-component-cua'
 import {router, useForm, usePage} from '@inertiajs/vue3';
 import { useModal } from '@/utils/useUtils';
import { computed, onMounted, ref } from 'vue';

const props = defineProps(['visible','post']);
const toast = useToast();
const page = usePage();
const isLoading = ref(false)

const formPost =useForm({
    title:null,
    body:null,
    tags:[],
    image:null
   
});
const tags = computed(()=> page.props.tags)
const addPost = () => {
    
    formPost.post(route('posts.store'),{
        onSuccess : () => {
            onClose(true)
            toast.add({ severity: 'success', summary: ' Bien Ajouté', detail: '', life: 3000 });
            formPost.reset()

        },

        only:['tags'],
       

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
   <Modal  v-model:visible="modalVisible"  header='Ajouter un role' size="md">
            <div class="p-6">
                
                    <div>
                        <Label for="title">Title</Label>

                        <TextInput
                            id="title"
                            type="title"
                            class="mt-1 p-2 border block w-full"
                            v-model="formPost.title"
                            autofocus
                            autocomplete="title"
                        />

                        <LabelValidation v-if="formPost.errors.title" class='mt-2' type='error'>
                            {{ formPost . errors . title }}</LabelValidation>
                    </div>
                    <div>
                        <Label for="comment">comment</Label>

                        <TextArea
                            id="comment"
                            type="comment"
                            class="mt-1 p-2 border block w-full"
                            v-model="formPost.body"
                            autofocus
                            autocomplete="comment"
                        />

                        <LabelValidation v-if="formPost.errors.body" class='mt-2' type='error'>
                            {{ formPost . errors . body }}</LabelValidation>
                    </div>

                    <div>
                        <Label for="image">Image</Label>

                        <FileInput   @input="formPost.image=$event.target.files[0]" id='image-file' />

                        <LabelValidation v-if="formPost.errors.image" class='mt-2' type='error'>
                            {{ form . errors . image }}</LabelValidation>
                    </div>
                    <div v-if="!isLoading" class="mt-3">
                        <Select v-model='formPost.tags' 
                        :selectItem='formPost.tags'
                        :Items='tags' 
                        filter 
                        :options='tags' 
                        display='chip' 
                        optionValue="id" 
                        optionLabel='name'
                        placeholder='Sélectionner une tag' /> 

                        <LabelValidation v-if="formPost.errors.tags" class='mt-2' type='error'>
                            {{ formPost . errors . tags }}</LabelValidation>
                    </div>
                    <div v-else>
                        loading tags ...

                    </div>
                   
                
            </div>

     
                <template #footer>
                    <div class="mt-4">
                        <Button  @click="addPost" class="mx-2" color="success"  :class="{ 'opacity-25': formPost.processing }" :disabled="formPost.processing">
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