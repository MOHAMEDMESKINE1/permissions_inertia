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
        router,
        useForm,
        usePage
} from '@inertiajs/vue3';
import { computed, onMounted,defineEmits,defineProps, ref, watch } from 'vue';
import { useModal } from '@/utils/useUtils';
 
const props = defineProps(['visible','user']);

const emit = defineEmits(['onClose']);
const { modalVisible, onClose } = useModal(props.visible,emit);

const closeModal = () => {
  modalVisible.value = false;
  onClose();
};



const page = usePage();
const isLoading = ref(false)
const roles = computed(()=> page.props.roles)
const permissions = computed(()=> page.props.permissions)



const toast = useToast();
const editUserForm = useForm({
    name: props.user.name,
    email: props.user.email,
    password: props.user.password,
    password_confirmation: '',
    roles:props.user.roles,
    permissions:props.user.permissions,
});
const editUser = () => {
    editUserForm.put(route('users.update',props.user.id),{
        onSuccess : () => {
            onClose(true)
            toast.add({ severity: 'success', summary: ' Bien Modifié', detail: '', life: 3000 });
            editUserForm.reset()
        },
        onError : ()=>{
            onClose(false)
        },
        only : ['permissions','roles']
    })
}

onMounted(()=>{
    router.reload({
        only:['permissions','roles'],
        onBefore : ()=> isLoading.value = true,
        onFinish : () => isLoading.value = false
    })
})
</script>

 <template>
   <Modal  v-model:visible="modalVisible"  header='Ajouter un role' size="md">
            <div class="p-6">
                <h1>{{ message }}</h1>
                <div class='my-3'>
                    <Label for='name'>Name</Label>
                    <TextInput v-model="editUserForm.name" id='name' class='mt-1 block w-full' placeholder='name ...' />
                    <LabelValidation v-if="editUserForm.errors.name" class='mt-2' type='error'>
                        {{ editUserForm . errors . name }}</LabelValidation>
                </div>
                

                <div class="mt-4">
                    <Label for='email'>Email</Label>
                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="editUserForm.email"
                        required
                        autocomplete="email"
                    />

                    <LabelValidation v-if="editUserForm.errors.email" class='mt-2' type='error'>
                        {{ editUserForm . errors . email }}</LabelValidation>
                </div>

                <div class="mt-4">
                    <Label for='password'>Password</Label>


                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="editUserForm.password"
                        required
                        autocomplete="new-password"
                    />

                    <LabelValidation v-if="editUserForm.errors.password" class='mt-2' type='error'>
                        {{ editUserForm . errors . password }}</LabelValidation>
                </div>

                <div class="mt-4">
                     <Label for='password_confirmation'>password_confirmation</Label>
                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="editUserForm.password_confirmation"
                        required
                        autocomplete="new-password"
                    />

                    <LabelValidation v-if="editUserForm.errors.password_confirmation" class='mt-2' type='error'>
                        {{ editUserForm . errors . password_confirmation }}</LabelValidation>
                </div>
                <div   class="my-3">
                    <Label for='roles'>Roles</Label>
                    <Select :isLoading="isLoading" v-model='editUserForm.roles' 
                    
                    :selectItem='editUserForm.roles'
                    :Items='roles' 
                    
                    filter 
                    :options='roles' 
                    display='chip' 
                    ariaLabel="name"
                    optionLabel='name'
                    placeholder='Sélectionner un role' /> 

                    <LabelValidation v-if="editUserForm.errors.name" class='mt-2' type='error'>
                        {{ editUserForm . errors . name }}</LabelValidation>
                </div>

                <div   class="my-3">
                    <Label for='permissions'>Permissions</Label>

                    <Select :isLoading="isLoading" v-model='editUserForm.permissions' 
                     
                    :selectItem='editUserForm.permissions'
                    :Items='permissions' 
                    filter 
                    :options='permissions' 
                    display='chip' 
                    optionLabel='name'
                     
                    ariaLabel="name"  
                    placeholder='Sélectionner une permission' /> 

                    <LabelValidation v-if="editUserForm.errors.name" class='mt-2' type='error'>
                        {{ editUserForm . errors . name }}</LabelValidation>
                </div>
                

               
            </div>

     
                <template #footer>
                    <div class="mt-4">
                        <Button color="success" class="me-2" @click="editUser" :disabled="editUserForm.processing">Enregistrer</Button>
                        <Button   @click="closeModal">Cancel</Button>
                    </div>
                </template>
        </Modal>
        <Toast />
 </template>
 

 
 <style lang="scss" scoped>
 
 </style>