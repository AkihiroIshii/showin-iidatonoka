        <!-- 問題集 共通メニュー -->
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
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

        <!-- responsive -->
        <div class="pt-2 pb-3 space-y-1">
            <div class="sm:hidden">
                <x-responsive-nav-link :href="route('workbook')" :active="request()->routeIs('workbook')">
                    練習問題
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('workbook.reference')" :active="request()->routeIs('workbook.reference')">
                    公式集(中学)
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('workbook.grammar')" :active="request()->routeIs('workbook.grammar')">
                    英文法(中学)
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('workbook.reading')" :active="request()->routeIs('workbook.reading')">
                    英文読解(中学)
                </x-responsive-nav-link>
            </div>
        </div>