@extends('client.layout.layout')

@section('content')

    <!-- Title Page -->
    <section class="tf-page-title">
        <div class="container">
            <div class="box-title text-center">
                <h4 class="title">TẤT CẢ SẢN PHẨM</h4>
                <div class="breadcrumb-list">
                    <a class="breadcrumb-item" href="{{ route('client.homeClient') }}">Trang chủ</a>
                    <div class="breadcrumb-item dot"><span></span></div>
                    <div class="breadcrumb-item current">Cửa hàng</div>
                </div>
                <p class="desc text-md text-main">Khám phá bộ sưu tập sản phẩm chất lượng cao của chúng tôi</p>
            </div>
        </div>
    </section>

    <!-- Section Product - Dùng style giống Hot Deals -->
    <section class="flat-spacing-24">
        <div class="container">
            <div class="tf-shop-control mb-4">
                <div class="tf-group-filter">
                    <!-- Bộ lọc sẽ giữ nguyên hoặc anh có thể tinh chỉnh sau -->
                    <div class="tf-dropdown-sort" data-bs-toggle="dropdown">
                        <div class="btn-select">
                            <span class="text-sort-value">Mới nhất</span>
                            <span class="icon icon-arr-down"></span>
                        </div>
                        <div class="dropdown-menu">
                            <div class="select-item active" data-sort-value="newest">Mới nhất</div>
                            <div class="select-item" data-sort-value="price-low-high">Giá: Thấp đến Cao</div>
                            <div class="select-item" data-sort-value="price-high-low">Giá: Cao đến Thấp</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danh sách sản phẩm - Dùng cùng style với Hot Deals -->
            <div class="row">
                @forelse($products as $product)
                    @php
                        $firstVariant = $product->variants->sortBy('price')->first() ?? null;

                        $mainImage = $product->thumbnail 
                            ? Storage::url($product->thumbnail) 
                            : ($firstVariant && $firstVariant->images->first() 
                                ? Storage::url($firstVariant->images->first()->image) 
                                : asset('images/default-product.jpg'));

                        $hoverImage = $firstVariant && $firstVariant->images->count() > 1 
                            ? Storage::url($firstVariant->images->skip(1)->first()->image) 
                            : $mainImage;

                        $minPrice = $product->variants->min('price') ?? 0;
                        $oldPrice = $minPrice * 1.25; 
                        $salePercent = $oldPrice > $minPrice ? round((($oldPrice - $minPrice) / $oldPrice) * 100) : 0;
                        $available = $firstVariant ? $firstVariant->stock : 0;
                    @endphp

                    <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4">
                        <div class="card-product style-center" 
                             data-product-id="{{ $product->id }}"
                             data-variants="{{ json_encode($product->variants->map(fn($v) => [
                                 'id' => $v->id,
                                 'size_id' => $v->size_id,
                                 'size_name' => $v->size?->name ?? '',
                                 'color_id' => $v->color_id,
                                 'color_name' => $v->color?->name ?? '',
                                 'color_code' => $v->color?->code ?? '#000',
                                 'price' => $v->price,
                                 'stock' => $v->stock ?? 0,
                             ])) }}">

                            <div class="card-product-wrapper">
                                <a href="{{ route('client.product.detail', $product->slug ?? $product->id) }}" class="product-img">
                                    <img class="img-product lazyload" 
                                         data-src="{{ $mainImage }}" 
                                         src="{{ $mainImage }}" 
                                         alt="{{ $product->name }}">

                                    <img class="img-hover lazyload" 
                                         data-src="{{ $hoverImage }}" 
                                         src="{{ $hoverImage }}" 
                                         alt="{{ $product->name }}">
                                </a>

                                @if($salePercent > 0)
                                    <div class="on-sale-wrap">
                                        <span class="on-sale-item">{{ $salePercent }}% Off</span>
                                    </div>
                                @endif

                                <ul class="list-product-btn">
                                    <li>
                                        <a href="javascript:void(0);" data-add-to-cart 
                                           class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-cart2"></span>
                                            <span class="tooltip">Thêm vào giỏ hàng</span>
                                        </a>
                                    </li>
                                    <li class="wishlist">
                                        <a href="javascript:void(0);" class="bg-surface hover-tooltip tooltip-left box-icon">
                                            <span class="icon icon-heart2"></span>
                                            <span class="tooltip">Yêu thích</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="card-product-info text-center">
                                <a href="{{ route('client.product.detail', $product->slug ?? $product->id) }}" 
                                   class="name-product link fw-medium text-md">
                                    {{ Str::limit($product->name, 45) }}
                                </a>

                                <p class="price-wrap fw-medium">
                                    <span class="price-new">{{ number_format($minPrice) }} ₫</span>
                                    @if($oldPrice > $minPrice)
                                        <span class="price-old old-line">{{ number_format($oldPrice) }} ₫</span>
                                    @endif
                                </p>

                                <!-- Màu sắc -->
                                <ul class="list-color-product justify-content-center">
                                    @foreach($product->variants->unique('color_id')->take(4) as $variant)
                                        <li class="list-color-item color-swatch hover-tooltip tooltip-bot {{ $loop->first ? 'active' : '' }}">
                                            <span class="tooltip">{{ $variant->color?->name ?? 'Color' }}</span>
                                            <span class="swatch-value" 
                                                  style="background-color: {{ $variant->color?->code ?? '#000' }};"></span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Không tìm thấy sản phẩm nào.</p>
                    </div>
                @endforelse
            </div>

            <!-- Phân trang -->
            <div class="pagination-wrapper mt-5">
                {{ $products->links() }}
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    // Reuse script add to cart từ homeClient nếu anh đã có
    // Hoặc anh có thể copy phần script add to cart từ homeClient vào đây
</script>
@endpush