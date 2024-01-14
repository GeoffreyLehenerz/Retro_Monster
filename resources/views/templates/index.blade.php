<!DOCTYPE html>
<html lang="fr">
@include('templates.partials._head')
    <body class="bg-gray-800 text-white font-sans">
        <!-- Header -->
        @include('templates.partials._header')

        <!-- Main Content -->
        <div class="container mx-auto flex flex-wrap pt-4 pb-12">

        @include('templates.partials._main')

        <!-- Sidebar -->
        @include('templates.partials._aside')
        </div>

        <!-- Footer -->
        @include('templates.partials._footer')
    </body>
</html>
