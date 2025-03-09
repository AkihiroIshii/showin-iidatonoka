        <!-- その他情報 共通メニュー -->
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
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
                目的別対策
            </x-nav-link>                 
            <x-nav-link :href="route('plan')" :active="request()->routeIs('plan')">
                通塾コース
            </x-nav-link>                 
        </div>

        <!-- responsive -->
        <div class="pt-2 pb-3 space-y-1">
            <div class="sm:hidden">
                <x-responsive-nav-link :href="route('event')" :active="request()->routeIs('event')">
                    イベント
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('link')" :active="request()->routeIs('link')">
                    リンク集
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('examratio')" :active="request()->routeIs('examratio')">
                    高校入試倍率
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('audiofile')" :active="request()->routeIs('audiofile')">
                    音源
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('gift')" :active="request()->routeIs('gift')">
                    景品
                </x-responsive-nav-link>                 
                <x-responsive-nav-link :href="route('aishowin')" :active="request()->routeIs('aishowin')">
                    目的別対策
                </x-responsive-nav-link>  
                <x-responsive-nav-link :href="route('plan')" :active="request()->routeIs('plan')">
                    通塾コース
                </x-responsive-nav-link>                 
            </div>
        </div>