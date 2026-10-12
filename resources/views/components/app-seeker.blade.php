{{--
    Bridge component: <x-app-seeker> and x-dynamic-component :component="'app-seeker'"
    both resolve here. We re-use the full seeker layout so head tags (favicon,
    theme script, vite assets) and body stay in one place.
--}}
@include('layouts.app-seeker')
