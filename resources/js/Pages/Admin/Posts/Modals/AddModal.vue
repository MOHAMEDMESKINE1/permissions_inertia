<script setup>
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';

 import {
    Modal,
    Label,
    TextInput,
    Button,
    LabelValidation,
   
    


 } from 'vue-component-cua'
 import {useForm} from '@inertiajs/vue3';
import {  ref, watch } from 'vue';

const props = defineProps(['visible']);
const form =useForm({
    title:'',
   
});
const addPost = () => {
    form.post(route('posts.store'),{
        onSuccess : () => {
            onClose(true)
        }
    });
};

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

                   
                
            </div>

     
                <template #footer>
                    <div class="mt-4">
                        <Button  @click="addPost" class="mx-2" color="success"  :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Enregistrer
                        </Button>
                        <Button   @click="onClose">Cancel</Button>
                    </div>
                </template>
           
        </Modal>
        <Toast />
 </template>
 

 
 <style lang="scss" scoped>
 
 </style>