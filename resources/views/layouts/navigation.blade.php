<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    @if(Auth::user()->role == "admin")
                        <a href="{{ route('admin.dashboard') }}">
                            <img src="{{asset('logo/showin_logo.png')}}" style="max-height:50px">
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}">
                            <img src="{{asset('logo/showin_logo.png')}}" style="max-height:50px">
                        </a>
                    @endif
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(Auth::user()->role == "admin")
                        <x-nav-link :href="route('admin.students')" :active="request()->routeIs('admin.students')">
                            生徒一覧
                        </x-nav-link>
                        <x-nav-link :href="route('event')" :active="request()->routeIs('event')">
                            イベント
                        </x-nav-link>
                        <x-nav-link :href="route('admin.maintain')" :active="request()->routeIs('admin.maintain')">
                            メンテナンス
                        </x-nav-link>
                        <x-nav-link :href="route('admin.workbook')" :active="request()->routeIs('admin.workbook')">
                            問題集
                        </x-nav-link>
                        <x-nav-link :href="route('exam.list')" :active="request()->routeIs('exam.list')">
                            試験
                        </x-nav-link>
                    @elseif(Auth::user()->grade == "保護者")
                        <x-nav-link :href="route('usualtarget')" :active="request()->routeIs('usualtarget')">
                            日々の目標
                        </x-nav-link>
                        <x-nav-link :href="route('completedunit')" :active="request()->routeIs('completedunit')">
                            単元
                        </x-nav-link>
                        <x-nav-link :href="route('examresult')" :active="request()->routeIs('examresult')">
                            試験結果
                        </x-nav-link>
                        <x-nav-link :href="route('kentei')" :active="request()->routeIs('kentei')">
                            検定
                        </x-nav-link>
                        <x-nav-link :href="route('top_choice')" :active="request()->routeIs('top_choice')">
                            志望校
                        </x-nav-link>
                        <x-nav-link :href="route('coin')" :active="request()->routeIs('coin')">
                            コイン
                        </x-nav-link>
                        {{-- <x-nav-link :href="route('transfer')" :active="request()->routeIs('transfer')">
                            振替
                        </x-nav-link> --}}
                    @else
                        @if(Auth::user()->grade == "中３")
                            <x-nav-link :href="route('record')" :active="request()->routeIs('record')">
                                過去問
                            </x-nav-link>
                        @endif
                        <x-nav-link :href="route('usualtarget')" :active="request()->routeIs('usualtarget')">
                            日々の目標
                        </x-nav-link>
                        <x-nav-link :href="route('completedunit')" :active="request()->routeIs('completedunit')">
                            単元
                        </x-nav-link>
                        @if(strpos(Auth::user()->grade, '小') === false) <!-- 小学生でなければ表示する -->
                            <x-nav-link :href="route('workrecord')" :active="request()->routeIs('workrecord')">
                                ワーク
                            </x-nav-link>
                            <x-nav-link :href="route('examresult')" :active="request()->routeIs('examresult')">
                                試験結果
                            </x-nav-link>
                            <x-nav-link :href="route('top_choice')" :active="request()->routeIs('top_choice')">
                                志望校
                            </x-nav-link>
                        @endif
                        <x-nav-link :href="route('kentei')" :active="request()->routeIs('kentei')">
                            検定
                        </x-nav-link>
                        <x-nav-link :href="route('workbook.reference')" :active="request()->routeIs('workbook.reference')">
                            公式集
                        </x-nav-link>
                        <x-nav-link :href="route('coin')" :active="request()->routeIs('coin')">
                            コイン
                        </x-nav-link>
                        {{-- @if(strpos(Auth::user()->grade, '高') !== false) <!-- 高校生なら表示する -->
                            <x-nav-link :href="route('transfer')" :active="request()->routeIs('transfer')">
                                振替
                            </x-nav-link>
                        @endif --}}
                    @endif
                    <!-- 管理者、生徒共通 -->
                    <x-nav-link :href="route('event')" :active="request()->routeIs('event')">
                        その他情報
                    </x-nav-link>
                    <!-- テスト運用 -->
                    {{-- @if(Auth::user()->role == "admin")
                        <x-nav-link :href="route('meeting.host')" :active="request()->routeIs('meeting.host')">
                            通話
                        </x-nav-link>
                    @endif --}}
                    @if(Auth::user()->role != "admin")
                        <x-nav-link :href="route('meeting.video')" :active="request()->routeIs('meeting.video')">
                            通話
                        </x-nav-link>
                    @endif
                    {{-- @if(Auth::user()->role != "admin")
                        <x-nav-link :href="route('message')" :active="request()->routeIs('message')">
                            チャット（開発中）
                        </x-nav-link>
                    @endif --}}
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link> -->

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            {{-- <p class="text-xs">　一部、スマホ表示に未対応です。すみません(＞＜;)</p> --}}
            <!-- <x-responsive-nav-link :href="route('record')" :active="request()->routeIs('record')">
                一覧
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('record.create')" :active="request()->routeIs('record.create')">
                新規登録
            </x-responsive-nav-link> -->
            @if(Auth::user()->role == "admin")
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    生徒一覧
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('event')" :active="request()->routeIs('event')">
                    イベント
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.maintain')" :active="request()->routeIs('admin.maintain')">
                    メンテナンス
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.workbook')" :active="request()->routeIs('admin.workbook')">
                    問題集
                </x-responsive-nav-link>
            @elseif(Auth::user()->grade == "保護者")
                <x-responsive-nav-link :href="route('usualtarget')" :active="request()->routeIs('usualtarget')">
                    日々の目標
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('completedunit')" :active="request()->routeIs('completedunit')">
                    単元
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('examresult')" :active="request()->routeIs('examresult')">
                    試験結果
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('kentei')" :active="request()->routeIs('kentei')">
                    検定
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('top_choice')" :active="request()->routeIs('top_choice')">
                    志望校
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('coin')" :active="request()->routeIs('coin')">
                    コイン
                </x-responsive-nav-link>
                {{-- <x-responsive-nav-link :href="route('transfer')" :active="request()->routeIs('transfer')">
                    振替
                </x-responsive-nav-link> --}}
            @else
                @if(Auth::user()->grade == "中３")
                    <x-responsive-nav-link :href="route('record')" :active="request()->routeIs('record')">
                        過去問演習
                    </x-responsive-nav-link>
                @endif
                <x-responsive-nav-link :href="route('usualtarget')" :active="request()->routeIs('usualtarget')">
                    日々の目標
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('completedunit')" :active="request()->routeIs('completedunit')">
                    単元
                </x-responsive-nav-link>
                @if(strpos(Auth::user()->grade, '小') === false) <!-- 小学生でなければ表示する -->
                    <x-responsive-nav-link :href="route('workrecord')" :active="request()->routeIs('workrecord')">
                        ワーク
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('examresult')" :active="request()->routeIs('examresult')">
                        試験結果
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('top_choice')" :active="request()->routeIs('top_choice')">
                        志望校
                    </x-responsive-nav-link>
                @endif
                <x-responsive-nav-link :href="route('kentei')" :active="request()->routeIs('kentei')">
                    検定
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('workbook')" :active="request()->routeIs('workbook')">
                    問題集
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('coin')" :active="request()->routeIs('coin')">
                    コイン
                </x-responsive-nav-link>
            @endif
            {{-- @if(strpos(Auth::user()->grade, '高') !== false) <!-- 高校生なら表示する -->
                <x-responsive-nav-link :href="route('transfer')" :active="request()->routeIs('transfer')">
                    振替
                </x-responsive-nav-link>
            @endif --}}
            <!-- 管理者、生徒共通 -->
            <x-responsive-nav-link :href="route('event')" :active="request()->routeIs('event')">
                その他情報
            </x-responsive-nav-link>
            @if(Auth::user()->role != "admin")
                <x-responsive-nav-link :href="route('meeting.video')" :active="request()->routeIs('meeting.video')">
                    通話
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{-- {{ Auth::user()->name }} --}}</div>
                <div class="font-medium text-sm text-gray-500">{{-- {{ Auth::user()->email }} --}}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link> -->

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
