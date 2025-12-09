<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aipf</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset("/admin_dep/bootstrap/dist/css/bootstrap.min.css") }}" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="{{ asset("/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css") }}" rel="stylesheet">
    <link href="{{ asset("/plugins/bower_components/css-chart/css-chart.css") }}" rel="stylesheet">

    <!-- chartist CSS -->
    <link href="{{ asset("/plugins/bower_components/chartist-js/dist/chartist.min.css") }}" rel="stylesheet">
    <link href="{{ asset("/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css") }}" rel="stylesheet">
    <!-- Calendar CSS -->
    <link href="{{ asset("/plugins/bower_components/calendar/dist/fullcalendar.css") }}" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{{ asset("/admin_dep/css/animate.css") }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset("/plugins/bower_components/morrisjs/morris.css") }}" id="theme" rel="stylesheet">
    <link href="{{ asset("/admin_dep/css/style.css") }}?v={{time()}}" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{ asset("/admin_dep/css/colors/default.css") }}" id="theme" rel="stylesheet">
    <!-- Morris CSS -->
    <link href="{{ asset("/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css") }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset("/plugins/bower_components/datatables/media/css/dataTables.bootstrap.css") }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset("/plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.css") }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />


    <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../../assets/libs/apexcharts/dist/apexcharts.css"/>
    <style type="text/css">
        @media print {
            .pagebreak { page-break-before: always; } /* page-break-after works, as well */
        }
    </style>
</head>
