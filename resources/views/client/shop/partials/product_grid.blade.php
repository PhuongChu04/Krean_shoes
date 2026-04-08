@forelse ($products as $product)
    <div class="card-product grid card-product-size" 
         data-availability="{{ $product->status == 1 ? 'In stock' : 'Out of stock' }}" 
         data-product-id="{{ $product->id }}" 
         data-variants="{{ json_encode($product->variants) }}">
        
        <div class="card-product-wrapper">
            <a href="#" class="product-img">
                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" style="max-width: 100%; height: auto;">
            </a>
            
            <div class="list-product-btn">
                <a href="#" class="box-icon bg_white quick-add tf-btn-loading" data-add-to-cart>
                    <span class="icon icon-bag"></span> Thêm giỏ hàng
                </a>
            </div>
        </div>

        <div class="card-product-info" style="padding-top: 10px;">
            <a href="#" class="title link fw-bold">{{ $product->name }}</a>
            
            <div class="price mt-1 text-danger">
                {{ number_format($product->variants->min('price'), 0, ',', '.') }} VNĐ
            </div>
        </div>
        
    </div>
@empty
    <div class="col-12 text-center py-5">
        <p>Không tìm thấy sản phẩm nào phù hợp với bộ lọc.</p>
    </div>
@endforelse

<div class="col-12 mt-4 d-flex justify-content-center">
    {{ $products->links() }}
</div>