        <!-- 問題集 共通メニュー -->
        <div style="display:flex;" class="mb-4">
            <x-nav-link :href="route('workbook')" :active="request()->routeIs('workbook')">
                練習問題
            </x-nav-link>
            <x-nav-link :href="route('workbook.reference')" :active="request()->routeIs('workbook.reference')">
                公式集(中学)
            </x-nav-link>
            <x-nav-link :href="route('workbook.grammar')" :active="request()->routeIs('workbook.grammar')">
                英文法(中学)
            </x-nav-link>
            <x-nav-link :href="route('workbook.reading')" :active="request()->routeIs('workbook.reading')">
                英文読解(中学)
            </x-nav-link>
        </div>
