<template>
    <div>
        <vue-good-table
            :columns="columns"
            :rows="rows"
            :pagination-options="{
                enabled: true,
                mode:'records',
                perPage:15
            }"
            :search-options="{
                enabled: true,
                placeholder: 'Search this table'
            }"
        >
            
        </vue-good-table>
    </div>
</template>

<script>
export default {
    props: {
        columns: Array,
        rows: Array
    }
}
</script>