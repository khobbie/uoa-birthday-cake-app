<x-layouts.app>


    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">




            <div>
                <div class="flex items-center p-6 bg-white shadow-md rounded-lg border">


                    <img class="w-30 h-30  rounded-full mr-5" src="{{ asset('images/upload-icon.png') }}" width="150"
                    alt="Active file Upload">

                    <div>
                        <h1 class="mt-3 text-1xl font-extrabold tracking-tight text-slate-900">
                           No. Upload
                        </h1>

                        <p class="text-gray-500  text-3xl">
                            {{ count($uploads) ?? 0 }}
                        </p>
                    </div>
                </div>
            </div>

            <div>
                <div class="flex items-center p-6 bg-white shadow-md rounded-lg border">


                        <img class="w-30 h-30  rounded-full mr-5" src="{{ asset('images/active-icon.png') }} " width="150"
                            alt="Active">

                    <div>
                        <h1 class="mt-3 text-1xl font-extrabold tracking-tight text-slate-900">
                            Active Upload
                        </h1>

                        <p class="text-gray-500  text-3xl">
                            {{ count($uploads) < 1 ? '0' : '1'  }}
                        </p>
                    </div>
                </div>
            </div>

            <div>
                <div class="flex items-center p-6 bg-white shadow-md rounded-lg border">


                    <img class="w-30 h-30  rounded-full mr-10" src="{{ asset('images/new-icon.png') }}" width="150"
                    alt="Active file Upload">

                    <div>
                        {{-- <h1 class="mt-3 text-1xl font-extrabold tracking-tight text-slate-900">
                            Developers
                        </h1> --}}

                        <p class="text-gray-500  text-3xl">
                            <button class="bg-green-500 text-white px-4 py-2 rounded" id="uploadNewFile" onclick="openUploadModal()"> upload</button>
                        </p>
                    </div>
                </div>
            </div>


        </div>




        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            {{-- <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" /> --}}
            @if (count($uploads) > 0 )
            <!-- Table -->
            <div class="overflow-x-auto">

                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border p-2">No.</th>

                            <th class="border p-2">Description</th>
                            <th class="border p-2">Status</th>
                            <th class="border p-2">Total</th>
                            <th class="border p-2">Uploaded By</th>
                            <th class="border p-2">Date</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $count = 1;
                    @endphp
                        @foreach ($uploads as $upload)
                            @php
                                $upload = (object) $upload;
                            @endphp
                            <tr>
                                <td class="border p-2">
                                    <h3>{{ $count }}</h3>
                                </td>



                                <td class="border p-2">
                                    <h3>
                                        <a href="{{ url('dashboard', ['upload_id' => $upload->uuid]) }}">
                                            {{  $upload->description }}
                                        </a>
                                    </h3>
                                </td>

                                <td class="border p-2">

                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="{{$upload->uuid}}" class="sr-only peer toggleUploadSwitch"  @checked($upload->status == 1)>
                                        <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-green-300
                                            rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-5
                                            peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5
                                            after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5
                                            after:transition-all peer-checked:bg-green-600">
                                        </div>
                                    </label>

                                </td>

                                <td class="border p-2">
                                    <h3>{{ $upload->count }}</h3>
                                </td>

                                <td class="border p-2">
                                    <h3>{{ $upload->user_id }}</h3>
                                </td>

                                <td class="border p-2">
                                    <h3>{{ $upload->created_at }}</h3>
                                </td>


                            </tr>

                            @php
                            $count++;
                        @endphp
                        @endforeach
                    </tbody>
                </table>


            </div>
        @else

         <center>
            <br>
            <br>
            <br>
            <h2 class="text-4xl font-semibold tracking-tight text-pretty text-gray-400 sm:text-5xl">
                No Uploads
            </h2>
         </center>
        @endif
        </div>



    </div>


        <!-- Upload Modal -->
        <div id="uploadModal" class="hidden fixed inset-0 bg-gray-100 bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded shadow-lg w-1/3">
                <h2 class="text-lg font-bold mb-4">Upload birthday text file</h2>
                <form id="uploadForm" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" id="fileInput" accept=".txt,text/plain"
                        class="mb-4 border p-2 w-full" required>
                        <br>
                        <input type="text" name="description" id="description" placeholder="Enter file description"
                        class="mb-4 border p-2 w-full" required>
                        <br>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
                    <button type="button" class="ml-2 bg-gray-400 px-4 py-2 rounded"
                        onclick="closeUploadModal()">Cancel</button>
                </form>
            </div>
        </div>

        <!-- Details Modal -->
        <div id="detailsModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded shadow-lg w-1/3">
                <h2 class="text-lg font-bold mb-4">Details</h2>
                <p id="detailsContent"></p>
                <button class="mt-4 bg-gray-400 px-4 py-2 rounded" onclick="closeDetailsModal()">Close</button>
            </div>
        </div>


</x-layouts.app>
