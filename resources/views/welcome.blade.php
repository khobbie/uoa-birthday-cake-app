@extends('layouts.app', ['birthday_decription' => $upload['description']])
@section('content')

    <div class="flex-1 p-6">



        @if (count($birthdays) > 0)
            <!-- Card Container -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6 w-full ">


                @foreach ($birthdays as $birthday)
                    @php
                        $birthday = (object) $birthday;
                    @endphp

                    <!-- Card 1 -->
                    <div class="flex items-center p-6 bg-white shadow-md rounded-lg">
                        @if (trim($birthday->type) == 'large')
                            <img class="w-30 h-30  rounded-full mr-5" src="{{ asset('images/large-cake.jpg') }}" width="150"
                                alt="Large Cake">
                        @else
                            <img class="w-30 h-30  rounded-full mr-5" src="{{ asset('images/small-cake.jpg') }} "
                                width="150" alt="Small Cake">
                        @endif
                        <div>
                            <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900">
                                {{ \Carbon\Carbon::parse($birthday->cake_day)->format('d F, Y') }}
                            </h1>

                            <p class="text-gray-500">{{ implode(', ', $birthday->developers) }}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <center>
                    <br>
                    <br>
                    <br>
                    <h2 class="text-4xl font-semibold tracking-tight text-pretty text-gray-400 sm:text-5xl">
                        No Active Birthdays
                    </h2>
                </center>
        @endif
    </div>

    <br><br>
    </div>


@endsection



@section('scripts')
    <script>
        function openUploadModal() {
            document.getElementById("uploadModal").classList.remove("hidden");
        }

        function closeUploadModal() {
            document.getElementById("uploadModal").classList.add("hidden");
        }

        $("#uploadForm").submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            // Append CSRF token manually
            // formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: "",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    alert("File uploaded successfully!");
                    closeUploadModal();
                    // location.reload();
                },
                error: function() {
                    alert("Upload failed.");
                }
            });
        });

        function viewDetails(cake, names) {
            document.getElementById("detailsContent").innerText = `Cake Type: ${cake}\nOrdered by: ${names}`;
            document.getElementById("detailsModal").classList.remove("hidden");
        }

        function closeDetailsModal() {
            document.getElementById("detailsModal").classList.add("hidden");
        }
    </script>
@endsection
