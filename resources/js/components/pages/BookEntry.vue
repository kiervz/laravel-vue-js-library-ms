<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <div class="d-flex align-items-center">
                                <h3 class="card-title">Books</h3>
                            </div>
                            <div class="float-right">
                                <button class="btn btn-sm btn-primary show-book-modal" @click="addCategoryModal" data-title="ADD_CATEG">
                                    Categories <i class="fas fa-tasks"></i>
                                </button>
                                <button class="btn btn-sm btn-primary show-book-modal" @click="addModal" data-title="ADD">
                                    Book Register <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Call No.</th>
                                    <th>ISBN</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Publisher</th>
                                    <th>Category</th>
                                    <th>Date Pub.</th>
                                    <th>Copies</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="book in books" :key="book.id">
                                    <td>{{ book.id }}</td>
                                    <td>{{ book.call_number }}</td>
                                    <td>{{ book.isbn }}</td>
                                    <td>{{ book.title }}</td>
                                    <td>{{ book.author }}</td>
                                    <td>{{ book.publisher }}</td>
                                    <td>{{ book.category.category }}</td>
                                    <td>{{ book.date_published }}</td>
                                    <td>{{ book.total_copies }}</td>
                                    <td>
                                        <i class="fas fa-plus" @click="updateCopiesModal(book)"></i>
                                        |
                                        <i class="fas fa-edit" @click="editModal(book)"></i>
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
                            <!-- <pagination :data="books" show-disabled :limit="limit" @pagination-change-page="loadBooks"></pagination> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for updating book -->
        <div class="modal fade" id="add_book" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form @submit.prevent="editMode ? updateBook() : addBook()">
                        <!-- Modal Header -->
                        <div class="modal-header bg-dark text-white">
                            <h5 v-show="!editMode" class="modal-title">Register Book</h5>
                            <h5 v-show="editMode" class="modal-title">Update Book</h5>
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
                                <!-- second row -->
                                <div class="col-6">
                                    <div v-for="(item, $index) in item_col_2" :key="$index" class="form-group">
                                        <label :for="item.name">{{ item.label }}</label>
                                        <div v-if="item.type == 'dropdown'">
                                            <select
                                                :name="item.name"
                                                :id="item.name"
                                                v-model="form[item.name]"
                                                class="form-control"
                                                :class="{ 'is-invalid': form.errors.has(item.name) }"
                                            >
                                                <option value="" disabled selected>Select Book Category</option>
                                                <option
                                                    v-for="item in book_categories"
                                                    v-bind:value="item.id"
                                                    v-bind:key="item.id">
                                                    {{ item.category }}
                                                </option>
                                            </select>
                                            <has-error :form="form" :field="item.name"></has-error>
                                        </div>
                                        <div v-else>
                                            <div>
                                                <!-- When edit modal is active, the copies field will be disabled -->
                                                <input
                                                    :disabled="editMode && item.name == 'total_copies'"
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

        <!-- Modal for updating copies of book -->
        <div class="modal fade" id="update_copies" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <form @submit.prevent="updateBookCopies">
                        <div class="modal-header bg-dark text-white">
                            <h5 class="modal-title" id="exampleModalLabel">Acquire New Copies</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span class="text-white" aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-header">
                                    Book Details
                                </div>
                                <div class="card-body">
                                    <div class="form-group row ml-1">
                                        <div class="col-md-5">
                                            <label for="book_title" class="mr-4">Book Title: </label>
                                        </div>
                                        <div class="col">
                                            {{ form.title }}
                                        </div>
                                    </div>
                                    <div class="form-group row ml-1">
                                        <div class="col-md-5">
                                            <label for="avail_copies" class="mr-4">Available Copies: </label>
                                        </div>
                                        <div class="col">
                                            {{ form.avail_copies }}
                                        </div>
                                    </div>
                                    <div class="form-group row ml-1">
                                        <div class="col-md-5">
                                            <label for="total_copies" class="mr-4">Total Copies: </label>
                                        </div>
                                        <div class="col">
                                            {{ form.total_copies }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="number_copies">Number of Copies</label>
                                <input
                                    required
                                    type="number"
                                    v-model="form['number_copies']"
                                    class="form-control"
                                    id="number_copies"
                                    name="number_copies"
                                >
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Copies</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for categories -->
        <div class="modal fade" id="manage_category" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title" id="exampleModalLabel">Manage Categories</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="text-white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-header">
                                Book Categories
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Category</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in book_categories" :key="item.id">
                                            <td>{{ item.id }}</td>
                                            <td>{{ item.category }}</td>
                                            <td>
                                                <i class="fas fa-edit" @click="editCategory(item.id)"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="category">Category</label>
                            <input
                                type="text"
                                v-model="categoryData['category']"
                                class="form-control"
                                id="category"
                                name="category"
                            >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" @click="clearCategory" class="btn btn-danger">Clear</button>
                        <button
                            v-show="!editModeCategory"
                            @click="addCategory"
                            type="submit"
                            class="btn btn-primary"
                        >
                            <i class="fas fa-save mr-1"></i>Save
                        </button>
                        <button
                            v-show="editModeCategory"
                            @click="updateCategory"
                            type="submit"
                            class="btn btn-primary"
                        >
                            <i class="fas fa-pen mr-1"></i>Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "BookEntry",
        data() {
            return {
                books: {},
                book_categories: {},
                categoryData: {
                    id: '',
                    category: ''
                },
                // Create a new form instance
                form: new Form({
                    id: '',
                    isbn: '',
                    call_number: '',
                    title: '',
                    author: '',
                    publisher: '',
                    description: '',
                    category_id: '',
                    date_published: '',
                    series: '',
                    price: '',
                    avail_copies: '',
                    number_copies:'',
                    total_copies: ''
                }),
                item_col_1: [
                    {
                        label: "ISBN",
                        name: "isbn",
                        required: "required",
                        type: "number"
                    },
                    {
                        label: "Call Number",
                        name: "call_number",
                        required: "required",
                        type: "text"
                    },
                    {
                        label: "Title",
                        name: "title",
                        required: "required",
                        type: "text"
                    },
                    {
                        label: "Author",
                        name: "author",
                        required: "required",
                        type: "text"
                    },
                    {
                        label: "Publisher",
                        name: "publisher",
                        required: "required",
                        type: "text"
                    },
                ],
                item_col_2: [
                    {
                        label: "Description",
                        name: "description",
                        required: "required",
                        type: "text"
                    },
                    {
                        label: "Category",
                        name: "category_id",
                        required: "required",
                        type: "dropdown"
                    },
                    {
                        label: "Date Published",
                        name: "date_published",
                        required: "required",
                        type: "date"
                    },
                    {
                        label: "Series",
                        name: "series",
                        required: "required",
                        type: "text"
                    },
                    {
                        label: "Copies",
                        name: "total_copies",
                        required: "required",
                        type: "number"
                    },
                    {
                        label: "Price",
                        name: "price",
                        required: "required",
                        type: "number"
                    },
                ],
                limit: 2,
                editMode: true,
                editModeCategory: false
            }
        },
        created() {
            this.loadBooks();
            Fire.$on('refreshBooks', () => {
                this.loadBooks();
            })
        },
        methods: {
            async loadBooks() {
                this.$Progress.start();
                await axios.get('api/book')
                        .then(({ data }) => {
                            this.$Progress.finish();
                            this.books = data.data.books;
                            this.book_categories = data.data.book_categories;
                            this.$Progress.finish();
                        })
                        .catch(err => {
                            console.log("Error :", err)
                            this.$Progress.fail();
                        })
            },
            addModal() {
                this.form.reset();
                this.form.clear();
                this.editMode = false;
                $('#add_book').modal('show');
            },
            addBook() {
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
                        this.form.post('api/book', this.form)
                            .then(({ data }) => {
                                this.$Progress.finish();
                                toast.fire({
                                    icon: data.status,
                                    title: data.message
                                });
                                Fire.$emit('refreshBooks');
                                $('#add_book').modal('hide');
                            })
                            .catch(err => {
                                this.$Progress.fail();
                                this.errors = err.response.data.errors;
                                toast.fire({
                                    icon: 'warning',
                                    title: 'There was something wrong.'
                                });
                            })
                    }
                });

            },
            editModal(book) {
                this.form.reset();
                this.form.clear();
                this.editMode = true;
                $('#add_book').modal('show');
                this.form.fill(book);
            },
            updateCopiesModal(book) {
                this.form.reset();
                this.form.clear();
                $('#update_copies').modal('show');
                this.form.fill(book);
            },
            updateBookCopies() {
                Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, add new copies!'
                    }).then((result) => {
                        if (result.value) {
                            this.$Progress.start();
                            this.form.put('api/book/' + this.form.id)
                                .then(({ data }) => {
                                    this.$Progress.finish();
                                    toast.fire({
                                        icon: data.status,
                                        title: data.message,
                                    });
                                    this.form.reset();
                                    Fire.$emit('refreshBooks');
                                    $('#update_copies').modal('hide');
                                })
                                .catch(err => {
                                    this.$Progress.fail();
                                    console.log(err);
                                    toast.fire({
                                        icon: 'error',
                                        title: 'Something went wrong. Please, try again later.',
                                    });
                                });
                        }
                    })

            },
            updateBook() {
                Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, update it!'
                    }).then((result) => {
                        if (result.value) {
                            this.$Progress.start();
                            this.form.put('api/book/' + this.form.id)
                                .then(({ data }) => {
                                    this.$Progress.finish();
                                    toast.fire({
                                        icon: data.status,
                                        title: data.message
                                    });
                                    Fire.$emit('refreshBooks');
                                    $('#add_book').modal('hide');
                                })
                                .catch(err => {
                                    this.$Progress.fail();
                                    console.log(err);
                                    toast.fire({
                                        icon: 'warning',
                                        title: 'There was something wrong.'
                                    });
                                });
                        }
                    })
            },
            deleteBook(id) {
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
                            axios.delete('api/book/' + id)
                                .then(({ data }) => {
                                    this.$Progress.finish();
                                    toast.fire({
                                        icon: data.status,
                                        title: data.message
                                    });
                                    Fire.$emit('refreshBooks');
                                })
                                .catch(err => {
                                    this.$Progress.fail();
                                    console.log(err);
                                    toast.fire({
                                        icon: 'warning',
                                        title: 'There was something wrong.'
                                    });
                                });
                        }
                    })
            },
            addCategoryModal() {
                $('#manage_category').modal('show');
            },
            clearCategory() {
                this.editModeCategory = false;
                this.text = "";
                var self = this;

                Object.keys(this.categoryData).forEach(function(key, index) {
                    self.categoryData[key] = '';
                });
            },
            editCategory(id) {
                axios.get('api/book_category/'+id)
                    .then(({ data }) => {
                        this.editModeCategory = true;
                        this.categoryData = data.data
                    })
                    .catch(err => console.log(err));
            },
            async updateCategory() {
                this.$Progress.start();
                await axios.put('api/book_category/' + this.categoryData.id, this.categoryData)
                    .then(({ data }) => {
                        this.$Progress.finish();
                        Fire.$emit('refreshBooks');
                        this.categoryData = {};
                        this.editModeCategory = false;
                        toast.fire({
                            icon: data.status,
                            title: data.message,
                        });
                    })
                    .catch(err => {
                        this.$Progress.fail();
                        console.log(err);
                        toast.fire({
                            icon: 'error',
                            title: 'Something went wrong. Please, try again later.',
                        });
                    });
            },
            async addCategory() {
                this.$Progress.start()
                await axios.post('api/book_category', this.categoryData)
                            .then(({ data }) => {
                                this.$Progress.finish();
                                Fire.$emit('refreshBooks');
                                this.categoryData = {};

                                toast.fire({
                                    icon: data.status,
                                    title: data.message
                                });
                            })
                            .catch(err => {
                                console.log(err);
                                toast.fire({
                                    icon: 'error',
                                    title: 'Something went wrong. Please, try again later.',
                                });
                            });
            }
        }
    }
</script>
