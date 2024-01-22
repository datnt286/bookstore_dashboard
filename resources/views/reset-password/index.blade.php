<div>
    @if ($customer->name)
    <h2>Xin chào: {{ $customer->name }}</h2>
    @endif
    <h2>Mật khẩu mới của bạn là: <span style="color: red;">{{ $newPassword }}</span></h2>
    <p>
        Vui lòng đăng nhập với mật khẩu mới sau đó đổi mật khẩu.
    </p>
</div>