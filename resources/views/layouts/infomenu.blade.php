        <!-- その他情報 共通メニュー -->
        <div style="display:flex;" class="mb-4">
            <x-nav-link :href="route('event')" :active="request()->routeIs('event')">
                イベント
            </x-nav-link>
            <x-nav-link :href="route('link')" :active="request()->routeIs('link')">
                リンク集
            </x-nav-link>
            <x-nav-link :href="route('examratio')" :active="request()->routeIs('examratio')">
                高校入試倍率
            </x-nav-link>
            <x-nav-link :href="route('audiofile')" :active="request()->routeIs('audiofile')">
                音源
            </x-nav-link>
            <x-nav-link :href="route('gift')" :active="request()->routeIs('gift')">
                景品
            </x-nav-link>                 
            <x-nav-link :href="route('aishowin')" :active="request()->routeIs('aishowin')">
                <span class="text-orange-500">new! </span>目的別対策
            </x-nav-link>                 
        </div>