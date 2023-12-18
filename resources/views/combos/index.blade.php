@extends('master')

@section('content')
<div class="row my-4">
    <div class="col-9">
        <h1 class="m-0">Quản lý combo</h1>
    </div>
    <div class="col-3 text-right">
        <button type="button" id="btn-create" class="btn btn-success mt-2" data-toggle="modal" data-target="#modal-create">
            <i class="fas fa-plus-circle"></i>
            Thêm combo
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
                    <th>Tên combo</th>
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
                    <h4 id="modal-title" class="modal-title">Thêm combo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group text-center">
                            <label for="image" class="form-label d-block">Hình ảnh:</label>
                            <div>
                                <img id="image-preview" src="{{ asset('img/default-image.jpg') }}" alt="Hình ảnh" class="img img-thumbnail my-2" style="max-width: 100px; max-height: 100px;">
                            </div>
                            <input type="file" name="image" id="image" class="d-none">
                            <label for="image" class="btn btn-secondary font-weight-normal mt-2">
                                Chọn ảnh
                            </label>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="name">Tên combo: </label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="supplier-id">Nhà cung cấp: </label>
                                <select name="supplier_id" id="supplier-id" class="form-control select2" style="width: 100%;" required>
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Sách:</label>
                                <select name="book_ids[]" id="book-ids" class="select2" multiple="multiple" style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="price">Giá bán: </label>
                                <input type="text" name="price" id="price" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="quantity">Số lượng: </label>
                                <input type="text" name="quantity" id="quantity" class="form-control">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="description">Mô tả: </label>
                                <textarea name="description" id="description">
                                </textarea>
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
                <h4 class="modal-title">Thông tin combo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="text-center">
                        <div class="form-group">
                            <span class="text-lg font-weight-bold">Hình ảnh:</span>
                        </div>
                        <div class="form-group">
                            <img id="image-detail-preview" alt="Hình ảnh" class="img img-thumbnail mb-3" style="max-width: 100px; max-height: 100px;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <span class="text-lg font-weight-bold">Tên combo: </span>
                            <span id="name-detail" class="text-lg"></span>
                        </div>
                        <div class="col-md-12 form-group">
                            <span class="text-lg font-weight-bold">Sách: </span>
                            <span id="books-detail" class="text-lg"></span>
                        </div>
                        <div class="col-md-6 form-group">
                            <span class="text-lg font-weight-bold">Giá bán: </span>
                            <span id="price-detail" class="text-lg"></span>
                        </div>
                        <div class="col-md-6 form-group">
                            <span class="text-lg font-weight-bold">Số lượng: </span>
                            <span id="quantity-detail" class="text-lg"></span>
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
                url: "{{ route('combo.index') }}",
                dataType: 'json',
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'image',
                    render: function(data, type, row) {
                        return '<img src="uploads/combos/' + row.image + '" alt="Hình ảnh" class="img img-thumbnail" style="max-width: 100px; max-height: 100px;">';
                    }
                },
                {
                    data: 'name'
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
        var image = null;
        var formData = new FormData($('#form-store')[0]);

        $('#btn-create').click(async function() {
            try {
                var response = await axios.get("{{ route('combo.create') }}");
                var res = response.data;

                id = null;
                $('#id').val(null);
                $('#form-store').trigger('reset');
                $('#supplier-id').empty();
                $('#book-ids').empty();
                $('#image-preview').attr('src', 'img/default-image.jpg');

                $('#supplier-id').append('<option value="" selected disabled>-- Chọn nhà cung cấp --</option>');
                res.data.suppliers.forEach(function(supplier) {
                    $('#supplier-id').append('<option value="' + supplier.id + '">' + supplier.name + '</option>');
                });

                res.data.books.forEach(function(book) {
                    $('#book-ids').append('<option value="' + book.id + '" data-supplier-id="' + book.supplier_id + '">' + book.name + '</option>');
                });

                $('#modal-title').text('Thêm combo');
                $('#modal-store').modal('show');
            } catch (error) {
                handleError(error);
            }
        });

        $('#data-table').on('click', '.btn-edit', async function() {
            try {
                var id = $(this).data('id');
                var response = await axios.get("{{ route('combo.edit', ['id' => '_id_']) }}".replace('_id_', id));
                var res = response.data;

                $('#id').val(res.data.combo.id);
                $('#name').val(res.data.combo.name);
                $('#price').val(res.data.combo.price);
                $('#quantity').val(res.data.combo.quantity);
                $('#description').summernote('code', res.data.combo.description);
                $('#image-preview').attr('src', 'uploads/combos/' + res.data.combo.image);

                $('#supplier-id').empty();
                $('#book-ids').empty();

                res.data.suppliers.forEach(function(supplier) {
                    var selected = (res.data.combo.supplier_id == supplier.id) ? 'selected' : '';
                    $('#supplier-id').append('<option value="' + supplier.id + '" ' + selected + '>' + supplier.name + '</option>');
                });

                res.data.books.forEach(function(book) {
                    var selected = (res.data.combo.books.map(a => a.id).includes(book.id)) ? 'selected' : '';
                    $('#book-ids').append('<option value="' + book.id + '" ' + selected + '>' + book.name + '</option>');
                });

                $('#modal-title').text('Cập nhật combo');
                $('#modal-store').modal('show');
            } catch (error) {
                handleError(error);
            }
        });

        $('#supplier-id').change(async function() {
            try {
                var supplier_id = $(this).val();

                var response = await axios.get("{{ route('book.get-books-by-supplier', ['supplier_id' => '_supplier_id_']) }}".replace('_supplier_id_', supplier_id));
                var res = response.data;
                var books = res.data;

                $('#book-ids').empty();

                books.forEach(function(book) {
                    $('#book-ids').append('<option value="' + book.id + '">' + book.name + '</option>');
                });
            } catch (error) {
                handleError(error);
            }
        });

        $('#image').change(function(event) {
            var input = event.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#image-preview').attr('src', e.target.result);

                    var formData = new FormData($('#form-store')[0]);
                    formData.set('image', input.files[0]);
                }

                reader.readAsDataURL(input.files[0]);
            }
        });

        $('#btn-store').click(async function() {
            try {
                var formData = new FormData($('#form-store')[0]);
                var response = await axios.post("{{ route('combo.store') }}", formData);
                var res = response.data;

                $('#modal-store').modal('hide');
                $('#form-store').trigger('reset');
                dataTable.draw();
                handleSuccess(res);
            } catch (error) {
                handleError(error);
            }
        });

        $('#data-table').on('click', '.btn-detail', async function() {
            try {
                var id = $(this).data('id');

                var response = await axios.get("{{ route('combo.show', ['id' => '_id_']) }}".replace('_id_', id));
                var res = response.data;

                $('#books-detail').empty();

                var bookTitles = res.data.books.map(books => books.name).join(', ');
                $('#books-detail').text(bookTitles);

                $('#name-detail').text(res.data.name);
                $('#supplier-detail').text(res.data.supplier);
                $('#price-detail').text(res.data.price);
                $('#quantity-detail').text(res.data.quantity);
                $('#description-detail').text(res.data.description);
                $('#image-detail-preview').attr('src', 'uploads/combos/' + res.data.image);
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
                var response = await axios.get("{{ route('combo.destroy', ['id' => '_id_']) }}".replace('_id_', id));
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