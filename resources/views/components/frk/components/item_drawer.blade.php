@props(['label'=>'item','route'=>'inicio','icon'=>'fa-solid fa-question'])

<a  href="{{route($route)}}" aria-label="dashboard"
    class="relative px-1  flex items-center space-x-4 rounded-lg text-black  font-medium
    {!! request()->routeIs($route)? 'text-black bg-orange-100' : 'text-white' !!}" >
    <i class="{{$icon}}"></i>
    <span>{{ __($label) }}</span>
</a>

