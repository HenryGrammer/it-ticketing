<template>
    <div>
        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit" @click="$emit('editUser', id)" v-if="requiredButton.hasEdit">
            <i class="bx bx-edit"></i>
        </button>

            <button type="button" class="btn btn-sm btn-danger" @click="$emit('deactivate', id)" v-if="requiredButton.hasDeactivate && status == null">
                <i class="bx bx-trash"></i>
            </button>

        <button type="button" class="btn btn-sm btn-success" @click="$emit('activate', id)" v-if="requiredButton.hasActivate && status !== null">
            <i class="bx bx-check"></i>
        </button>
    </div>
</template>

<script>
export default {
    props: {
        requiredButton: Object,
        id: Number,
        status: String
    }
}
</script>