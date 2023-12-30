<div>
    @if ($customer->name)
    <h2>Xin chào: {{ $customer->name }}</h2>
    @endif
    <h2>Mật khẩu mới của bạn là: <span style="color: red;">{{ $newPassword }}</span></h2>
    <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla quis laudantium eos obcaecati amet repellat architecto qui perferendis quo soluta, vel eveniet alias reprehenderit, voluptatem accusamus vitae, odio illo deleniti.
    </p>
</div>