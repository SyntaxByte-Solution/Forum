@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/multilanguage-helper.js') }}" defer></script>
@endpush

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'home'])
    <style>
        .part {
            width: calc(50% - 8px);
            height: 440px
        }
        textarea {
            display: flex;
            height: 100%;
            width: 100%;
            box-sizing: border-box;
            padding: 8px;
            border-radius: 8px;
            border: 1px solid gray;
        }

        .find-keys, .select-all {
            padding: 2px 8px;
            margin-bottom: 2px;
        }

        #multilang_result_textarea {
            padding: 10px 20px;
        }
    </style>
    <div id="middle-container" class="middle-padding-1 flex">
        <div class="full-width">
            <h1 class="my8">Internationalization Helper</h1>
            <div class="flex space-between">
                <div class="part half-width">
                    <div class="flex align-end space-between">
                        <p class="fs13 my4">Past the entire view content here to extract the trans keys: </p>
                        <div class="flex align-center">
                            <button class="select-all mr4">Select all</button>
                            <button class="find-keys">Find keys</button>
                        </div>
                    </div>
                    <textarea name="content" id="multilang_textarea" spellcheck="false" placeholder="PAST YOUR VIEW CONTENT HERE"></textarea>
                </div>
                <div class="part half-width">
                    <div class="flex align-end space-between">
                        <p class="fs13 my4">Translation keys results in form of JSON: </p>
                        <div class="mx8 flex align-end">
                            <p class="my4 fs13">lang file to compare with: </p>
                            <select name="lang" id="lang-comparison-list">
                                <option value="none">none</option>
                                <option value="fr">fr</option>
                                <option value="ar">ar</option>
                            </select>
                        </div>
                    </div>
                    <textarea name="content" id="multilang_result_textarea" spellcheck="false"></textarea>
                </div>
            </div>
        </div>
    </div>
@endsection