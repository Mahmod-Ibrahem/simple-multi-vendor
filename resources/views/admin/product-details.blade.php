@extends('layouts.app')

@section('title', $product->title . ' | أركان الأسرة')

@section('styles')
    .product-page {
    margin-top: 40px;
    padding-bottom: 60px;
    }

    .product-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 50px;
    align-items: start;
    }

    /* Image Gallery */
    .image-gallery {
    display: flex;
    flex-direction: column;
    gap: 15px;
    }

    .main-img {
    width: 100%;
    height: 450px;
    background: #f4f4f4;
    border: 1px solid #e1e8f0;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    }

    .main-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    }

    .thumb-group {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    }

    .thumb {
    height: 80px;
    background: #eee;
    border: 1px solid #ddd;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
    overflow: hidden;
    }

    .thumb:hover {
    border-color: var(--primary);
    opacity: 0.8;
    }

    .thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    }

    /* Info Box */
    .info-box {
    padding: 20px 0;
    }

    .category-tag {
    color: var(--primary);
    font-weight: 700;
    font-size: 0.9rem;
    background: rgba(20, 91, 155, 0.08);
    padding: 4px 14px;
    border-radius: 20px;
    display: inline-block;
    margin-bottom: 10px;
    }

    .product-title {
    font-size: 2.2rem;
    font-weight: 900;
    margin: 10px 0;
    color: var(--dark);
    }

    .price-big {
    font-size: 2rem;
    color: var(--primary);
    font-weight: 900;
    margin-bottom: 20px;
    }

    .detail-item {
    background: #fcfcfc;
    padding: 15px;
    border-right: 4px solid var(--primary);
    margin-bottom: 15px;
    border-radius: 8px;
    }

    .detail-item strong {
    display: block;
    color: var(--dark);
    font-size: 0.85rem;
    }

    .btn-whatsapp {
    display: block;
    width: 100%;
    text-align: center;
    margin: 25px 0;
    padding: 14px 0;
    background: #25D366;
    color: white;
    text-decoration: none;
    border-radius: 10px;
    font-weight: bold;
    font-size: 1.05rem;
    font-family: 'Cairo', sans-serif;
    transition: 0.3s;
    }

    .btn-whatsapp:hover {
    background: #128C7E;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(37, 211, 102, 0.25);
    }

    .form-whatsapp {
    margin: 25px 0;
    }

    .stats-badget {
    display: inline-flex;
    gap: 15px;
    margin-bottom: 20px;
    font-size: 0.85rem;
    color: #666;
    }
    .stats-badget span {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    }

    .seller-card {
    margin-top: 30px;
    padding: 20px;
    border: 1px solid #e1e8f0;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 15px;
    }

    .seller-avatar {
    width: 60px;
    height: 60px;
    background: #ddd;
    border-radius: 50%;
    overflow: hidden;
    }

    .seller-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    }

    .btn-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #888;
    text-decoration: none;
    font-weight: 700;
    margin-bottom: 25px;
    transition: 0.3s;
    }

    .btn-back:hover {
    color: var(--primary);
    }

    @media (max-width: 768px) {
    .product-container {
    grid-template-columns: 1fr;
    }
    }
@endsection

@section('content')
    <main class="product-page container">
        <a href="{{ route('home') }}" class="btn-back">→ العودة للمتجر</a>

        <div class="product-container">

            {{-- Image Gallery --}}
            <div class="image-gallery">
                <div class="main-img" id="mainImage">
                    @if($product->main_image)
                        <img src="{{ $product->main_image }}" alt="{{ $product->title }}">
                    @else
                        <div style="font-size: 4rem; color: #ddd;">📷</div>
                    @endif
                </div>

                @if($product->images && count($product->images) > 0)
                    <div class="thumb-group">
                        @foreach($product->images as $image)
                            <div class="thumb">
                                <img src="{{ $image['url'] ?? $image }}" alt="{{ $product->title }}">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Product Info --}}
            <div class="info-box">
                @if($product->category)
                    <span class="category-tag">{{ $product->category->title }}</span>
                @endif

                <h1 class="product-title">{{ $product->title }}</h1>
                <div class="stats-badget">
                    <span title="عدد مشاهدات الصفحة">👁️ {{ $product->visits_count ?? 0 }} مشاهدة</span>
                    <span title="عدد نقرات التواصل عبر واتساب">💬 {{ $product->whatsapp_clicks_count ?? 0 }} تواصل</span>
                </div>
                <div class="price-big">{{ number_format($product->price, 0) }} ر.س</div>

                @if($product->description)
                    <p style="color: #666; margin-bottom: 30px; line-height: 1.8;">{{ $product->description }}</p>
                @endif

                @if($product->locations)
                    <div class="detail-item">
                        <strong>📍 الموقع (المنطقة والحي):</strong>
                        <span>{{ $product->locations }}</span>
                    </div>
                @endif

                <div class="detail-item">
                    <strong>💳 طريقة الدفع المتاحة:</strong>
                    <span>تحويل بنكي / نقدي عند الاستلام</span>
                </div>

                @if($product->user && $product->user->phone)
                    <form action="{{ route('products.track-whatsapp', $product) }}" method="POST" class="form-whatsapp" target="_blank">
                        @csrf
                        <button type="submit" class="btn-whatsapp" style="border: none; cursor: pointer; width: 100%;">
                            تواصل مع البائع عبر واتساب
                        </button>
                    </form>
                @endif

                @if($product->user)
                    <div class="seller-card">
                        <a href="{{ route('users.products', $product->user) }}" class="seller-avatar" style="display: block; text-decoration: none;">
                            @if($product->user->logo)
                                <img src="{{ $product->user->logo }}" alt="{{ $product->user->name }}">
                            @else
                                <div style="width: 100%; height: 100%; background: #145b9b; color: white; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 700;">
                                    {{ mb_substr($product->user->name, 0, 1) }}
                                </div>
                            @endif
                        </a>
                        <div>
                            <a href="{{ route('users.products', $product->user) }}" style="font-weight: bold; color: var(--dark); text-decoration: none; display: inline-block; margin-bottom: 5px; transition: 0.3s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--dark)'">
                                {{ $product->user->name }}
                            </a>
                            @if($product->user->brief_description)
                                <div style="color: #888; font-size: 0.85rem;">{{ $product->user->brief_description }}</div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </main>
@endsection