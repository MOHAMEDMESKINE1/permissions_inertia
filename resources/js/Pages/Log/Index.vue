<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue';
import {Table,Title} from 'vue-component-cua'
  defineProps({
    activities : {
        type:Object
    }
  })
  const headers = ref([
    {
        display: true,
        title: "ID",
        toggle: false,
        align: "start",
    },
    {
        display: true,
        title: "description",
        toggle: false,
        align: "start",
    },
    {
        display: true,
        title: "Performed On",
        toggle: false,
        align: "start",
    },
    {
        display: true,
        title: "Causer",
        toggle: false,
        align: "start",
    },
   
    {
        display: true,
        title: "At",
        toggle: false,
        align: "start",
    },
   
]);
</script>

  <template>
    <AdminLayout>
        <Title type="h5">Log activities</Title>
        <div class="mx-5">
            <div class="relative overflow-x-auto mb-3">
                <Table
                    :headers="headers"
                    :data="activities"
                    :checkable="false"
                    @onSelect="selectItems"
                    @onSearch="searchRoles"
                    @onChangeCount="changeCount"
                    :selectedCount="$page.props.rows"
                >
                    <template #column0="{ entity }">
                        {{ entity.id }}
                    </template>
                    <template #column1="{ entity }">
                        {{ entity.description }}
                    </template>
                    <template #column2="{ entity }">
                        {{ entity.performed_on }}
                    </template>
                    <template #column3="{ entity }">
                        {{ entity.causer }}
                    </template>
                    <template #column4="{ entity }">
                        {{ entity.at }}
                    </template>
                    
                </Table>
            </div>
        </div>
    </AdminLayout>
  </template>
  

  
  <style lang="scss" scoped>
  
  </style>