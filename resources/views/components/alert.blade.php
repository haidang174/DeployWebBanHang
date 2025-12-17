@if(session('success'))
    <div x-data="{ show: true }" 
         x-show="show" 
         x-init="setTimeout(() => show = false, 3000)"
         class="fixed top-20 right-4 z-50 max-w-md">
        <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-xl mr-3"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="ml-4">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endif

@if(session('error'))
    <div x-data="{ show: true }" 
         x-show="show" 
         x-init="setTimeout(() => show = false, 5000)"
         class="fixed top-20 right-4 z-50 max-w-md">
        <div class="bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-xl mr-3"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button @click="show = false" class="ml-4">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endif

@if($errors->any())
    <div x-data="{ show: true }" 
         x-show="show" 
         class="fixed top-20 right-4 z-50 max-w-md">
        <div class="bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg">
            <div class="flex items-start justify-between">
                <div>
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-circle text-xl mr-3"></i>
                        <span class="font-semibold">Có lỗi xảy ra:</span>
                    </div>
                    <ul class="ml-9 space-y-1 text-sm">
                        @foreach($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button @click="show = false" class="ml-4">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
@endif