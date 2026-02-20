@extends('layouts.app')

@section('title', 'منتجات الأسرة: ' . $user->name . ' | أركان الأسرة')

@section('content')
    <main class="main-content" style="padding: 40px 0; background-color: #f4f7f9; min-height: 80vh;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 15px;">

            {{-- User Header Info --}}
            <div
                style="background: white; border-radius: 12px; padding: 30px; margin-bottom: 30px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e1e8f0;">
                @if($user->logo)
                    <img src="{{ $user->logo }}" alt="{{ $user->name }}"
                        style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 15px; border: 3px solid #145b9b;">
                @else
                    <div
                        style="width: 100px; height: 100px; border-radius: 50%; background: #145b9b; color: white; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: 700; margin: 0 auto 15px;">
                        {{ mb_substr($user->name, 0, 1) }}
                    </div>
                @endif
                <h1 style="font-size: 1.8rem; font-weight: 800; color: #1a1a1a; margin-bottom: 10px;">{{ $user->name }}</h1>
                @if($user->brief_description)
                    <p style="color: #666; font-size: 1.1rem; max-width: 600px; margin: 0 auto;">{{ $user->brief_description }}
                    </p>
                @endif
            </div>

            {{-- Products Grid --}}
            <div
                style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px; margin-bottom: 40px;">
                @forelse($products as $product)
                    <div
                        style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e1e8f0; transition: transform 0.3s; display: flex; flex-direction: column;">
                        <a href="{{ route('products.show', $product) }}"
                            style="display: block; position: relative; padding-top: 75%;">
                            <img src="{{ $product->main_image }}" alt="{{ $product->title }}"
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                        </a>
                        <div style="padding: 20px; text-align: center; display: flex; flex-direction: column; flex-grow: 1;">
                            <h3 style="font-size: 1.2rem; font-weight: 700; color: #1a1a1a; margin-bottom: 10px;">
                                {{ $product->title }}
                            </h3>
                            <p
                                style="color: #145b9b; font-weight: 900; font-size: 1.3rem; margin-top: auto; margin-bottom: 15px;">
                                {{ number_format($product->price, 2) }} ر.س
                            </p>
                            <a href="{{ route('products.show', $product) }}"
                                style="display: inline-block; background: transparent; border: 1.5px solid #145b9b; color: #145b9b; padding: 10px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; transition: 0.3s;">عرض
                                التفاصيل</a>
                        </div>
                    </div>
                @empty
                    <div
                        style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: white; border-radius: 12px; border: 1px solid #e1e8f0;">
                        <div style="font-size: 3rem; margin-bottom: 15px;">🛒</div>
                        <h3 style="font-size: 1.3rem; color: #666;">لا توجد منتجات متاحة حالياً لهذه الأسرة</h3>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div>
                {{ $products->links() }}
            </div>
        </div>
    </main>
@endsection