@php
    // Debug: mostrar quais seções existem
    $pages = App\Models\Page::orderBy('id', 'desc')->get();
    echo "<pre>Debug - Páginas carregadas: " . $pages->count() . "</pre>";
@endphp
@extends($activeTemplate . 'layouts.frontend')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Debug - Testando seções</h1>

                @if ($sections->secs != null)
                    <h3>Seções encontradas:</h3>
                    <ul>
                        @foreach (json_decode($sections->secs) as $sec)
                            <li>{{ $sec }}</li>
                        @endforeach
                    </ul>

                    <hr>
                    <h3>Carregando seções:</h3>

                    @foreach (json_decode($sections->secs) as $sec)
                        <div style="border: 1px solid #ccc; margin: 10px; padding: 10px;">
                            <strong>Carregando seção: {{ $sec }}</strong>
                            @php
                                try {
                                    echo '<span style="color: green;">✅ Tentando carregar...</span><br>';
                            @endphp
                            @include($activeTemplate . 'sections.' . $sec)
                            @php
                                    echo '<span style="color: green;">✅ OK - Carregado com sucesso</span>';
                                } catch (Exception $e) {
                                    echo '<span style="color: red;">❌ ERRO: ' . $e->getMessage() . '</span>';
                                }
                            @endphp
                        </div>
                    @endforeach
                @else
                    <p>Nenhuma seção encontrada em $sections->secs</p>
                @endif
            </div>
        </div>
    </div>

@endsection