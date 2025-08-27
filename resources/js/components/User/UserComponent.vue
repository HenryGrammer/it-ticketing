<template>
    <div class="row">
        <Navbar title="User Management"/>
        
        <div class="col-lg-12">
            <div class="row mt-4">
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
                                <button class="btn btn-success" @click="handleCreate()" type="button" data-bs-toggle="modal" data-bs-target="#new">
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
                                    <template v-if="props.column.field == 'action'">
                                        <ActionButtonComponent @activate="activate(props.row.id)" @deactivate="deactivate(props.row.id)" @editUser="handleEditUser(props.row)" :status="props.row.status" :requiredButton="requiredButton"/>
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

        <div class="modal" id="new">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">Add new user</h6>
                    </div>
                    <form method="post" @submit.prevent="createUser()">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    Name :
                                    <input type="text" v-model="userForm.name" class="form-control" required>
                                </div>
                                <div class="col-md-12">
                                    Email :
                                    <input type="email" v-model="userForm.email" class="form-control" required>
                                </div>
                                <div class="col-md-12">
                                    Department :
                                    <v-select label="name" v-model="userForm.department" :reduce="departments => departments.id" :options="departments"></v-select>
                                </div>
                                <div class="col-md-12">
                                    Company :
                                    <v-select label="name" v-model="userForm.company" :reduce="company => company.id" :options="company"></v-select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal" id="edit">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">Edit user</h6>
                    </div>
                    <form method="post" @submit.prevent="handleUpdate()">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    Name :
                                    <input v-model="userForm.name" type="text" class="form-control" required>
                                </div>
                                <div class="col-md-12">
                                    Email :
                                    <input v-model="userForm.email" type="email" class="form-control" required>
                                </div>
                                <div class="col-md-12">
                                    Department :
                                    <v-select v-model="userForm.department" label="name" :reduce="departments => departments.id" :options="departments"></v-select>
                                </div>
                                <div class="col-md-12">
                                    Company :
                                    <v-select v-model="userForm.company" label="name" :reduce="company => company.id" :options="company"></v-select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import api from "../../api"
import Navbar from "../NavbarComponent.vue";
import TableComponent from "../TableComponent.vue";
import ActionButtonComponent from "../ActionButtonComponent.vue";
export default {
    data() {
        return {
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
            userForm: {
                name: '',
                email: '',
                company: null,
                department: null
            },
            rows: [],
            departments:[],
            company:[],
            userId: 0,
            requiredButton: {
                hasEdit: true,
                hasDeactivate: true,
                hasActivate: true
            }
        };
    },
    components: {
        Navbar,
        TableComponent,
        ActionButtonComponent
    },
    mounted() {
        this.getUsers()
    },
    methods: {
        async getUsers() {
            try {
                const response = await api.get(`users/list`)
                
                this.rows = response.data.data
                this.departments = response.data.departments
                this.company = response.data.companies
                
            } catch (error) {
                this.$toast.open({
                    message:'Failed to fetch data',
                    type:'error',
                    position:'bottom-right'
                })
                console.error(error);
            }
            
        },
        async createUser() {
            try {
                const response = await api.post('users/store',this.userForm)
                
                this.getUsers()

                this.$toast.open({
                    message: response.data.message,
                    type:'success',
                    position:'bottom-right'
                })

                $('#new').modal('hide')
            } catch (error) {
                $('#new').modal('hide')

                this.$toast.open({
                    message: error.data.error,
                    type:'error',
                    position:'bottom-right'
                })
            }
        },
        async handleEditUser(row) {
            try {
                const response = await api.get(`users/edit/${row.id}`)
            
                this.userForm.name = response.data.data.name
                this.userForm.email = response.data.data.email
                this.userForm.department = response.data.data.department_id
                this.userForm.company = response.data.data.company_id
                this.userId = response.data.data.id
                
            } catch (error) {
                console.error(error);
            }
        },
        async handleUpdate() {
            try {
                const response = await api.post(`users/update/${this.userId}`, this.userForm)

                $('#edit').modal('hide')

                this.getUsers()
                
                this.$toast.open({
                    message: response.data.message,
                    type:'success',
                    position:'bottom-right'
                })
            } catch (error) {
                console.error(error);
                this.$toast.open({
                    message: error.message,
                    type:'error',
                    position:'bottom-right'
                })
            }            
        },
        handleCreate() {
            this.userForm.name = null
            this.userForm.email = null
            this.userForm.department = null
            this.userForm.company = null
            this.userId = null
        },
        async deactivate(id) {
            try {
                const response = await api.post(`users/deactivate/${id}`)
                
                this.getUsers()
                
                this.$toast.open({
                    message: response.data.message,
                    type:'success',
                    position:'bottom-right'
                })
            } catch (error) {
                console.error(error);
                this.$toast.open({
                    message: error.message,
                    type:'error',
                    position:'bottom-right'
                })
            }
        },
        async activate(id) {
            try {
                const response = await api.post(`users/activate/${id}`)
                
                this.getUsers()
                
                this.$toast.open({
                    message: response.data.message,
                    type:'success',
                    position:'bottom-right'
                })
            } catch (error) {
                console.error(error);
                this.$toast.open({
                    message: error.message,
                    type:'error',
                    position:'bottom-right'
                })
            }
        }
    }
};
</script>
