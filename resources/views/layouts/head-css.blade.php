 <!-- Global stylesheets -->
 <link href="{{URL::asset('assets/fonts/inter/inter.css')}}" rel="stylesheet" type="text/css">
 <link href="{{URL::asset('assets/icons/phosphor/styles.min.css')}}" rel="stylesheet" type="text/css">
 <link href="{{URL::asset('assets/css/all.min.css')}}" id="stylesheet" rel="stylesheet" type="text/css">
 <link href="{{URL::asset('assets/css/custom.css')}}" id="stylesheet" rel="stylesheet" type="text/css">
 
 <!-- DataTables -->
 <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css">
 <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css">
 
 <!-- UCAA Custom Styles -->
 <style>
     /* UCAA Sidebar Active State */
     .sidebar .nav-link.active {
         background-color: rgba(255, 255, 255, 0.2) !important;
         font-weight: 600;
     }
     
     .sidebar .nav-link:hover {
         background-color: rgba(255, 255, 255, 0.1) !important;
     }
     
     /* DataTables Custom Styling */
     .dataTables_wrapper .dataTables_length select,
     .dataTables_wrapper .dataTables_filter input {
         border: 1px solid #ddd;
         border-radius: 0.25rem;
         padding: 0.375rem 0.75rem;
     }
     
     .dataTables_wrapper .dataTables_paginate .pagination {
         margin-top: 1rem;
     }
     
     .dt-buttons {
         margin-bottom: 1rem;
     }
     
     .dt-button {
         border-radius: 0.25rem !important;
         margin-right: 0.5rem !important;
     }
 </style>
 
 <!-- /global stylesheets -->

 @yield('css')

 <!-- Core JS files -->
 <script src="{{URL::asset('assets/demo/demo_configurator.js')}}"></script>
 <script src="{{URL::asset('assets/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
 <script src="{{URL::asset('assets/js/jquery/jquery.min.js')}}"></script>
 <!-- /core JS files -->
@yield('center-scripts')
 <!-- Theme JS files -->
 <script src="{{URL::asset('assets/js/app.js')}}"></script>
 <script src="{{URL::asset('assets/js/vendor/forms/selects/select2.min.js')}}"></script>
 <script src="{{URL::asset('assets/demo/pages/form_select2.js')}}"></script>
 
 <!-- DataTables -->
 <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
 <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
 <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
 <!-- /theme JS files -->
@yield('scripts')