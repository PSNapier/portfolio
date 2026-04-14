<!DOCTYPE html>
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  @class(['dark' => ($appearance ?? 'system') == 'dark'])> --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- Inline script to detect system dark mode preference and apply it immediately --}}
        {{-- <script>
            (function() {
                const appearance = '{{ $appearance ?? "system" }}';

                if (appearance === 'system') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (prefersDark) {
                        document.documentElement.classList.add('dark');
                    }
                }
            })();
        </script> --}}

        {{-- Inline style to set the HTML background color based on our theme in app.css --}}
        {{-- <style>
            html {
                background-color: #fafafa;
            }

            html.dark {
                background-color: #171717;
            }
        </style> --}}

        <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2224%22 height=%2224%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23fff%22 stroke-width=%221%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22 overflow=%22hidden%22%3E%3Crect x=%22-2%22 y=%22-2%22 width=%2228%22 height=%2228%22 fill=%22%23000%22 shape-rendering=%22crispEdges%22/%3E%3Cpath d=%22M3 3c0 2 1 3 4 3c2 0 3 1 3 3%22/%3E%3Cpath d=%22M21 3c0 2 -1 3 -4 3c-2 0 -3 .333 -3 3%22/%3E%3Cpath d=%22M12 18c-1 0 -4 -3 -4 -6c0 -2 1.333 -3 4 -3s4 1 4 3c0 3 -3 6 -4 6%22/%3E%3Cpath d=%22M15.185 14.889l.095 -.18a4 4 0 1 1 -6.56 0%22/%3E%3Cpath d=%22M17 3c0 1.333 -.333 2.333 -1 3%22/%3E%3Cpath d=%22M7 3c0 1.333 .333 2.333 1 3%22/%3E%3Cpath d=%22M7 6c-2.667 .667 -4.333 1.667 -5 3%22/%3E%3Cpath d=%22M17 6c2.667 .667 4.333 1.667 5 3%22/%3E%3Cpath d=%22M8.5 10l-1.5 -1%22/%3E%3Cpath d=%22M15.5 10l1.5 -1%22/%3E%3C/svg%3E">
        {{-- <link rel="apple-touch-icon" href="/apple-touch-icon.png"> --}}

        @routes
        @vite(['resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased bg-cape-palliser-100 text-cape-palliser-600">
        @inertia
    </body>
</html>
