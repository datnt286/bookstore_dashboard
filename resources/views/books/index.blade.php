@extends('master')

@section('content')
<div class="row my-4">
    <div class="col-9">
        <h1 class="m-0">Quản lý sách</h1>
    </div>
    <div class="col-3 text-right">
        <button type="button" id="btn-create" class="btn btn-success mt-2" data-toggle="modal" data-target="#modal-create">
            <i class="fas fa-plus-circle"></i>
            Thêm sách
        </button>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table id="data-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Hình ảnh</th>
                    <th>Tựa sách</th>
                    <th>Thể loại</th>
                    <th>Nhà xuất bản</th>
                    <th>Nhà cung cấp</th>
                    <th>Giá bán</th>
                    <th>Số lượng</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modal-store">
    <form id="form-store" enctype="multipart/form-data">
        @csrf
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-title" class="modal-title">Thêm sách</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group text-center">
                            <label for="images" class="form-label d-block">Hình ảnh:</label>
                            <div id="images-preview" class="form-group">
                                <img src="{{ asset('img/default-image.jpg') }}" alt="Hình ảnh" class="img img-thumbnail" style="max-width: 100px; max-height: 100px;">
                            </div>
                            <input type="file" name="images[]" id="images" class="d-none" multiple>
                            <label for="images" class="btn btn-secondary font-weight-normal">
                                Chọn ảnh
                            </label>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="name">Tựa sách: </label>
                                <input type="text" name="name" id="name" class="form-control">
                                <div class="invalid-feedback name-error">{{ $errors->first('name') }}</div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="category_id">Thể loại: </label>
                                <select name="category_id" id="category-id" class="form-control select2" style="width: 100%;" required>
                                </select>
                                <div class="invalid-feedback category-id-error">{{ $errors->first('category_id') }}</div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Tác giả:</label>
                                <select name="author_ids[]" id="author-ids" class="select2" multiple="multiple" style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="publisher_id">Nhà xuất bản: </label>
                                <select name="publisher_id" id="publisher-id" class="form-control select2" style="width: 100%;" required>
                                </select>
                                <div class="invalid-feedback publisher-id-error">{{ $errors->first('publisher_id') }}</div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="supplier_id">Nhà cung cấp: </label>
                                <select name="supplier_id" id="supplier-id" class="form-control select2" style="width: 100%;" required>
                                </select>
                                <div class="invalid-feedback supplier-id-error">{{ $errors->first('supplier_id') }}</div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="price">Giá bán: </label>
                                <input type="text" name="price" id="price" class="form-control">
                                <div class="invalid-feedback price-error">{{ $errors->first('price') }}</div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="quantity">Số lượng: </label>
                                <input type="text" name="quantity" id="quantity" class="form-control">
                                <div class="invalid-feedback quantity-error">{{ $errors->first('quantity') }}</div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="e-book-price">Giá e-book: </label>
                                <input type="text" name="e_book_price" id="e-book-price" class="form-control">
                                <div class="invalid-feedback e-book-price-error">{{ $errors->first('e_book_price') }}</div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="language">Ngôn ngữ: </label>
                                <input type="text" name="language" id="language" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="size">Kích cỡ: </label>
                                <input type="text" name="size" id="size" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="weight">Khối lượng: </label>
                                <input type="text" name="weight" id="weight" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="num-pages">Số trang: </label>
                                <input type="text" name="num_pages" id="num-pages" class="form-control">
                                <div class="invalid-feedback num-pages-error">{{ $errors->first('num_pages') }}</div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="release-date">Ngày xuất bản: </label>
                                <input type="text" name="release_date" id="release-date" class="form-control">
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Combo:</label>
                                <select name="combo_ids[]" id="combo-ids" class="select2" multiple="multiple" style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="description">Mô tả: </label>
                                <textarea name="description" id="description">
                                </textarea>
                            </div>
                            <div class="col-md-6 form-group m-auto">
                                <div>
                                    <label for="file" class="form-label">File e book:</label>
                                </div>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="file" id="file" class="custom-file-input">
                                        <label for="file" class="custom-file-label">Chọn tệp</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fas fa-times-circle"></i>
                        Huỷ
                    </button>
                    <button type="button" id="btn-store" class="btn btn-primary">
                        <i class="fas fa-check"></i>
                        Lưu
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thông tin sách</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div id="images-detail" class="form-group text-center">
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <span class="text-lg font-weight-bold">Tựa sách: </span>
                            <span id="name-detail" class="text-lg"></span>
                        </div>
                        <div class="col-md-12 form-group">
                            <span class="text-lg font-weight-bold">Thể loại: </span>
                            <span id="category-detail" class="text-lg"></span>
                        </div>
                        <div class="col-md-12 form-group">
                            <span class="text-lg font-weight-bold">Tác giả: </span>
                            <span id="authors-detail" class="text-lg"></span>
                        </div>
                        <div class="col-md-6 form-group">
                            <span class="text-lg font-weight-bold">Nhà xuất bản: </span>
                            <span id="publisher-detail" class="text-lg"></span>
                        </div>
                        <div class="col-md-6 form-group">
                            <span class="text-lg font-weight-bold">Nhà cung cấp: </span>
                            <span id="supplier-detail" class="text-lg"></span>
                        </div>
                        <div class="col-md-6 form-group">
                            <span class="text-lg font-weight-bold">Giá bán: </span>
                            <span id="price-detail" class="text-lg"></span>
                        </div>
                        <div class="col-md-6 form-group">
                            <span class="text-lg font-weight-bold">Số lượng: </span>
                            <span id="quantity-detail" class="text-lg"></span>
                        </div>
                        <div class="col-md-6 form-group">
                            <span class="text-lg font-weight-bold">Giá e-book: </span>
                            <span id="e-book-price-detail" class="text-lg"></span>
                        </div>
                        <div class="col-md-6 form-group">
                            <span class="text-lg font-weight-bold">Ngôn ngữ: </span>
                            <span id="language-detail" class="text-lg"></span>
                        </div>
                        <div class="col-md-6 form-group">
                            <span class="text-lg font-weight-bold">Kích cỡ: </span>
                            <span id="size-detail" class="text-lg"></span>
                        </div>
                        <div class="col-md-6 form-group">
                            <span class="text-lg font-weight-bold">Khối lượng: </span>
                            <span id="weight-detail" class="text-lg"></span>
                        </div>
                        <div class="col-md-6 form-group">
                            <span class="text-lg font-weight-bold">Số trang: </span>
                            <span id="num-pages-detail" class="text-lg"></span>
                        </div>
                        <div class="col-md-6 form-group">
                            <span class="text-lg font-weight-bold">Ngày xuất bản: </span>
                            <span id="release-date-detail" class="text-lg"></span>
                        </div>
                        <div class="col-md-12 form-group">
                            <span class="text-lg font-weight-bold">Combo: </span>
                            <span id="combos-detail" class="text-lg"></span>
                        </div>
                        <div class="col-md-12 form-group">
                            <span class="text-lg font-weight-bold">Mô tả: </span>
                            <span id="description-detail" class="text-lg"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-js')
<script>
    $(document).ready(function() {
        $('.select2').select2();
        $('#description').summernote();

        var dataTable = $('#data-table').DataTable({
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'copy',
                    text: 'Sao chép'
                },
                {
                    extend: 'excel',
                    text: 'Xuất Excel'
                },
                {
                    extend: 'pdf',
                    text: 'Xuất PDF'
                },
                {
                    extend: 'print',
                    text: 'In'
                },
                {
                    extend: 'colvis',
                    text: 'Hiển thị cột'
                },
                {
                    extend: 'pageLength',
                    text: 'Số dòng trên trang'
                }
            ],
            language: {
                search: "Tìm kiếm:",
                processing: "Đang xử lý...",
                lengthMenu: "Hiển thị _MENU_ mục",
                info: "Hiển thị _START_ đến _END_ trong _TOTAL_ mục",
                infoEmpty: "Hiển thị 0 đến 0 trong 0 mục",
                infoFiltered: "(được lọc từ _MAX_ mục)",
                paginate: {
                    first: 'Trang đầu',
                    previous: 'Trang trước',
                    next: 'Trang sau',
                    last: 'Trang cuối'
                },
            },
            ajax: {
                type: 'GET',
                url: "{{ route('book.index') }}",
                dataType: 'json',
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'images',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        var imageUrl = data.length > 0 ? '{{ asset("uploads/images/") }}/' + data[0].name : '{{ asset("img/default-image.jpg") }}';
                        return '<img src="' + imageUrl + '" alt="Hình ảnh" class="img img-thumbnail" style="max-width: 100px; max-height: 100px;">';
                    }
                },
                {
                    data: 'name'
                },
                {
                    data: 'category_name'
                },
                {
                    data: 'publisher_name'
                },
                {
                    data: 'supplier_name'
                },
                {
                    data: 'price'
                },
                {
                    data: 'quantity'
                },
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row) {
                        return '<div class="project-actions text-right">' +
                            '<button class="btn btn-info btn-sm btn-detail" data-id="' + row.id + '" data-toggle="modal" data-target="#modal-detail"><i class="fas fa-info-circle"></i> Chi tiết</button>' +
                            '<button class="btn btn-primary btn-sm btn-edit mx-1" data-id="' + row.id + '" data-toggle="modal" data-target="#modal-store"><i class="fas fa-edit"></i> Cập nhật</button>' +
                            '<button class="btn btn-danger btn-sm btn-delete" data-id="' + row.id + '" data-toggle="modal" data-target="#modal-delete"><i class="fas fa-trash-alt"></i> Xoá</button>' +
                            '</div>';
                    }
                }
            ]
        });

        var id = null;
        var formData = new FormData($('#form-store')[0]);

        $('#btn-create').click(async function() {
            try {
                resetValidationForm();
                id = null;
                $('#id').val(null);
                $('#form-store').trigger('reset');
                $('#category-id').empty();
                $('#author-ids').empty();
                $('#publisher-id').empty();
                $('#supplier-id').empty();
                $('#combo-ids').empty();
                $('#images-preview').empty();
                $('#images-preview').append('<img src="{{ asset("img/default-image.jpg") }}" alt="Hình ảnh" class="img img-thumbnail mb-3" style="max-width: 100px; max-height: 100px;">');

                var response = await axios.get("{{ route('book.create') }}");
                var res = response.data;

                $('#category-id').append('<option value="" selected disabled>-- Chọn thể loại --</option>');
                res.data.categories.forEach(function(category) {
                    $('#category-id').append('<option value="' + category.id + '">' + category.name + '</option>');
                });

                res.data.authors.forEach(function(author) {
                    $('#author-ids').append('<option value="' + author.id + '">' + author.name + '</option>');
                });

                $('#publisher-id').append('<option value="" selected disabled>-- Chọn nhà xuất bản --</option>');
                res.data.publishers.forEach(function(publisher) {
                    $('#publisher-id').append('<option value="' + publisher.id + '">' + publisher.name + '</option>');
                });

                $('#supplier-id').append('<option value="" selected disabled>-- Chọn nhà cung cấp --</option>');
                res.data.suppliers.forEach(function(supplier) {
                    $('#supplier-id').append('<option value="' + supplier.id + '">' + supplier.name + '</option>');
                });

                res.data.combos.forEach(function(combo) {
                    $('#combo-ids').append('<option value="' + combo.id + '">' + combo.name + '</option>');
                });

                $('#modal-title').text('Thêm sách');
                $('#modal-store').modal('show');
            } catch (error) {
                handleError(error);
            }
        });

        $('#data-table').on('click', '.btn-edit', async function() {
            try {
                resetValidationForm();
                var id = $(this).data('id');
                var response = await axios.get("{{ route('book.edit', ['id' => '_id_']) }}".replace('_id_', id));
                var res = response.data;

                $('#id').val(res.data.book.id);
                $('#name').val(res.data.book.name);
                $('#price').val(res.data.book.price);
                $('#quantity').val(res.data.book.quantity);
                $('#e-book-price').val(res.data.book.e_book_price);
                $('#language').val(res.data.book.language);
                $('#weight').val(res.data.book.weight);
                $('#size').val(res.data.book.size);
                $('#num-pages').val(res.data.book.num_pages);
                $('#release-date').val(res.data.book.release_date);
                $('#description').summernote('code', res.data.book.description);

                $('#category-id').empty();
                $('#author-ids').empty();
                $('#publisher-id').empty();
                $('#supplier-id').empty();
                $('#combo-ids').empty();
                $('#images-preview').empty();

                res.data.categories.forEach(function(category) {
                    var selected = (res.data.book.category_id == category.id) ? 'selected' : '';
                    $('#category-id').append('<option value="' + category.id + '" ' + selected + '>' + category.name + '</option>');
                });

                res.data.authors.forEach(function(author) {
                    var selected = (res.data.book.authors.map(a => a.id).includes(author.id)) ? 'selected' : '';
                    $('#author-ids').append('<option value="' + author.id + '" ' + selected + '>' + author.name + '</option>');
                });

                res.data.publishers.forEach(function(publisher) {
                    var selected = (res.data.book.publisher_id == publisher.id) ? 'selected' : '';
                    $('#publisher-id').append('<option value="' + publisher.id + '" ' + selected + '>' + publisher.name + '</option>');
                });

                res.data.suppliers.forEach(function(supplier) {
                    var selected = (res.data.book.supplier_id == supplier.id) ? 'selected' : '';
                    $('#supplier-id').append('<option value="' + supplier.id + '" ' + selected + '>' + supplier.name + '</option>');
                });

                res.data.combos.forEach(function(combo) {
                    var selected = (res.data.book.combos.map(c => c.id).includes(combo.id)) ? 'selected' : '';
                    $('#combo-ids').append('<option value="' + combo.id + '" ' + selected + '>' + combo.name + '</option>');
                });

                res.data.book.images.forEach(function(image) {
                    $('#images-preview').append('<img src="' + '{{ asset("uploads/images/") }}' + '/' + image.name + '" alt="Hình ảnh" class="img img-thumbnail mx-2" style="max-width: 100px; max-height: 100px;">');
                });

                $('#modal-title').text('Cập nhật sách');
                $('#modal-store').modal('show');
            } catch (error) {
                handleError(error);
            }
        });

        $('#images').change(function(event) {
            var input = event.target;
            $('#images-preview').empty();

            formData.delete('images[]');

            if (input.files.length > 0) {
                for (var i = 0; i < input.files.length; i++) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#images-preview').append('<img src="' + e.target.result + '" alt="Hình ảnh" class="img img-thumbnail mx-2" style="max-width: 100px; max-height: 100px;">');
                    };
                    reader.readAsDataURL(input.files[i]);

                    formData.append('images[]', input.files[i]);
                }
            }

            $('.select2').trigger('change');
        });

        $('#btn-store').click(async function() {
            try {
                id = $('#id').val();
                var formData = new FormData($('#form-store')[0]);

                if (id) {
                    var url = `{{ route('book.update', ['id' => '_id_']) }}`.replace('_id_', id);
                } else {
                    var url = "{{ route('book.store') }}";
                }

                var response = await axios.post(url, formData);
                var res = response.data;

                $('#modal-store').modal('hide');
                dataTable.draw();
                handleSuccess(res);
            } catch (error) {
                handleError(error);
            }
        });

        $('#data-table').on('click', '.btn-detail', async function() {
            try {
                var id = $(this).data('id');

                var response = await axios.get("{{ route('book.show', ['id' => '_id_']) }}".replace('_id_', id));
                var res = response.data;

                $('#name-detail').text(res.data.name);
                $('#category-detail').text(res.data.category);
                $('#publisher-detail').text(res.data.publisher);
                $('#supplier-detail').text(res.data.supplier);
                $('#price-detail').text(res.data.price);
                $('#quantity-detail').text(res.data.quantity);
                $('#e-book-price-detail').text(res.data.e_book_price);
                $('#language-detail').text(res.data.language);
                $('#size-detail').text(res.data.size);
                $('#weight-detail').text(res.data.weight);
                $('#num-pages-detail').text(res.data.num_pages);
                $('#release-date-detail').text(res.data.release_date);
                $('#description-detail').text(res.data.description);

                $('#authors-detail').empty();
                $('#combos-detail').empty();
                $('#images-detail').empty();

                var authorsName = res.data.authors.map(author => author.name).join(', ');
                $('#authors-detail').text(authorsName);

                var combosName = res.data.combos.map(combo => combo.name).join(', ');
                $('#combos-detail').text(combosName);

                res.data.images.forEach(function(image) {
                    $('#images-detail').append('<img src="' + '{{ asset("uploads/images/") }}' + '/' + image.name + '" alt="Hình ảnh" class="img img-thumbnail mx-2" style="max-width: 100px; max-height: 100px;">');
                });

                $('#modal-detail').modal('show');
            } catch (error) {
                handleError(error);
            }
        });

        $('#data-table').on('click', '.btn-delete', async function() {
            try {
                id = $(this).data('id');
                $('#modal-delete').modal('show');
            } catch (error) {
                handleError(error);
            }
        });

        $('#btn-confirm-delete').click(async function() {
            try {
                var response = await axios.get("{{ route('book.destroy', ['id' => '_id_']) }}".replace('_id_', id));
                var res = response.data;

                $('#modal-delete').modal('hide');
                dataTable.draw();
                handleSuccess(res);
            } catch (error) {
                handleError(error);
            }
        });
    });
</script>
@endsection