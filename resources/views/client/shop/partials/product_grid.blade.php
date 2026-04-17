@forelse ($products as $product)
    <div class="card-product grid card-product-size"
        data-availability="{{ $product->status == 1 ? 'In stock' : 'Out of stock' }}"
        data-brand="{{ $product->brand?->name ?? 'Vineta' }}"
        data-product-id="{{ $product->id }}"
        data-variants="{{ json_encode($product->variants->map(function($v) { 
            return [
                'id' => $v->id, 
                'size_id' => $v->size_id, 
                'size_name' => $v->size?->name, 
                'color_id' => $v->color_id, 
                'color_name' => $v->color?->name, 
                'color_code' => $v->color?->code, 
                'price' => $v->price, 
                'stock' => $v->stock
            ]; 
        })->values()) }}">
        
        <div class="card-product-wrapper">
            <a href="{{ route('client.product.detail', $product->slug ?? $product->id) }}" class="product-img">
                <img class="img-product lazyload"
                    data-src="{{ asset('storage/' . $product->thumbnail) }}"
                    src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}">
                <img class="img-hover lazyload"
                    data-src="{{ asset('storage/' . $product->thumbnail) }}"
                    src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}">
            </a>
            
            <div class="on-sale-wrap"><span class="on-sale-item">20% Off</span></div>
            
            <ul class="list-product-btn">
                <li>
                    <a href="javascript:void(0);" data-add-to-cart class="hover-tooltip tooltip-left box-icon">
                        <span class="icon icon-cart2"></span>
                        <span class="tooltip">Thêm vào giỏ hàng</span>
                    </a>
                </li>
                <li class="wishlist">
                    <a href="javascript:void(0);" class="hover-tooltip tooltip-left box-icon">
                        <span class="icon icon-heart2"></span>
                        <span class="tooltip">Yêu thích</span>
                    </a>
                </li>
                <li>
                    <a href="#quickView" data-bs-toggle="modal" class="hover-tooltip tooltip-left box-icon quickview">
                        <span class="icon icon-view"></span>
                        <span class="tooltip">Xem nhanh</span>
                    </a>
                </li>
                <li class="compare">
                    <a href="#compare" data-bs-toggle="modal" aria-controls="compare" class="hover-tooltip tooltip-left box-icon">
                        <span class="icon icon-compare"></span>
                        <span class="tooltip">So sánh</span>
                    </a>
                </li>
            </ul>
            
            <ul class="size-box">
                @foreach ($product->variants->unique('size_id') as $variant)
                    <li class="size-item text-xs text-white">
                        {{ $variant->size?->name }}
                    </li>
                @endforeach
            </ul>
        </div>
        
        <div class="card-product-info">
            <a href="{{ route('client.product.detail', $product->slug ?? $product->id) }}" class="name-product link fw-medium text-md">
                {{ $product->name }}
            </a>
            <p class="price-wrap fw-medium">
                <span class="price-new">{{ number_format($product->variants->min('price'), 0, ',', '.') }} VND</span>
            </p>
            
            <ul class="list-color-product">
                @foreach ($product->variants->unique('color_id') as $variant)
                    <li class="list-color-item hover-tooltip tooltip-bot color-swatch active">
                        <span class="tooltip color-filter">{{ $variant->color?->name }}</span>
                        <span class="swatch-value" style="background-color: {{ $variant->color?->code }}"></span>
                        <img class="lazyload"
                            data-src="{{ asset('storage/' . $product->thumbnail) }}"
                            src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}">
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@empty
    <div class="col-12 text-center py-5 w-100">
        <div class="mb-3">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
        </div>
        <h5 class="text-secondary">Không tìm thấy sản phẩm nào phù hợp với bộ lọc.</h5>
        <p class="text-muted mt-2">Vui lòng thử bỏ bớt các tiêu chí lọc.</p>
    </div>
@endforelse

<div class="col-12 mt-4 d-flex justify-content-center w-100">
    {{ $products->links() }}
</div>