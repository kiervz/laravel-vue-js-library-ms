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
                        <table class="table table-bordered">
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
                                    <td>{{ item.user_type_id }}</td>
                                    <td>{{ item.firstname + ' ' + item.lastname }}</td>
                                    <td>{{ item.gender }}</td>
                                    <td>{{ item.username }}</td>
                                    <td>{{ item.birthday }}</td>
                                    <td>
                                        <i class="fas fa-edit" @click="editModal(item)"></i>
                                        |
                                        <i class="fas fa-trash" @click="deleteBook(book.id)"></i>
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
                    <form @submit.prevent="">
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

                                </div>
                                <!-- second row -->
                                <div class="col-6">

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
                errors: [],
                editMode: true,
            }
        },
        created() {
            this.loadUsers();
        },
        methods: {
            addModal() {
                $('#add_user').modal('show');
            },
            loadUsers() {
                axios.get('api/user')
                    .then(({ data }) => {
                        this.users = data.data
                        console.log(data.data);
                    })
                    .catch(err => console.log(err));
            },
        }
    }
</script>
