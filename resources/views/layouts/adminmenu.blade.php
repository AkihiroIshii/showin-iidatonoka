        <!-- 管理者 生徒別メニュー -->
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            @if(isset($user) && $user->grade == "中３")
                <x-nav-link :href="route('record.create')" :active="request()->routeIs('record.create')">
                    新規登録
                </x-nav-link>
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
                    解答用紙
                </x-nav-link>
            @endif
            @if(isset($user) && strpos($user->grade, '小') === false)
                <x-nav-link :href="route('workrecord')" :active="request()->routeIs('workrecord')">
                    ワーク演習
                </x-nav-link>
                <x-nav-link :href="route('examresult')" :active="request()->routeIs('examresult')">
                    試験結果
                </x-nav-link>
            @endif
            <x-nav-link :href="route('usualtarget')" :active="request()->routeIs('usualtarget')">
                日々の目標
            </x-nav-link>
            <x-nav-link :href="route('top_choice')" :active="request()->routeIs('top_choice')">
                志望校
            </x-nav-link>
            <x-nav-link :href="route('kentei')" :active="request()->routeIs('kentei')">
                検定
            </x-nav-link>
            <x-nav-link :href="route('transfer')" :active="request()->routeIs('transfer')">
                振替
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
                    集計表(一覧形式)
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('record.spreadsheet3')" :active="request()->routeIs('record.spreadsheet3')">
                    集計表(表形式)
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('record.answersheet')" :active="request()->routeIs('record.answersheet')">
                    解答用紙(配点記入済)
                </x-responsive-nav-link>
            </div>
        </div>