@include('layouts.header')
@include('layouts.sidebar')

<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </section>
</div>

@include('layouts.footer')