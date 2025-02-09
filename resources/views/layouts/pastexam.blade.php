        <!-- 過去問演習記録 共通メニュー -->
        <div style="display:flex;" class="mb-4">
            <x-nav-link :href="route('record.create')" :active="request()->routeIs('record.create')">
                新規登録
            </x-nav-link>
            <x-nav-link :href="route('record', $user)" :active="request()->routeIs('record')">
                記録一覧
            </x-nav-link>
            <x-nav-link :href="route('target')" :active="request()->routeIs('target')">
                目標点数
            </x-nav-link>
            <x-nav-link :href="route('record.spreadsheet', $user)" :active="request()->routeIs('record.spreadsheet')">
                集計表(一覧形式)
            </x-nav-link>
            <!-- <x-nav-link :href="route('record.spreadsheet2', $user)" :active="request()->routeIs('record.spreadsheet2')">
                集計表２(年度区別なし)
            </x-nav-link> -->
            <x-nav-link :href="route('record.spreadsheet3', $user)" :active="request()->routeIs('record.spreadsheet3')">
                集計表(表形式)
            </x-nav-link>
            <x-nav-link :href="route('record.answersheet', $user)" :active="request()->routeIs('record.answersheet')">
                解答用紙(配点記入済)
            </x-nav-link>
        </div>