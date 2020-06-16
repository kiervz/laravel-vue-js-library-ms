<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <!-- /.col -->
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                            <li class="nav-item">
                                <a
                                    class="nav-link active"
                                    id="manage-student-tab"
                                    data-toggle="pill"
                                    href="#manage-student"
                                    role="tab"
                                    aria-controls="manage-student"
                                    aria-selected="true"
                                >
                                    Manage Student
                                </a>
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    id="manage-faculty-tab"
                                    data-toggle="pill"
                                    href="#manage-faculty"
                                    role="tab"
                                    aria-controls="manage-faculty"
                                    aria-selected="false"
                                >
                                    Manage Faculty
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-three-tabContent">
                            <!-- manage student panel -->
                            <div class="tab-pane fade active show" id="manage-student" role="tabpanel" aria-labelledby="manage-student-tab">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Major</th>
                                            <th>Username</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <!-- manage faculty panel -->
                            <div class="tab-pane fade" id="manage-faculty" role="tabpanel" aria-labelledby="manage-faculty-tab">
                                <table class="table table-sm table-hover">
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

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {

            }
        },
        methods : {

        }
    }
</script>
