@extends('layouts.app')

@section('title', 'الرئيسية | أركان الأسرة')

@section('styles')
    /* Hero Section */
    .shop-hero {
    background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
    url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
    background-size: cover;
    background-position: center;
    padding: 180px 0 120px;
    text-align: center;
    color: var(--white);
    margin-bottom: 50px;
    }

    .shop-hero h1 {
    font-size: 3.5rem;
    margin-bottom: 15px;
    font-weight: 900;
    }

    .shop-hero p {
    font-size: 1.2rem;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto 30px;
    }

    .btn-hero {
    background: var(--primary);
    color: var(--white);
    padding: 12px 30px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: bold;
    font-size: 1.1rem;
    transition: 0.3s;
    display: inline-block;
    }

    .btn-hero:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(223, 127, 17, 0.3);
    }

    /* Filter Bar */
    .filter-bar {
    background: var(--white);
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
    margin-bottom: 50px;
    border: 1px solid #f0f0f0;
    }

    .filter-form {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    width: 100%;
    }

    .filter-group {
    display: flex;
    align-items: flex-end;
    gap: 25px;
    flex-wrap: wrap;
    }

    .filter-item label {
    font-weight: 700;
    margin-left: 10px;
    color: #555;
    }

    .filter-select {
    padding: 12px 20px;
    font-family: 'Cairo', sans-serif;
    border: 1.5px solid #e1e8f0;
    background: #fdfdfd;
    color: var(--dark);
    outline: none;
    cursor: pointer;
    border-radius: 8px;
    transition: all 0.3s ease;
    min-width: 180px;
    font-size: 0.95rem;
    }

    .filter-select:focus {
    border-color: var(--primary);
    background: var(--white);
    box-shadow: 0 0 0 3px rgba(223, 127, 17, 0.1);
    }

    .btn-search {
    background: var(--dark);
    color: var(--white);
    padding: 12px 25px;
    border-radius: 8px;
    border: none;
    font-weight: 700;
    font-family: 'Cairo', sans-serif;
    cursor: pointer;
    transition: 0.3s;
    display: flex;
    align-items: center;
    gap: 8px;
    }

    .btn-search:hover {
    background: var(--primary);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(223, 127, 17, 0.2);
    }

    /* Products Grid */
    .products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 30px;
    margin-bottom: 80px;
    }

    .product-card {
    background: var(--white);
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid #eee;
    transition: 0.4s;
    display: flex;
    flex-direction: column;
    position: relative;
    }

    .product-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
    border-color: transparent;
    }

    .product-card-link {
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    }

    .product-image {
    width: 100%;
    height: 260px;
    background: #f4f4f4;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
    }

    .product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: 0.5s;
    }

    .product-card:hover .product-image img {
    transform: scale(1.05);
    }

    .product-details {
    padding: 25px;
    text-align: right;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    }

    .product-details h3 {
    font-size: 1.1rem;
    font-weight: 800;
    margin: 0 0 10px;
    color: var(--dark);
    }

    .product-price {
    color: var(--primary);
    font-weight: 900;
    font-size: 1.3rem;
    margin: 5px 0 15px;
    }

    .product-desc {
    font-size: 0.9rem;
    color: #777;
    margin-bottom: 20px;
    line-height: 1.6;
    flex-grow: 1;
    }

    .btn-view {
    display: block;
    text-align: center;
    padding: 12px;
    border: 2px solid var(--primary);
    color: var(--primary);
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    transition: 0.3s;
    }

    .btn-view:hover,
    .product-card:hover .btn-view {
    background: var(--primary);
    color: var(--white);
    }

    .empty-state {
    text-align: center;
    padding: 80px 20px;
    color: #999;
    grid-column: 1 / -1;
    }

    .empty-state .emoji {
    font-size: 4rem;
    margin-bottom: 15px;
    }
@endsection

@section('content')
    <header class="shop-hero">
        <div class="container">
            <h1>إبداعات الأسر المنتجة</h1>
            <p>منصة تجمع إبداعات وحرف الأسر المنتجة في مكان واحد بجودة عالية وأسعار منافسة.</p>
            <a href="#products" class="btn-hero">تصفح المنتجات</a>
        </div>
    </header>

    <div class="container" id="products">

        <div class="filter-bar">
            <form action="{{ route('home') }}" method="GET" class="filter-form">
                <div class="filter-group">
                    <div class="filter-item">
                        <label>تصفية حسب الصنف:</label>
                        <select class="filter-select" name="category">
                            <option value="all">كل الأقسام</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-item">
                        <label>ترتيب العرض:</label>
                        <select class="filter-select" name="sort">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>الأحدث إضافة</option>
                            <option value="low-price" {{ request('sort') == 'low-price' ? 'selected' : '' }}>الأقل سعراً
                            </option>
                            <option value="high-price" {{ request('sort') == 'high-price' ? 'selected' : '' }}>الأعلى سعراً
                            </option>
                        </select>
                    </div>

                    <button type="submit" class="btn-search">
                        <span>🔍</span>
                        بحث
                    </button>
                </div>

                <div style="color: #666; font-weight: 600;">استمتع بالتسوق معنا</div>
            </form>
        </div>

        <div class="products-grid">
            @forelse($products as $product)
                @include('components.product-card', ['product' => $product])
            @empty
                <div class="empty-state">
                    <div class="emoji">🛒</div>
                    <h3>لا توجد منتجات حالياً</h3>
                    <p>سيتم إضافة منتجات جديدة قريباً</p>
                </div>
            @endforelse
        </div>

        <div class="pagination-container">
            {{ $products->links() }}
        </div>

    </div>
@endsection