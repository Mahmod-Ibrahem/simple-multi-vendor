<div class="product-card">
    <a href="{{ route('products.show', $product->slug) }}" class="product-card-link">
        <div class="product-image">
            @if($product->main_image)
                <img src="{{ $product->main_image }}" alt="{{ $product->title }}">
            @else
                <div style="font-size: 3rem; color: #ddd;">📷</div>
            @endif
        </div>
        <div class="product-details">
            <h3>{{ $product->title }}</h3>
            <div class="product-price">{{ number_format($product->price, 0) }} ر.س</div>
            <p class="product-desc">{{ Str::limit($product->description, 80) }}</p>
            <span class="btn-view">عرض التفاصيل</span>
        </div>
    </a>
</div>