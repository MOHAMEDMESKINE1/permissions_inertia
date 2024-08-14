import {watch,defineEmits ,ref} from 'vue'

export function useModal(visible,emit) {

    const modalVisible = ref(visible);

    const onClose = (value) => {
        emit('onClose', value);
    };

    watch(() => visible, (newVal) => {
        modalVisible.value = newVal;
    });

    watch(modalVisible, (newVal) => {
        if (!newVal) {
            emit('onClose');
        }
    });

    return {
        modalVisible,
        onClose,
    };
}
