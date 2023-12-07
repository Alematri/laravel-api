<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- Font Awesome  --}}
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.css' integrity='sha512-FA9cIbtlP61W0PRtX36P6CGRy0vZs0C2Uw26Q1cMmj3xwhftftymr0sj8/YeezDnRwL9wtWw8ZwtCiTDXlXGjQ==' crossorigin='anonymous'/>

    {{-- CK Editor  --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>


    <title>Home Boolpress Admin</title>

    @vite(['resources/js/app.js'])

</head>
<body>

    @include('admin.partials.header')

    <div class="main-wrapper d-flex">
         @include('admin.partials.sidebar')
         <div class="p-5 w-100 overflow-auto">
             @yield('content')
         </div>
    </div>


</body>
</html>
