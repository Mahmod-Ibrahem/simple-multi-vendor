{{-- Alert Component --}}
{{-- Usage: @include('components.alert') --}}

@if (session('success'))
    <div class="alert alert-success">
        <span class="alert-icon">✅</span>
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-error">
        <span class="alert-icon">⚠️</span>
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-error">
        <ul style="list-style: none; padding: 0; margin: 0;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif