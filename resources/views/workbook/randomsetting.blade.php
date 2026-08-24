<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ランダム問題設定
        </h2>
    </x-slot>
    <div class="mx-auto px-6 py-10">
        <div class="mx-auto px-6">

    <table>
        <tr>
            <th>学年<span>必須</span></th>
            <td>
                <div class="inptBox">
                    <div>
                        <p class="supplement">※複数回答可</p>
                        <div id="vegetables">
                            <label>
                                <input type="checkbox" name="vegetables[]" value="中１" {{ is_array(old("vegetables")) && in_array("にんじん", old("vegetables"), true)? ' checked' : '' }}>にんじん
                            </label>
                            <label>
                                <input type="checkbox" name="vegetables[]" value="中２" {{ is_array(old("vegetables")) && in_array("たまねぎ", old("vegetables"), true)? ' checked' : '' }}>たまねぎ
                            </label>
                            <label>
                                <input type="checkbox" name="vegetables[]" value="中３" {{ is_array(old("vegetables")) && in_array("ピーマン", old("vegetables"), true)? ' checked' : '' }}>ピーマン
                            </label>
                        </div>
                        <!-- {{-- バリデーション処理 --}}
                        @if(!is_array(old("vegetables")))
                        @error('vegetables[]')
                        <p class="errMessege">{{$message}}</p>
                        @enderror
                        @endif -->
                    </div>
                </div>
            </td>
        </tr>
    </table>

        </div>
    </div>
</x-app-layout>