
   
<section class="bg-white w-full dark:bg-gray-900 p-8  border  rounded-md mb-4">
    <div class="mr-6">
        <h1 class="font-semibold text-xl leading-10 dark:text-white">{{$title}}</h1>
        @isset($description)
        <p class="text-gray-500 dark:text-gray">{{$description}}</p>
        @endisset  
        <div class="border-b border-gray-300 my-2"></div>
    </div>
</section>