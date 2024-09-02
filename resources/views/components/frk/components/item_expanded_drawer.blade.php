@props(['label'=>'','icon'=>'fa-solid fa-question'])
<div x-data="{ isActive: false, open: false}">
    <!-- active & hover classes 'bg-blue-100 dark:bg-blue-600' -->
    <a
      href="#"
      @click="$event.preventDefault(); open = !open"
      class="flex items-center px-1  text-white transition-colors rounded-md dark:text-light hover:bg-cuartoColor dark:hover:bg-blue-600"
      :class="{'text-black bg-secondaryColor  dark:bg-blue-600': isActive || open}"
      role="button"
      aria-haspopup="true"
      :aria-expanded="(open || isActive) ? 'true' : 'false'"
    >
        <i class="{{$icon}}"></i>
        <span class="ml-2 "> {{$label}}</span>
        <span aria-hidden="true" class="ml-auto">
            <!-- active class 'rotate-180' -->
            <svg
            class="w-4 h-4 transition-transform transform"
            :class="{ 'rotate-180': open }"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </span>
    </a>
    <div x-show="open" class="mt-1 space-y-2 px-3" role="menu" aria-label="Authentication">
        {{$slot}}
    </div>
</div>
