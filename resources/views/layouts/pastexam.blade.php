        <!-- 過去問演習記録 共通メニュー -->
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            {{-- <x-nav-link :href="route('record.create')" :active="request()->routeIs('record.create')">
                新規登録
            </x-nav-link> --}}
            <x-nav-link :href="route('record')" :active="request()->routeIs('record')">
                記録一覧
            </x-nav-link>
            <x-nav-link :href="route('target')" :active="request()->routeIs('target')">
                目標点数
            </x-nav-link>
            <x-nav-link :href="route('record.spreadsheet')" :active="request()->routeIs('record.spreadsheet')">
                大問一覧
            </x-nav-link>
            <x-nav-link :href="route('record.spreadsheet3')" :active="request()->routeIs('record.spreadsheet3')">
                集計表
            </x-nav-link>
            <x-nav-link :href="route('record.answersheet')" :active="request()->routeIs('record.answersheet')">
                正答・配点
            </x-nav-link>
        </div>

        <!-- responsive -->
        <div class="pt-2 pb-3 space-y-1">
            <div class="sm:hidden">
                <x-responsive-nav-link :href="route('record.create')" :active="request()->routeIs('record.create')">
                    新規登録
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('record')" :active="request()->routeIs('record')">
                    記録一覧
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('target')" :active="request()->routeIs('target')">
                    目標点数
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('record.spreadsheet')" :active="request()->routeIs('record.spreadsheet')">
                    大問一覧
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('record.spreadsheet3')" :active="request()->routeIs('record.spreadsheet3')">
                    集計表
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('record.answersheet')" :active="request()->routeIs('record.answersheet')">
                    正答・配点
                </x-responsive-nav-link>
            </div>
        </div>