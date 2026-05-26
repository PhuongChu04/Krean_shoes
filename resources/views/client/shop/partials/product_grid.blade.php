@forelse ($products as $product)
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

        <div class="card-product style-center" data-product-id="{{ $product->id }}"
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
                    <img class="img-product lazyload" data-src="{{ $mainImage }}" 
                         src="{{ $mainImage }}" alt="{{ $product->name }}">

                    <img class="img-hover lazyload" data-src="{{ $hoverImage }}" 
                         src="{{ $hoverImage }}" alt="{{ $product->name }}">
                </a>

                {{-- @if ($salePercent > 0)
                    <div class="on-sale-wrap">
                        <span class="on-sale-item">{{ $salePercent }}% Off</span>
                    </div>
                @endif --}}

                <ul class="list-product-btn">
                   

                    <li class="wishlist">
                        <form action="{{ route('client.wishlist.store', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="bg-surface hover-tooltip tooltip-left box-icon btn btn-link p-0 border-0 bg-transparent text-danger">
                                <span class="icon icon-heart2"></span>
                                <span class="tooltip">Yêu thích</span>
                            </button>
                        </form>
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
                    @if ($oldPrice > $minPrice)
                        <span class="price-old old-line">{{ number_format($oldPrice) }} ₫</span>
                    @endif
                </p>

                <ul class="list-color-product justify-content-center">
                    @foreach ($product->variants->unique('color_id')->take(3) as $variant)
                        <li class="list-color-item color-swatch hover-tooltip tooltip-bot {{ $loop->first ? 'active' : '' }}">
                            <span class="tooltip">{{ $variant->color?->name ?? 'Color' }}</span>
                            <span class="swatch-value" style="background-color: {{ $variant->color?->code ?? '#000' }};"></span>
                        </li>
                    @endforeach
                </ul>

                <div class="product-progress-sale mt-2">
                    <p class="text-avaiable text-sm">
                        Còn lại: 
                        <span class="fw-medium {{ $available > 10 ? 'text-success' : 'text-danger' }}">
                            {{ $available }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted fs-5">Không tìm thấy sản phẩm phù hợp với bộ lọc hiện tại.</p>
        </div>
    @endforelse