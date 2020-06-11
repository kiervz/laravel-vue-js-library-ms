<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <div class="d-flex align-items-center">
                                <h3 class="card-title">Users</h3>
                            </div>
                            <button class="btn btn-sm btn-primary show-book-modal" @click="addModal" data-title="ADD">
                                Register User <i class="fas fa-user-plus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-sm table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Type</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Username</th>
                                    <th>Birthday</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in users" :key="item.id">
                                    <td>{{ item.id }}</td>
                                    <td>{{ item.roles[0].name }}</td>
                                    <td>{{ item.firstname + ' ' + item.lastname }}</td>
                                    <td>{{ item.gender }}</td>
                                    <td>{{ item.username }}</td>
                                    <td>{{ item.birthday }}</td>
                                    <td>
                                        <i class="fas fa-edit" @click="editModal(item)"></i>
                                        |
                                        <i class="fas fa-trash" @click="deleteUser(item.id)"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <div class="float-right">

                        </div>
                    </div>
                </div>
            </div>
        </div>

         <!-- Modal for adding user -->
        <div class="modal fade" id="add_user" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form @submit.prevent="editMode ? updateUser() : addUser()">
                        <!-- Modal Header -->
                        <div class="modal-header bg-dark text-white">
                            <h5 v-show="!editMode" class="modal-title">Register User</h5>
                            <h5 v-show="editMode" class="modal-title">Update User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span class="text-white" aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- Modal Content -->
                        <div class="modal-body text-muted">
                            <div class="row">
                                <!-- first row -->
                                <div class="col-6">
                                    <div v-for="(item, $index) in item_col_1" :key="$index" class="form-group">
                                        <div v-if="item.type == 'dropdown'">
                                            <div class="form-group">
                                                <label :for="item.name">{{ item.label }}</label>
                                                <select
                                                    :name="item.name"
                                                    :id="item.name"
                                                    v-model="form[item.name]"
                                                    class="form-control"
                                                    :class="{ 'is-invalid': form.errors.has(item.name) }"
                                                >
                                                    <option value="" disabled selected>Select User Type</option>
                                                    <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.name }}</option>
                                                </select>
                                                <has-error :form="form" :field="item.name"></has-error>
                                            </div>
                                        </div>
                                        <div v-else-if="item.type == 'radio'">
                                            <div class="form-group">
                                                <label :for="item.name">{{ item.label }}</label>
                                                <div class="form-group d-flex">
                                                    <div class="custom-control custom-radio">
                                                        <input
                                                            class="custom-control-input"
                                                            :type="item.type"
                                                            :name="item.name"
                                                            id="Male"
                                                            v-model="form[item.name]"
                                                            value="Male"
                                                            checked
                                                        >
                                                        <label for="Male" class="custom-control-label mr-3">Male</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input
                                                            class="custom-control-input"
                                                            :type="item.type"
                                                            :name="item.name"
                                                            id="Female"
                                                            v-model="form[item.name]"
                                                            value="Female"
                                                        >
                                                        <label for="Female" class="custom-control-label">Female</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else>
                                            <label :for="item.name">{{ item.label }}</label>
                                            <input
                                                :id="item.name"
                                                :name="item.name"
                                                :type="item.type"
                                                v-model="form[item.name]"
                                                class="form-control"
                                                :class="{ 'is-invalid': form.errors.has(item.name) }"
                                            >
                                            <has-error :form="form" :field="item.name"></has-error>
                                        </div>
                                    </div>
                                </div>
                                <!-- second row -->
                                <div class="col-6">
                                    <div v-for="(item, $index) in item_col_2" :key="$index" class="form-group">
                                        <label :for="item.name">{{ item.label }}</label>
                                        <input
                                            :disabled="editMode && item.name == 'password'"
                                            :id="item.name"
                                            :name="item.name"
                                            :type="item.type"
                                            v-model="form[item.name]"
                                            class="form-control"
                                            :class="{ 'is-invalid': form.errors.has(item.name) }"
                                        >
                                        <has-error :form="form" :field="item.name"></has-error>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary p-18" data-dismiss="modal">Cancel</button>
                            <button v-show="!editMode" type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i>Save
                            </button>
                            <button v-show="editMode" type="submit" class="btn btn-primary">
                                <i class="fas fa-pen mr-1"></i>Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "UserManagement",
        data() {
            return {
                users: {},
                roles: {},
                form: new Form({
                    id: '',
                    firstname: '',
                    middlename: '',
                    lastname: '',
                    user_type_id: '',
                    gender: '',
                    contact_no: '',
                    birthday: '',
                    username: '',
                    email: '',
                    password: '',
                }),
                item_col_1: [
                    {
                        label: "Firstname",
                        name: "firstname",
                        required: "required",
                        type: "text"
                    },
                    {
                        label: "Middlename",
                        name: "middlename",
                        required: "required",
                        type: "text"
                    },
                    {
                        label: "Lastname",
                        name: "lastname",
                        required: "required",
                        type: "text"
                    },
                    {
                        label: "User Type",
                        name: "user_type_id",
                        required: "required",
                        type: "dropdown"
                    },
                    {
                        label: "Gender",
                        name: "gender",
                        required: "required",
                        type: "radio",
                        id : [
                            {
                                name: "male"
                            },
                            {
                                name: "female"
                            }
                        ]
                    },
                ],
                item_col_2: [
                    {
                        label: "Contact No",
                        name: "contact_no",
                        required: "required",
                        type: "number"
                    },
                    {
                        label: "Birthday",
                        name: "birthday",
                        required: "required",
                        type: "date"
                    },
                    {
                        label: "Username",
                        name: "username",
                        required: "required",
                        type: "text"
                    },
                    {
                        label: "Email",
                        name: "email",
                        required: "required",
                        type: "email"
                    },
                    {
                        label: "Password",
                        name: "password",
                        required: "required",
                        type: "password"
                    },
                ],
                errors: [],
                editMode: false,
            }
        },
        created() {
            this.loadUsers();
            Fire.$on('refreshUsers', () => {
                this.form.reset();
                this.form.clear();
                this.loadUsers();
            });
        },
        methods: {
            async loadUsers() {
                    this.$Progress.start();
                    await axios.get('api/user')
                        .then(({ data }) => {
                            this.$Progress.finish();
                            this.users = data.data.users;
                            this.roles = data.data.roles;
                        })
                        .catch(err => {
                            this.$Progress.fail();
                            console.log(err)
                        });
                },
            addModal() {
                this.editMode = false;
                $('#add_user').modal('show');
            },
            addUser() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, add it!'
                }).then((result) => {
                    if (result.value) {
                        this.$Progress.start();
                        this.form.post('api/user', this.form)
                            .then(({ data }) => {
                                this.$Progress.finish();
                                Fire.$emit('refreshUsers');
                                toast.fire({
                                    icon: data.status,
                                    title: data.message
                                });
                                $('#add_user').modal('hide');
                            })
                            .catch(err => {
                                this.$Progress.fail();
                                console.log(err);
                            });
                    }
                })
            },
            editModal(user) {
                this.form.reset();
                this.form.clear();
                this.editMode = true;
                $('#add_user').modal('show');
                this.form.fill(user);
            },
            updateUser() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, update it!'
                }).then((result) => {
                    if (result.value) {
                        this.$Progress.start();
                        this.form.put('api/user/'+ this.form.id)
                            .then(({ data }) => {
                                this.$Progress.finish();
                                Fire.$emit('refreshUsers');
                                toast.fire({
                                    icon: data.status,
                                    title: data.message
                                });
                                $('#add_user').modal('hide');
                            })
                            .catch(err => {
                                this.$Progress.fail();
                                console.log(err);
                            });
                    }
                })
            },
            deleteUser(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        this.$Progress.start();
                        this.form.delete('api/user/'+ id)
                            .then(({ data }) => {
                                this.$Progress.finish();
                                Fire.$emit('refreshUsers');
                                toast.fire({
                                    icon: data.status,
                                    title: data.message
                                });
                            })
                            .catch(err => {
                                this.$Progress.fail();
                                toast.fire({
                                    icon: err.status,
                                    title: err.message
                                });
                                console.log(err);
                            });
                    }
                })
            }
        }
    }
</script>
