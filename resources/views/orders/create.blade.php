@extends('master')

@section('content')
<div class="row my-4">
    <div class="col-9">
        <h1 class="m-0">Thêm hoá đơn</h1>
    </div>
    <div class="col-3 text-right">
        <a type="button" href="{{ route('order.index') }}" class="btn btn-success mt-2">
            <i class="fas fa-bars"></i>
            Danh sách hoá đơn
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Thông tin hoá đơn</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Nhân viên lập:</label>
                    <input type="text" value="{{ Auth::user()->name }}" class="form-control" style="background-color: #fff; color: #000;" readonly>
                </div>
                <div class="form-group">
                    <label for="name">Tên khách hàng:</label>
                    <input type="text" name="customer_name" id="customer-name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại:</label>
                    <input type="text" name="customer_phone" id="customer-phone" class="form-control">
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
                        <option value="{{ $book->id }}" data-book-id="{{ $book->id }}" data-price="{{ $book->price }}">{{ $book->name }}</option>
                        @endforeach

                        @foreach($combos as $combo)
                        <option value="{{ $combo->id }}" data-combo-id="{{ $combo->id }}" data-price="{{ $combo->price }}">{{ $combo->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="price">Giá bán:</label>
                    <input type="text" id="price" class="form-control" placeholder="0" style="background-color: #fff; color: #000;" readonly>
                </div>
                <div class="form-group">
                    <label for="quantity">Số lượng:</label>
                    <input type="text" id="quantity" class="form-control" placeholder="0">
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
                        <th>Giá bán</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <input type="hidden" name="name" id="name" />
                    <input type="hidden" name="phone" id="phone" />
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

        var total = 0;
        $('#product-table').hide();

        $('#customer-name').change(function() {
            $('#name').val(this.value);
        })

        $('#customer-phone').change(function() {
            $('#phone').val(this.value);
        })

        $('#product').change(function() {
            var price = $('#product option:selected').data('price');
            $('#price').val(price);
            $('#quantity').val('');
        })

        $('#btn-add').click(function() {
            var order = $('#data-table tbody tr').length + 1;
            var bookId = $('#product option:selected').data('book-id');
            var comboId = $('#product option:selected').data('combo-id');
            var name = $('#product').find(':selected').text();
            var price = $('#price').val();
            var quantity = $('#quantity').val();
            var amount = parseInt(price) * parseInt(quantity);

            if (checkDuplicate(name)) {
                var existingRow = $('#data-table tbody tr').filter(function() {
                    return $(this).find('.name').text().trim() === name.trim();
                });

                var oldAmount = parseInt(existingRow.find('.amount').text());

                existingRow.find('.price').val(price);
                existingRow.find('.quantity').val(quantity);
                existingRow.find('td:eq(2)').text(price);
                existingRow.find('td:eq(3)').text(quantity);
                existingRow.find('td:eq(4)').text(amount);

                total = total - oldAmount + amount;
            } else {
                var id = bookId ? 'book_id[]' : 'combo_id[]';

                var row = `<tr>
                    <td>${order}</td>
                    <td class="name">${name}<input type="hidden" name="${id}" value="${bookId || comboId}" class="id"/></td>
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
                var response = await axios.post("{{ route('order.store') }}", formData);
                var res = response.data;

                total = 0;

                $('#total').val(total);

                $('#data-table tbody').empty();
                $('#product-table').hide();

                $('#product').val($('#product option:first').val()).trigger('change');
                $('#price').val('');
                $('#quantity').val('');

                handleSuccess(res);
            } catch (error) {
                handleError(error);
            }
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