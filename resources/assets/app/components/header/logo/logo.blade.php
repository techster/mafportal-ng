<a href="{{ route('home') }}" class="logo">
    <img src="{{URL::to('/build/img/logo.svg')}}" alt="logo">
    <div class="logoName">
        <span class="brandName">MafClub</span>
        <span class="brandTagline">{{ App::getLocale() == 'ru' ? 'Создатели Игры "Мафия"' : 'The Creators of the Game' }}</span>
    </div>
</a>
