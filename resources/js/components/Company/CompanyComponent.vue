<template>
    <div class="row">
        <NavbarComponent title="Company"/>

        <div class="col-lg-12">
            <div class="col-lg-12">
            <div class="row mt-4">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"><span><i class="bx bx-user"></i></span> Total Company</h5>
                        </div>
                        <div class="card-body">
                            <h3>0</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 mt-5">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Company
                                <button class="btn btn-success" @click="handleCreate()" type="button" data-bs-toggle="modal" data-bs-target="#new">
                                    <i class="bx bx-plus"></i>
                                    Add Company</button>

                            </h5>
                        </div>
                        <div class="card-body">
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
                                <template slot="table-row" slot-scope="props">
                                    <template v-if="props.column.field == 'action'">
                                        <!-- <ActionButtonComponent @activate="activate(props.row.id)" @deactivate="deactivate(props.row.id)" @editUser="handleEditUser(props.row)" :status="props.row.status" :requiredButton="requiredButton"/> -->
                                    </template>

                                    <div v-else-if="props.column.field == 'status'">
                                        <span class="badge rounded-pill bg-success" v-if="props.row.status == null">
                                            Active
                                        </span>
                                        <span class="badge rounded-pill bg-danger" v-else>
                                            Inactive
                                        </span>
                                    </div>
                                </template>
                            </vue-good-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div>
    </div>
</template>

<script>
import NavbarComponent from '../NavbarComponent.vue';

export default {
    data(){
        return {
            columns:[],
            rows:[]
        }
    },
    components: {
        NavbarComponent
    }
}
</script>