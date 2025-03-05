<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? 'Laravel' }}</title>

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
<link rel="icon" type="image/png" sizes="16x16" href="https://www.abdn.ac.uk/abdn-design-system/releases/2.1.0/dist/images/icons/favicon-16x16.png">
<link rel="apple-touch-icon" sizes="180x180" href="https://www.abdn.ac.uk/abdn-design-system/releases/2.1.0/dist/images/icons/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="https://www.abdn.ac.uk/abdn-design-system/releases/2.1.0/dist/images/icons/favicon-32x32.png">

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
