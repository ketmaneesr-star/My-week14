<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Summernote Lite CSS & JS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <style>
        iframe, .note-video-clip {
            width: 100% !important;
            min-height: 400px !important;
            border-radius: 8px;
            border: none;
            margin: 15px 0;
        }
        img {
            max-width: 100%;
            height: auto;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#content').summernote({
                placeholder: 'เขียนเนื้อหาบทความที่นี่...',
                tabsize: 2,
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            // Intercept Summernote Video Insert button for YouTube URLs
            $(document).on('click', '.note-video-btn', function(e) {
                var $dialog = $(this).closest('.note-modal');
                var url = $dialog.find('.note-video-url').val();
                
                if (url) {
                    var match = url.match(/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=|shorts\/))([\w-]{11})/);
                    if (match && match[1]) {
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        
                        var videoId = match[1];
                        var iframeHtml = '<div class="ratio ratio-16x9 my-3"><iframe src="https://www.youtube.com/embed/' + videoId + '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe></div><p><br></p>';
                        
                        // Restore last cursor position and insert video at cursor
                        $('#content').summernote('restoreRange');
                        $('#content').summernote('focus');
                        $('#content').summernote('pasteHTML', iframeHtml);
                        
                        // Close Summernote modal dialog
                        $dialog.find('.close, .note-modal-close, [aria-label="Close"]').first().click();
                        $dialog.removeClass('open').hide();
                        $('.note-modal-backdrop').remove();
                    }
                }
            });

            // Force https for YouTube iframe embeds on form submit
            $('form').on('submit', function() {
                var content = $('#content').summernote('code');
                if (content) {
                    content = content.replace(/src="\/\/www\.youtube\.com/g, 'src="https://www.youtube.com');
                    content = content.replace(/src="http:\/\/www\.youtube\.com/g, 'src="https://www.youtube.com');
                    $('#content').val(content);
                }
            });
        });
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Blog App') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('เข้าสู่ระบบ') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('สมัครเป็นนักเขียน') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    สวัสดี,{{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/author/create">{{ __('เขียนบทความ') }}</a>
                                    <a class="dropdown-item" href="/author/blog">{{ __('บทความของฉัน') }}</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('ออกจากระบบ') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container py-4">
            @yield('content')
        </div>
    </div>
</body>
</html>
