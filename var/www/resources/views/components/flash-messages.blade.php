@if(session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4 shadow">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 text-red-800 p-3 rounded mb-4 shadow border border-red-300">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="bg-red-100 text-red-800 p-3 rounded mb-4 border border-red-300 shadow">
        <ul class="list-disc list-inside text-sm space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
