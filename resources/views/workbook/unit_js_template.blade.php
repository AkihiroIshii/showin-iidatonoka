<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            単元別学習 {{ $unitname }}
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
                <a href="{{route('workbook.unitbasedlist')}}" class="text-blue-600 font-bold">単元一覧画面へ</a>
            </div>

            <div class="w-5/6 mx-auto">
                <div class="text-center mt-4 mb-4">
                    <div class="inline-block text-left leading-[2] font-klee text-lg mt-4">
                        {!! $sentence !!}
                    </div>
                </div>
                <div class="flex flex-wrap gap-4 mb-4">
                    <x-button-link>
                        <input type="button" id="display-button" value="表示">
                    </x-button-link>
                </div>
                <div id="result" class="horizontal-scroll"></div>
            </div>
        </div>
    </div>
<script>
    window.pageConfig = {
        jsAction: @json($jsAction ?? '')
    };
</script>
</x-app-layout>