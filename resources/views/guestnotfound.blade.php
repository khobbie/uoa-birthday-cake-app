@extends('layouts.app')
@section('content')

    <div class="flex-1 p-1 bg-white">


        <center>
            <br>
            <br>
            <br>
            <h2 class="text-4xl font-semibold tracking-tight text-pretty text-gray-400 sm:text-5xl">
                {{ $message ?? 'No data' }}
            </h2>

            <br>

            <a href="{{ route('home')}}">
                <button class="bg-green-500 text-white px-4 py-2 "  >  Try again  </button>
            </a>

         </center>


    </div>




@endsection




