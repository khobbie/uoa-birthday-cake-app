<x-layouts.app>

    @if (!empty( $active_upload['uploads']))

    <h1 class="mt-0 mb-4 text-3xl font-extrabold tracking-tight text-slate-900">


<div class="flex flex-col space-y-">

    <!-- ComboBox -->
    <select id="selectDashboardUpload" class="w-full px-3 py-2 border rounded-lg shadow-md focus:ring focus:ring-blue-300">
        @foreach( $active_upload['uploads'] as $upload)

            <option value="{{  $upload['uuid'] }}" @selected( $upload['uuid'] == $active_upload['active_upload']->uuid )>{{ $upload['description'] }}</option>
        @endforeach
    </select>
</div>


    </h1>
    @endif



    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-4">

            <div>
                <div class="flex items-center p-6 bg-white shadow-md rounded-lg border">


                    <div>


                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="{{  $active_upload['active_upload']->uuid }}" class="sr-only peer toggleUploadSwitch"  @checked($active_upload['active_upload']->status == 1)>
                        <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-green-300
                            rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-5
                            peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5
                            after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5
                            after:transition-all peer-checked:bg-green-600">
                        </div>
                    </label>

                        <h1 class="mt-3 text-1xl font-extrabold tracking-tight text-slate-900">
                           <br>
                        </h1>

                        <p class="text-gray-500  text-5xl">
                            {{ $active_upload['active_upload']->status == 1 ? 'Active' : 'Offline'  }}
                        </p>
                    </div>
                </div>
            </div>


            <div>
                <div class="flex items-center p-6 bg-white shadow-md rounded-lg border">


                        <img class="w-30 h-30  rounded-full mr-5" src="{{ asset('images/small-cake.jpg') }} " width="150"
                            alt="Small Cake">

                    <div>
                        <h1 class="mt-3 text-1xl font-extrabold tracking-tight text-slate-900">
                            Small Cake
                        </h1>

                        <p class="text-gray-500  text-3xl">
                            {{$active_upload['total_small_cake'] ?? 0 }}
                        </p>
                    </div>
                </div>
            </div>

            <div>
                <div class="flex items-center p-6 bg-white shadow-md rounded-lg border">


                        <img class="w-30 h-30  rounded-full mr-5" src="{{ asset('images/large-cake.jpg') }} " width="150"
                            alt="Large Cake">

                    <div>
                        <h1 class="mt-3 text-1xl font-extrabold tracking-tight text-slate-900">
                            Large Cake
                        </h1>

                        <p class="text-gray-500  text-3xl">
                            {{$active_upload['total_large_cake'] ?? 0 }}
                        </p>
                    </div>
                </div>
            </div>

            <div>
                <div class="flex items-center p-6 bg-white shadow-md rounded-lg border">


                        <img class="w-30 h-30  rounded-full mr-5" src="{{ asset('images/developer-icon.png') }} " width="150"
                            alt="Developer">

                    <div>
                        <h1 class="mt-3 text-1xl font-extrabold tracking-tight text-slate-900">
                            Developers
                        </h1>

                        <p class="text-gray-500  text-3xl">
                            {{$active_upload['total_developers'] ?? 0 }}
                        </p>
                    </div>
                </div>
            </div>


        </div>




        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            @if (!empty($active_upload['developer_birthday_cake_details']))
            <!-- Table -->
            <div class="overflow-x-auto">

                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border p-2">Cake Date</th>
                            <th class="border p-2">Small Cake</th>
                            <th class="border p-2">Large Cake</th>
                            <th class="border p-2">Names of People</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($active_upload['developer_birthday_cake_details'] as $detail)
                            @php
                                $detail = (object) $detail;
                            @endphp
                            <tr>
                                <td class="border p-2">
                                    <h3>{{ $detail->cake_day }}</h3>
                                </td>

                                <td class="border p-2 text-center">
                                   @if (trim($detail->type) == 'small')

                                   <div class="flex justify-center">
                                    <img class="w-12 h-12  rounded-full mr-5" src="{{ asset('images/small-cake.jpg') }} " width="12"
                                    alt="Small Cake">
                                </div>

                                   @else
                                        -
                                   @endif
                                </td>

                                <td class="border p-2 text-center">
                                    @if (trim($detail->type) == 'large')

                                    <div class="flex justify-center">
                                        <img class="w-12 h-12  rounded-full " src="{{ asset('images/large-cake.jpg') }} " width="12"
                                        alt="Large Cake">
                                    </div>

                                    @else
                                         -
                                    @endif
                                 </td>

                                <td class="border p-2">{{ implode(', ', $detail->developers) }} </td>

                            </tr>
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
                No Birthdays
            </h2>
         </center>
        @endif
        </div>



    </div>
</x-layouts.app>
