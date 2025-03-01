        <!-- 管理者 生徒別画面 共通メニュー -->
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            @php
                $user = \Illuminate\Support\Facades\Session::get('target_students');
            @endphp
            <x-nav-link :href="route('admin.show', $user)" :active="request()->routeIs('admin.show')">
                記録一覧
            </x-nav-link>
            <x-nav-link :href="route('admin.spreadsheet', $user)" :active="request()->routeIs('admin.spreadsheet')">
                集計表(一覧形式)
            </x-nav-link>
            <x-nav-link :href="route('admin.spreadsheet3', $user)" :active="request()->routeIs('admin.spreadsheet3')">
                集計表(表形式)
            </x-nav-link>
            <x-nav-link :href="route('admin.target', $user)" :active="request()->routeIs('admin.target')">
                過去問目標点数
            </x-nav-link>
            {{-- <x-nav-link :href="route('admin.usualtarget', $user)" :active="request()->routeIs('admin.usualtarget')">
                日々の目標
            </x-nav-link> --}}
            <x-nav-link :href="route('usualtarget')" :active="request()->routeIs('usualtarget')">
                日々の目標
            </x-nav-link>
            <x-nav-link :href="route('admin.exam', $user)" :active="request()->routeIs('admin.exam')">
                テスト結果
            </x-nav-link>
            <x-nav-link :href="route('admin.workrecord', $user)" :active="request()->routeIs('admin.workrecord')">
                ワーク演習
            </x-nav-link>
        </div>

        <!-- responsive -->
        <div class="pt-2 pb-3 space-y-1">
            <div class="sm:hidden">
                <x-responsive-nav-link :href="route('admin.show', $user)" :active="request()->routeIs('admin.show')">
                    記録一覧
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.spreadsheet', $user)" :active="request()->routeIs('admin.spreadsheet')">
                    集計表(一覧形式)
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.spreadsheet3', $user)" :active="request()->routeIs('admin.spreadsheet3')">
                    集計表(表形式)
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.target', $user)" :active="request()->routeIs('admin.target')">
                    過去問目標点数
                </x-responsive-nav-link>
                {{-- <x-responsive-nav-link :href="route('admin.usualtarget', $user)" :active="request()->routeIs('admin.usualtarget')">
                    日々の目標
                </x-responsive-nav-link> --}}
                <x-responsive-nav-link :href="route('admin.exam', $user)" :active="request()->routeIs('admin.exam')">
                    テスト結果
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.workrecord', $user)" :active="request()->routeIs('admin.workrecord')">
                    ワーク演習
                </x-responsive-nav-link>
            </div>
        </div>