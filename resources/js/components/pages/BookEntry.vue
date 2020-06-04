<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <div class="d-flex align-items-center pb-2">
                                <h3 class="card-title">Books</h3>
                            </div>
                            <button class="btn btn-sm btn-primary show-book-modal" @click="openModal" data-title="ADD">
                                Book Register <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
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
                    <!-- Modal Header -->
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title">Register Book</h5>
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
                                        :required="item.required"
                                        v-model="bookData[item.name]"
                                        class="form-control"
                                    >
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
                                            v-model="bookData[item.name]"
                                            class="form-control"
                                        >
                                            <option value="" disabled selected>Select Book Category</option>
                                            <option
                                                v-for="item in book_categories"
                                                v-bind:value="item.id"
                                                v-bind:key="item.id">
                                                {{ item.category }}
                                            </option>
                                        </select>
                                    </div>
                                    <div v-else>
                                        <input
                                            :id="item.name"
                                            :name="item.name"
                                            :required="item.required"
                                            :type="item.type"
                                            v-model="bookData[item.name]"
                                            class="form-control"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary p-18" data-dismiss="modal">Cancel</button>
                        <button @click="saveData" type="button" class="btn btn-secondary p-18"><i class="fas fa-save mr-1"></i>Save</button>
                        <button type="button" class="btn btn-secondary p-18"><i class="fas fa-pen mr-1"></i>Update</button>
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
                bookData: {
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
                },
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
                editMode: false,
                errors: []
            }
        },
        created() {
            this.loadBooks();
        },
        methods: {
            // fetching data
            async loadBooks() {
                this.$Progress.start();
                await axios.get('api/book')
                    .then(({ data }) => {
                        this.books = data.data.books;
                        this.book_categories = data.data.book_categories;
                        this.$Progress.finish();
                    })
                    .catch(error => {
                        this.$Progress.fail();
                        this.errors = error.response.data.errors;
                    });
            },
            openModal() {
                this.editMode = false;
                $('#add_book').modal('show');
            },
            async saveData() {
                this.$Progress.start();
                await axios.post('api/book', this.bookData)
                    .then(({data}) => {
                        this.$Progress.finish();
                        $('#add_book').modal('hide');
                    })
                    .catch(error => {
                        this.$Progress.fail();
                        this.errors = error.response.data.errors;
                    })
            }
        }
    }
</script>
