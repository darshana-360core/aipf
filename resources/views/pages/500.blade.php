@extends('layouts.app')

@section('title', 'Login')

@section('content')
<section class="w-full h-full bg-black flex items-center justify-center" style="height: calc(100vh - 56px);">
    <!-- component -->
    <section>

        <div class="bg-black text-white">
            <div class="flex h-screen">
                <div class="m-auto text-center">
                    <h2 class="text-9xl sm:text-[200px] lg:text-[300px] font-bold text-blue-400">500</h2>
                    <p class="text-sm md:text-base text-yellow-300 p-2 mb-4">Whoops! That page doesn’t exist.
                    </p>
                    <!-- button Process start -->
                    <div class="flex items-center justify-center my-4 relative group max-w-fit mx-auto">
                        <a href="/" class="w-full relative inline-block p-px font-semibold leading-none text-white cursor-pointer rounded-sm">
                            <span class="absolute inset-0 rounded-sm bg-gradient-to-r from-teal-400 via-blue-500 to-purple-500 p-[2px]"></span>
                            <span class="relative z-10 block px-6 py-3 rounded-sm">
                                <div class="relative z-10 flex items-center space-x-2 justify-center">
                                    <span class="transition-all duration-500 group-hover:translate-x-1">Go to Home</span>
                                    <svg class="w-6 h-6 transition-transform duration-500 group-hover:translate-x-1" data-slot="icon" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                        <path clip-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" fill-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
@endsection