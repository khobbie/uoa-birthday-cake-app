<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" type="image/png" sizes="16x16"
        href="https://www.abdn.ac.uk/abdn-design-system/releases/2.1.0/dist/images/icons/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180"
        href="https://www.abdn.ac.uk/abdn-design-system/releases/2.1.0/dist/images/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32"
        href="https://www.abdn.ac.uk/abdn-design-system/releases/2.1.0/dist/images/icons/favicon-32x32.png">
</head>

<body class="bg-gray-100 dark:bg-[#0a0a0a] text-[#1b1b18]  p-2 lg:p-8  ">



        <div class="  bg-white-100 flex justify-between items-center mb-4 container">

            <img src="https://www.abdn.ac.uk/media/university-of-aberdeen/content-assets/images/UoA_Primary_Logo_RGB_2018.svg"
                alt="University of Aberdeen logo" class="ml-12" width="100">


            <h4 class="text-2xl font-semibold tracking-tight text-pretty text-gray-400 sm:text-3xl">
                Developers Cakes
            </h4>


            @if (Route::has('login'))
                <nav class="">

                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                            Dashboard
                        </a>
                    @else
                        @if (Route::has('register'))
                            <a href="{{ route('login') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Login
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif

        </div>





    <div class="  flex items-center justify-center min-h-screen p-6">
        <div class="flex h-screen container">


            @yield('content')

        </div>

    </div>




    @yield('scripts')

    @push('page_js')


    </body>

    </html>
