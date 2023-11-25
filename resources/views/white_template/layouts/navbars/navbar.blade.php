@auth()
    @include('white_template.layouts.navbars.navs.auth')
@endauth

@guest()
    @include('white_template.layouts.navbars.navs.guest')
@endguest
