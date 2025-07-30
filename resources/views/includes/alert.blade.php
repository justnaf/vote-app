   @if (session('success'))
   <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md flex justify-between items-start" role="alert" style="display: none;">
       <div>
           <p class="font-bold">Berhasil</p>
           <p>{{ session('success') }}</p>
       </div>
       <button @click="show = false" class="text-green-800 hover:text-green-900 ml-4 -mt-1 -mr-2">
           <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
           </svg>
       </button>
   </div>
   @endif

   @if (session('error'))
   <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md flex justify-between items-start" role="alert" style="display: none;">
       <div>
           <p class="font-bold">Terjadi Kesalahan</p>
           <p>{{ session('error') }}</p>
       </div>
       <button @click="show = false" class="text-red-800 hover:text-red-900 ml-4 -mt-1 -mr-2">
           <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
           </svg>
       </button>
   </div>
   @endif
