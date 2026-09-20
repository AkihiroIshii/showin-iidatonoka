<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            格言
        </h2>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/katex.min.css">
        <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/katex.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/contrib/auto-render.min.js"
            onload="renderMathInElement(document.body);"></script>
    </x-slot>
    <div class="mx-auto p-6">
        <div class="mx-auto px-6">

            <div class="relative">
                <!-- 単元一覧画面へ -->
                <a href="{{route('dashboard')}}" class="text-blue-600 font-bold">ダッシュボードへ</a>

                <div class="text-center">
                    <form method="GET" action="{{ route('kakugen.reshow') }}" class="inline-block">
                        <button type="submit" class="inline-block p-2 rounded shadow bg-blue-200 font-bold">
                            次の格言
                        </button>
                    </form>
                </div>
                <div class="w-2/3 mx-auto text-center">
                    <p class="m-4 font-klee">{{ $kakugen->sentence }}（{{ $kakugen->person }}）</p>
                    <p class="text-right">出典：{{ $kakugen->reference }}</p>
                    <p>{{ $kakugen->comment }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>