<x-layouts.app>

    @if (!empty($uploads))

    <h1 class="mt-0 mb-4 text-3xl font-extrabold tracking-tight text-slate-900">


<div class="flex flex-col space-y-">

    <!-- ComboBox -->
    <select id="selectDashboardUpload" class="w-full px-3 py-2 border rounded-lg shadow-md focus:ring focus:ring-blue-300">
        @foreach( $uploads as $upload)

            <option value="{{  $upload['uuid'] }}" >{{ $upload['description'] }}</option>
        @endforeach
    </select>
</div>


    </h1>
    @endif



    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">




        <center>
            <br>
            <br>
            <br>
            <h2 class="text-4xl font-semibold tracking-tight text-pretty text-gray-400 sm:text-5xl">
                {{ $message ?? 'No data' }}
            </h2>

            <br>

            <a href="{{ route('uploads')}}">
                <button class="bg-green-500 text-white px-4 py-2 "  > Back </button>
            </a>

         </center>





    </div>
</x-layouts.app>
