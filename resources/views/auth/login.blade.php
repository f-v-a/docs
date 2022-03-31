<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('dist/app.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <title>Авторизация</title>
    <link rel="stylesheet" href="{{ asset('dist/app.css') }}">
</head>

<body class="text-gray-800 antialiased">
    <main>
        <section class="absolute w-full h-full">
            <div class="absolute top-0 w-full h-full bg-gray-900"
                style="background-image: url(./assets/img/register_bg_2.png); background-size: 100%; background-repeat: no-repeat;">
            </div>
            <div class="container mx-auto px-4 h-full">
                <div class="flex content-center items-center justify-center h-full">
                    <div class="w-3/5 lg:w-4/12 px-4">
                        <div
                            class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-gray-300 border-0">
                            <div class="flex-auto px-4 lg:px-10 py-10 pt-10">
                                <form action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-gray-700 text-xs font-bold mb-2"
                                            for="grid-login">Логин</label>
                                        <input type="text"
                                            class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full @error('login') ring-red-500 ring-2 @enderror"
                                            placeholder="Логин" name="login" style="transition: all 0.15s ease 0s;"
                                            value="{{ old('login') }}" />
                                        @error('login')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                                fill="currentColor" class="absolute text-red-500 right-2 bottom-3"
                                                viewBox="0 0 1792 1792">
                                                <path
                                                    d="M1024 1375v-190q0-14-9.5-23.5t-22.5-9.5h-192q-13 0-22.5 9.5t-9.5 23.5v190q0 14 9.5 23.5t22.5 9.5h192q13 0 22.5-9.5t9.5-23.5zm-2-374l18-459q0-12-10-19-13-11-24-11h-220q-11 0-24 11-10 7-10 21l17 457q0 10 10 16.5t24 6.5h185q14 0 23.5-6.5t10.5-16.5zm-14-934l768 1408q35 63-2 126-17 29-46.5 46t-63.5 17h-1536q-34 0-63.5-17t-46.5-46q-37-63-2-126l768-1408q17-31 47-49t65-18 65 18 47 49z">
                                                </path>
                                            </svg>
                                            <strong class="absolute left-0 text-sm text-red-500 -bottom-6"> {{ $message }}</strong>
                                        @enderror
                                    </div>
                                    <div class="relative w-full mb-3 @error('login')mt-9 @enderror">
                                        <label class="block uppercase text-gray-700 text-xs font-bold mb-2"
                                            for="grid-password">Пароль</label>
                                        <input type="password"
                                            class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full  @error('password') ring-red-500 ring-2 @enderror "
                                            {{-- class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full" --}}
                                            placeholder="Пароль" name="password" style="transition: all 0.15s ease 0s;"
                                            value="{{ old('password') }}" />
                                        @error('password')
                                            <span class="invalid-feedback">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                                    fill="currentColor" class="absolute text-red-500 right-2 bottom-3"
                                                    viewBox="0 0 1792 1792">
                                                    <path
                                                        d="M1024 1375v-190q0-14-9.5-23.5t-22.5-9.5h-192q-13 0-22.5 9.5t-9.5 23.5v190q0 14 9.5 23.5t22.5 9.5h192q13 0 22.5-9.5t9.5-23.5zm-2-374l18-459q0-12-10-19-13-11-24-11h-220q-11 0-24 11-10 7-10 21l17 457q0 10 10 16.5t24 6.5h185q14 0 23.5-6.5t10.5-16.5zm-14-934l768 1408q35 63-2 126-17 29-46.5 46t-63.5 17h-1536q-34 0-63.5-17t-46.5-46q-37-63-2-126l768-1408q17-31 47-49t65-18 65 18 47 49z">
                                                    </path>
                                                </svg>
                                                <strong
                                                    class="absolute left-0 text-sm text-red-500 -bottom-6">{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                    <div>
                                    </div>
                                    <div class="text-center mt-10">
                                        <button
                                            class="bg-gray-900 text-white active:bg-gray-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full"
                                            style="transition: all 0.15s ease 0s;">
                                            Войти
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>

</html>