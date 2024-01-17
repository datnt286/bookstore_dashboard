<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('/') }}" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 d-flex">
            <div class="info">
                <a href="{{ route('account') }}" class="d-block">
                    <div class="image mr-1">
                        <img src="{{ asset('uploads/admins/' . auth()->user()->avatar) }}" alt="Ảnh đại diện" class="img-circle elevation-2" style="max-width: 34px; max-height: 34px;">
                    </div>
                    {{ auth()->user()->name }}
                </a>
            </div>
        </div>

        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Tìm kiếm" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('/') }}" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Trang chủ</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-box-open"></i>
                        <p>
                            Quản lý sản phẩm
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-2">
                        <li class="nav-item">
                            <a href="{{ route('book.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>Quản lý sách</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('combo.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-layer-group"></i>
                                <p>Quản lý combo</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('category.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-tag"></i>
                        <p>
                            Quản lý thể loại
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('author.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-pen-nib"></i>
                        <p>
                            Quản lý tác giả
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('publisher.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p>
                            Quản lý nhà xuất bản
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('supplier.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-shipping-fast"></i>
                        <p>
                            Quản lý nhà cung cấp
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Quản lý admin
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('customer.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Quản lý khách hàng
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('goods-recevied-note.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-clipboard"></i>
                        <p>
                            Quản lý hoá đơn nhập
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('order.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-scroll"></i>
                        <p>
                            Quản lý hoá đơn
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('comment.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>
                            Quản lý bình luận
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('slider.index') }}" class="nav-link">
                        <i class="nav-icon fab fa-adversal"></i>
                        <p>
                            Quản lý slider
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>