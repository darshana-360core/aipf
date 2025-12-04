<link rel="stylesheet" href="{{asset('assets/css/swiper-bundle.min.css')}}">
<div class="w-full p-4 md:p-6 rounded-xl mx-auto border border-[#24324d] bg-[#101735] text-left p-4 rounded-xl bg-gradient-to-t from-[#265e8c] via-[#255480] to-[#243f82] overflow-hidden relative">
    <!-- Swiper Container -->
    <div class="swiper-container rankingsliderbox">
        <div class="swiper-wrapper">
            @foreach($data['levels'] as $key => $value)
            <div class="swiper-slide rounded">
                <div class="p-4 levelbox text-center text-white relative flex flex-col gap-1 items-center justify-center {{$data['user']['level'] == $value['id'] ? 'myrank' : ''}}">
                    <!-- <img src={{ asset('assets/images/rank/'.$value['id'].'.webp') }} width="200" height="200" alt="Ranking" class="h-20 w-auto mx-auto mb-3"> -->
                    <strong class="block">Level</strong>
                    <strong class="block">{{$value['level']}}</strong>
                </div>
            </div>
            @endforeach
        </div>
        <!-- <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div> -->
    </div>

    <!-- Navigation Buttons -->
    <!-- <button class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white p-2 rounded-full swiper-button-prev">
        ◀
    </button>
    <button class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white p-2 rounded-full swiper-button-next">
        ▶
    </button> -->
</div>
<script src="{{asset('assets/js/swiper-bundle.min.js')}}"></script>
<!-- Initialize Swiper -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        new Swiper('.swiper-container', {
            loop: false,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            slidesPerView: 8,
            spaceBetween: 15,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                300: {
                    slidesPerView: 2
                },
                370: {
                    slidesPerView: 3
                },
                575: {
                    slidesPerView: 4
                },
                992: {
                    slidesPerView: 5
                },
                1280: {
                    slidesPerView: 6
                },
                1400: {
                    slidesPerView: 8
                },
            }
        });
    });
</script>
<style>
    .myrank {
        color: #11c2f5;
    }

    .swiper-button-next,
    .swiper-button-prev {
        color: #fff;
        background-color: rgba(0, 0, 0, 0.4);
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        top: 45%;
        bottom: unset;
        transform: translateY(50%);
    }

    .swiper-button-next::after,
    .swiper-button-prev::after {
        font-size: 8px;
        font-weight: bold;
    }

    .swiper-button-prev {
        left: 5px;
    }

    .swiper-button-next {
        right: 5px;
    }
</style>