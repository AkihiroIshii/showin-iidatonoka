<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            単元別学習 地図の縮尺
        </h2>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/katex.min.css">
        <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/katex.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/contrib/auto-render.min.js"
            onload="renderMathInElement(document.body);"></script>
    </x-slot>
    <div class="mx-auto px-6 py-10">
        <div class="mx-auto px-6">
            <!-- 単元一覧画面へ -->
            <a href="{{route('workbook.unitbasedlist')}}" class="text-blue-600 font-bold">単元一覧画面へ</a>

            <div class="py-4 text-center">
                <a href="{{route('workbook.unit.map_scale')}}" class="inline-block p-2 rounded shadow bg-blue-200 font-bold">次の問題</a>
            </div>

            <div class="text-center">
                問．ある２地点間の距離は、縮尺 \(1 / {{ $scale }} \) の地図上で \( {{ $d_map_cm }}\, \mathrm{cm} \) である。実際には何 \(\mathrm{km}\) か。
            </div>

            <p>
                <details class="text-center">
                    <summary class="text-red-400 font-bold">答え</summary>
                    <div class="inline-block items-center text-center p-2 rounded shadow whitespace-nowrap overflow-hidden text-ellipsis bg-pink-200">
                        \( {{ $d_real_km }} \,\mathrm{km} \)
                    </div>
                    <p>＜解説＞</p>
                    <div class="inline-block text-left">
                        <p>実際の距離は、 \({{ $d_map_cm }} \,\mathrm{cm} \times {{ $scale }} = {{ $d_real_cm }} \,\mathrm{cm}\)。</p>
                        <p>\(1 \,\mathrm{m} = 100 \,\mathrm{cm}\) より、\({{ $d_real_cm }} \,\mathrm{cm} = {{ $d_real_cm / 100 }} \,\mathrm{m} = {{ $d_real_km}} \,\mathrm{km} \)。</p>
                        <p>(※) \(\mathrm{cm}\) から \(\mathrm{km}\) に直すよりも、まず \(\mathrm{m}\) に直した方がミスしにくい。</p>
                    </div>
                </details>                    
            </p>
        </div>
    </div>
</x-app-layout>