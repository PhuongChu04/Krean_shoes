@extends('client.layout.layout')

@section('content')

<div class="flat-spacing-13">
    <div class="container-7">
        <div class="btn-sidebar-mb d-lg-none">
            <button data-bs-toggle="offcanvas" data-bs-target="#mbAccount">
                <i class="icon icon-sidebar"></i>
            </button>
        </div>

        <div class="main-content-account">
            @include('client.layout.sidebar')

            <div class="my-acount-content account-dashboard">
                <h6 class="display-xs title-form">Sản phẩm yêu thích</h6>

                <div class="wrapper-shop tf-grid-layout tf-col-4">
                    @if($products->count())
                        @include('client.shop.partials.product_grid')
                    @else
                        <div class="col-12 text-center py-5 w-100">
                            <div class="mb-3">
                                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 12H5" />
                                    <path d="M12 5l-7 7 7 7" />
                                </svg>
                            </div>
                            <h5 class="text-secondary">Bạn chưa có sản phẩm yêu thích nào.</h5>
                            <p class="text-muted mt-2">Hãy thêm sản phẩm vào wishlist để xem lại sau.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
