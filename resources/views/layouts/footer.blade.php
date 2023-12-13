<footer class="main-footer">
    <strong>Footer</strong>
    <div class="float-right d-none d-sm-inline-block">
        <b>2023</b>
    </div>
</footer>

<aside class="control-sidebar control-sidebar-dark">
</aside>

</div>

<div class="modal fade" id="modal-logout">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Xác nhận đăng xuất</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group">
                        <p class="h4">Bạn có chắc chắn muốn đăng xuất?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fas fa-times-circle"></i>
                    Huỷ
                </button>
                <a href="{{ route('logout') }}" type="button" id="btn-logout" class="btn btn-danger">
                    <i class="fas fa-sign-out-alt"></i>
                    Đăng xuất
                </a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Xác nhận xoá</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group">
                        <p id="modal-message" class="h4">Bạn có chắc chắn muốn xoá?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fas fa-times-circle"></i>
                    Huỷ
                </button>
                <button type="button" id="btn-confirm-delete" class="btn btn-danger">
                    <i class="fas fa-trash-alt"></i>
                    Xoá
                </button>
            </div>
        </div>
    </div>
</div>

@include('layouts.script')

@yield('page-js')
</body>

</html>