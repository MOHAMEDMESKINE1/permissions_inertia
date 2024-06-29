import { usePage } from "@inertiajs/vue3";
import { ref } from "vue";

export function usePermissions() {

    const hasRole = (name) => usePage().props.auth.user.roles.includes(name)
    const hasRoles = (names) => usePage().props.auth.user.roles.some(name => names.includes(name))
    const hasPermission = (name) => usePage().props.auth.user.permissions.includes(name)
    const authUser =usePage().props.auth.user
    
    return {
        hasRole,
        hasRoles,
        hasPermission,
        authUser
    }
}    