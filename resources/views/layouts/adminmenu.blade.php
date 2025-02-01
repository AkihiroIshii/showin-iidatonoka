        <!-- 管理者 生徒別画面 共通メニュー -->
        <div style="display:flex;" class="mb-4">
            <x-nav-link :href="route('admin.show', $user)" :active="request()->routeIs('admin.show')">
                記録一覧
            </x-nav-link>
            <x-nav-link :href="route('admin.spreadsheet', $user)" :active="request()->routeIs('admin.spreadsheet')">
                集計表(一覧形式)
            </x-nav-link>
            <x-nav-link :href="route('admin.spreadsheet3', $user)" :active="request()->routeIs('admin.spreadsheet3')">
                集計表(表形式)
            </x-nav-link>
            <x-nav-link :href="route('admin.usualtarget', $user)" :active="request()->routeIs('admin.usualtarget')">
                日々の目標
            </x-nav-link>
        </div>