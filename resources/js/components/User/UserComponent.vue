<template>
    <div class="row">
        <div class="col-lg-12">
            <h4 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light"><b>User Management</b></span>
            </h4>

            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"><span><i class="bx bx-user"></i></span> Total Users</h5>
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
                            <h5 class="card-title">User Management
                                <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#new">
                                    <i class="bx bx-plus"></i>
                                    Add User</button>

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
                                    <div v-if="props.column.field == 'status'">
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

        <div class="modal" id="new">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">Add new user</h6>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import api from "../../api"

export default {
    data() {
        return {
            serverParams: {
                sort: [

                ]
            },
            columns: [
                {
                    label:'Action',
                    field: 'action'
                },
                {
                    label:'Name',
                    field:'name'
                },
                {
                    label:'Email',
                    field:'email'
                },
                {
                    label:'Department',
                    field:'department.name'
                },
                {
                    label:'Status',
                    field:'status'
                },
            ],
            rows: [],
        };
    },
    mounted() {
        this.getUsers()
    },
    methods: {
        async getUsers()
        {
            const response = await api.get(`users/list`)
            // console.log(response.data.data);
            
            this.rows = response.data.data
        }
    }
};
</script>
