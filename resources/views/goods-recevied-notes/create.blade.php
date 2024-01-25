@extends('master')

@section('content')
<div class="row my-4">
    <div class="col-9">
        <h1 class="m-0">Thêm hoá đơn nhập</h1>
    </div>
    <div class="col-3 text-right">
        <a type="button" href="{{ route('goods-recevied-note.index') }}" class="btn btn-success mt-2">
            <i class="fas fa-bars"></i>
            Danh sách hoá đơn nhập
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Thông tin hoá đơn nhập</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Nhân viên lập:</label>
                    <input type="text" value="{{ Auth::user()->name }}" class="form-control" style="background-color: #fff; color: #000;" readonly>
                </div>
                <div class="form-group">
                    <label for="supplier">Nhà cung cấp: </label>
                    <select name="supplier" id="supplier" class="form-control select2" style="width: 100%;" required>
                        <option value="" selected disabled>-- Chọn nhà cung cấp --</option>
                        @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback supplier-error"></div>
                </div>
                <div class="form-group">
                    <label for="total">Tổng tiền:</label>
                    <input type="text" id="total" value="0" class="form-control" style="background-color: #fff; color: #000;" readonly>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Thông tin sản phẩm</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="product">Tên sản phẩm: </label>
                    <select name="product" id="product" class="form-control select2" style="width: 100%;" required>
                        <option value="" selected disabled>-- Chọn sản phẩm --</option>
                        @foreach($books as $book)
                        <option data-book-id="{{ $book->id }}" data-supplier-id="{{ $book->supplier_id }}" data-name="{{ $book->name }}">{{ $book->name }}</option>
                        @endforeach

                        @foreach($combos as $combo)
                        <option data-combo-id="{{ $combo->id }}" data-supplier-id="{{ $combo->supplier_id }}" data-name="{{ $combo->name }}">{{ $combo->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback product-error"></div>
                </div>
                <div class="form-group">
                    <label for="import-price">Giá nhập:</label>
                    <input type="text" id="import-price" class="form-control" placeholder="0">
                    <div class="invalid-feedback import-price-error"></div>
                </div>
                <div class="form-group">
                    <label for="price">Giá bán:</label>
                    <input type="text" id="price" class="form-control" placeholder="0">
                    <div class="invalid-feedback price-error"></div>
                </div>
                <div class="form-group">
                    <label for="quantity">Số lượng:</label>
                    <input type="text" id="quantity" class="form-control" placeholder="0">
                    <div class="invalid-feedback quantity-error"></div>
                </div>
                <div class="text-center">
                    <button type="button" id="btn-add" class="btn btn-sm btn-primary">Thêm</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="product-table" class="card">
    <form id="form-store">
        @csrf
        <div class="card-body">
            <table id="data-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá nhập</th>
                        <th>Giá bán</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <input type="hidden" name="supplier_id" id="supplier-id" />
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <button type="button" id="btn-store" class="btn btn-sm btn-primary mb-3">Lưu</button>
        </div>
    </form>
</div>
@endsection

@section('page-js')
<script>
    $(document).ready(function() {
        $('.select2').select2();

        var supplier_id = 0;
        var total = 0;
        $('#product-table').hide();

        $('#supplier').change(async function() {
            try {
                supplier_id = $(this).val();
                $('#supplier-id').val(supplier_id);
                var selectedProduct = $('#product option:selected').data('name');

                var response = await axios.get("{{ route('book.get-books-by-supplier', ['supplier_id' => '_supplier_id_']) }}".replace('_supplier_id_', supplier_id));
                var bookRes = response.data;

                var response = await axios.get("{{ route('combo.get-combos-by-supplier', ['supplier_id' => '_supplier_id_']) }}".replace('_supplier_id_', supplier_id));
                var comboRes = response.data;

                $('#product').empty();

                bookRes.data.forEach(function(book) {
                    $('#product').append('<option data-book-id="' + book.id + '">' + book.name + '</option>');
                });

                comboRes.data.forEach(function(combo) {
                    $('#product').append('<option data-combo-id="' + combo.id + '">' + combo.name + '</option>');
                });

                if (selectedProduct) {
                    $('#product').val(selectedProduct).trigger('change');
                }
            } catch (error) {
                handleError(error);
            }
        });

        $('#product').change(function() {
            var supplierId = $('#product option:selected').data('supplier-id');

            if (supplierId) {
                $('#supplier').val($('#supplier option:eq("' + supplierId + '")').val()).trigger('change');
            }

            $('#import-price').val('');
            $('#price').val('');
            $('#quantity').val('');
        });

        $('#btn-add').click(function() {
            $('#supplier, #product, #import-price, #price, #quantity').removeClass('is-invalid');
            $('.supplier-error, .product-error, .import-price-error, .price-error, .quantity-error').text('');

            var supplierId = $('#supplier').val();
            var importPrice = $('#import-price').val();
            var price = $('#price').val();
            var quantity = $('#quantity').val();
            var selectedProduct = $('#product').val();
            var hasError = false;

            if (!supplierId) {
                $('#supplier').addClass('is-invalid');
                $('.supplier-error').text('Vui lòng chọn nhà cung cấp.');
                hasError = true;
            }

            if (!selectedProduct) {
                $('#product').addClass('is-invalid');
                $('.product-error').text('Vui lòng chọn sản phẩm.');
                hasError = true;
            }

            if (!importPrice || isNaN(importPrice) || importPrice <= 0) {
                $('#import-price').addClass('is-invalid');
                $('.import-price-error').text('Vui lòng nhập giá nhập hợp lệ.');
                hasError = true;
            }

            if (!price || isNaN(price) || price <= 0) {
                $('#price').addClass('is-invalid');
                $('.price-error').text('Vui lòng nhập giá bán hợp lệ.');
                hasError = true;
            }

            if (!quantity || isNaN(quantity) || quantity <= 0) {
                $('#quantity').addClass('is-invalid');
                $('.quantity-error').text('Vui lòng nhập số lượng hợp lệ.');
                hasError = true;
            }

            if (hasError) {
                return;
            }

            var order = $('#data-table tbody tr').length + 1;
            var bookId = $('#product option:selected').data('book-id');
            var comboId = $('#product option:selected').data('combo-id');
            var name = $('#product').find(':selected').text();
            var importPrice = $('#import-price').val();
            var price = $('#price').val();
            var quantity = $('#quantity').val();
            var amount = parseInt(importPrice) * parseInt(quantity);

            if (checkDuplicate(name)) {
                var existingRow = $('#data-table tbody tr').filter(function() {
                    return $(this).find('.name').text().trim() === name.trim();
                });

                var oldAmount = parseInt(existingRow.find('.amount').text());

                existingRow.find('.import-price').val(importPrice);
                existingRow.find('.price').val(price);
                existingRow.find('.quantity').val(quantity);
                existingRow.find('td:eq(2)').text(importPrice);
                existingRow.find('td:eq(3)').text(price);
                existingRow.find('td:eq(4)').text(quantity);
                existingRow.find('td:eq(5)').text(amount);

                total = total - oldAmount + amount;
            } else {
                var id = bookId ? 'book_id[]' : 'combo_id[]';

                var row = `<tr>
                        <td>${order}</td>
                        <td class="name">${name}<input type="hidden" name="${id}" value="${bookId || comboId}" class="id" /></td>
                        <td class="import-price-container">${importPrice}<input type="hidden" name="import_price[]" value="${importPrice}" class="import-price"/></td>
                        <td class="price-container">${price}<input type="hidden" name="price[]" value="${price}" class="price"/></td>
                        <td class="quantity-container">${quantity}<input type="hidden" name="quantity[]" value="${quantity}" class="quantity"/></td>
                        <td class="amount">${amount}</td>
                        <td class="text-right"><button type="button" class="btn btn-sm btn-info btn-edit"><i class="fas fa-edit"></i> Cập nhật</button>
                        <button type="button" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash-alt"></i> Xoá</button></td>
                    </tr>`;

                if (comboId) {
                    row += `<input type="hidden" name="book_id[]">`;
                }

                if (bookId) {
                    row += `<input type="hidden" name="combo_id[]">`;
                }

                $('#product-table').show();
                $('#data-table').append(row);

                total += amount;
            }

            $('#total').val(total);
            $('#product').val($('#product option:first').val()).trigger('change');
            $('#import-price').val('');
            $('#price').val('');
            $('#quantity').val('');
        });

        $('#data-table').on('click', '.btn-delete', function() {
            var row = $(this).closest('tr');
            var deletedAmount = parseInt(row.find('.amount').text());

            row.remove();

            total -= deletedAmount;

            $('#total').val(total);

            $('#data-table tbody tr').each(function(index) {
                $(this).find('td:first').text(index + 1);
            });

            if ($('#data-table tbody tr').length == 0) {
                $('#product-table').hide();
            }
        });

        $('#btn-store').click(async function(event) {
            try {
                var formData = new FormData($('#form-store')[0]);

                formData.append('supplier_id', supplier_id);

                var response = await axios.post("{{ route('goods-recevied-note.store') }}", formData);
                var res = response.data;

                total = 0;

                $('#total').val(total);

                $('#data-table tbody').empty();
                $('#product-table').hide();

                $('#supplier').val($('#supplier option:eq(1)').val()).trigger('change');
                $('#product').val($('#product option:first').val()).trigger('change');

                handleSuccess(res);
            } catch (error) {
                handleError(error);
            }
        });

        $('#supplier').change(function() {
            if ($('#data-table tbody tr').length > 0) {
                $('#modal-message').text('Chọn nhà cung cấp mới sẽ xoá danh sách hiện tại. Bạn có chắc chắc muốn xoá?');
                $('#modal-delete').modal('show');
            }
        });

        $('#btn-confirm-delete').click(function() {
            $('#supplier').trigger('change');

            $('#total').val(0);

            $('#import-price').val('');
            $('#price').val('');
            $('#quantity').val('');

            $('#data-table tbody').empty();
            $('#product-table').hide();
            $('#modal-delete').modal('hide');
        });

        function checkDuplicate(name) {
            var isDuplicate = false;
            $('#data-table tbody tr').each(function() {
                var existingName = $(this).find('.name').text();
                if (existingName.trim() === name.trim()) {
                    isDuplicate = true;
                    return false;
                }
            });
            return isDuplicate;
        }
    });
</script>
@endsection