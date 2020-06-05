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
                            <button class="btn btn-sm btn-primary show-book-modal" @click="addModal" data-title="ADD">
                                Book Register <i class="fas fa-plus"></i>
                            </button>
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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="book in books" v-bind:key="book.id">
                                    <td>{{ book.id }}</td>
                                    <td>{{ book.call_number }}</td>
                                    <td>{{ book.isbn }}</td>
                                    <td>{{ book.title }}</td>
                                    <td>{{ book.author }}</td>
                                    <td>{{ book.publisher }}</td>
                                    <td>{{ book.category_id }}</td>
                                    <td>{{ book.date_published }}</td>
                                    <td>
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
        name: "BookEntry",
        data() {
            return {
                books: {},
                book_categories: {},
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
                    total_copies: ''
                }),
                item_col_1: [
                    {
                        label: "ISBN",
                        name: "isbn",
                        required: "required",
                        type: "text"
                    },
                    {
                        label: "Call Number",
                        name: "call_number",
                        required: "required",
                        type: "number"
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
                editMode: true
            }
        },
        created() {
            this.loadBooks();
        },
        methods: {
            // fetching data
            async loadBooks() {
                await axios.get('api/book')
                        .then(({ data }) => {
                            this.books = data.data.book;
                            this.book_categories = data.data.book_categories;
                        })
                        .catch(err => console.log("Error :", err));
            },
            addModal() {
                this.form.reset();
                this.form.clear();
                this.editMode = false;
                $('#add_book').modal('show');
            },
            async addBook() {
                this.$Progress.start();
                await this.form.post('api/book', this.form)
                    .then(({ data }) => {
                        this.$Progress.finish();
                        this.loadBooks();
                        $('#add_book').modal('hide');
                    })
                    .catch(err => {
                        this.$Progress.fail();
                        this.errors = err.response.data.errors;
                    })
            },
            editModal(book) {
                this.form.reset();
                this.form.clear();
                this.editMode = true;
                $('#add_book').modal('show');
                this.form.fill(book);
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
                                    this.loadBooks();
                                    $('#add_book').modal('hide');
                                })
                                .catch(err => {
                                    this.$Progress.fail();
                                    console.log(err);
                                    Swal.fire('Failed!', 'There was something wrong.', 'warning');
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
                                    Swal.fire('Deleted!', data.message, data.status);
                                    this.loadBooks();
                                })
                                .catch(err => {
                                    this.$Progress.fail();
                                    console.log(err);
                                    Swal.fire('Failed!', 'There was something wrong.', 'warning');
                                });
                        }
                    })
            }
        }
    }
</script>
