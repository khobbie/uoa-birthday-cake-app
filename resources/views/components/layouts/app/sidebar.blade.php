<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
                {{-- <x-app-logo /> --}}

                <img src="https://www.abdn.ac.uk/media/university-of-aberdeen/content-assets/images/UoA_Primary_Logo_RGB_2018.svg" alt="University of Aberdeen logo" class="ml-10" width="130">
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group heading="Platform" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>

                    <flux:navlist.item icon="book-open" :href="route('uploads')" :current="request()->routeIs('uploads')" wire:navigate>{{ __('Upload') }}</flux:navlist.item>

                    <flux:navlist.item icon="layout-grid" :href="route('home')" :current="request()->routeIs('home')" wire:navigate>{{ __('Birthday Cakes') }}</flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />


            <!-- Desktop User Menu -->
            <flux:dropdown position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>Settings</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts



        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        <script>



function openUploadModal() {
                document.getElementById("uploadModal").classList.remove("hidden");
            }

            function closeUploadModal() {
                document.getElementById("uploadModal").classList.add("hidden");
            }

            function viewDetails(cake, names) {
                document.getElementById("detailsContent").innerText = `Cake Type: ${cake}\nOrdered by: ${names}`;
                document.getElementById("detailsModal").classList.remove("hidden");
            }

            function closeDetailsModal() {
                document.getElementById("detailsModal").classList.add("hidden");
            }

$(document).ready(function () {

        // When a toggle is clicked
        $(".toggleUploadSwitch").change(function(e) {
            e.preventDefault();

            let data = {
                status: 0,
                action_id: null,
                _token:   '{{ csrf_token() }}'
            };

        // If the current toggle is checked, uncheck all other toggles
        if ($(this).prop("checked")) {
            $(".toggleSwitch").not(this).prop("checked", false);

            data.status = 1;
            data.action_id = $(this).attr("id");
                        // Alert the ID of the currently checked toggle

        }else{
            $(".toggleSwitch").not(this).prop("checked", true);
            data.status = 0;
            data.action_id = $(this).attr("id");

        }



Swal.fire({
    title: "Processing ...",
    didOpen: () => {
        Swal.showLoading();
    }

    })



    // return false;



// Append CSRF token manually


$.ajax({
    url: "{{ route('update-upload-status') }}",
    type: "POST",
    data: JSON.stringify(data), // Convert the object to a JSON string
    contentType: 'application/json', // Ensures the content is sent as JSON
            dataType: 'json', // Specifies that you're expecting JSON response

    processData: false,
    success: function(response) {

console.log(response.message)


        Swal.fire({
        text: response.message,
        icon: "success"
        });

        setTimeout(() => {
            window.location.reload();
        }, 2000);


        // location.reload();
    },
    error: function() {

        Swal.fire({
        text: response.message ?? 'Update failed.',
        icon: "error"
        });
    }
});
    });


        $('#selectDashboardUpload').change(function () {
            let selectedValue = $(this).val();

            Swal.fire({
                    title: "Loading ...",
                    didOpen: () => {
                        Swal.showLoading();
                    }

                    })

            setTimeout(() => {
                            window.location.href = '/dashboard/' + selectedValue;
                        }, 1500);
        });



            $("#uploadForm").submit(function(e) {
                e.preventDefault();

                Swal.fire({
                    title: "Processing ...",
                    didOpen: () => {
                        Swal.showLoading();
                    }

                    })



                let formData = new FormData(this);

                // Append CSRF token manually
                // formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: "{{ route('upload') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {


                        closeUploadModal();

                        Swal.fire({
                        text: "File uploaded successfully! ",
                        icon: "success"
                        });

                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);


                        // location.reload();
                    },
                    error: function() {

                        Swal.fire({
                        text: "Upload failed. check your file ",
                        icon: "error"
                        });
                    }
                });
            });



        });
        </script>
    </body>
</html>
