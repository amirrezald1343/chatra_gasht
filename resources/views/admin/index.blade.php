@extends('admin.layout.admin')


@section('content')
    
@endsection
@section('scripts')
    <script src="{{ url('global_assets/js/plugins/visualization/d3/d3.min.js') }}"></script>
    <script src="{{ url('global_assets/js/plugins/visualization/d3/d3_tooltip.js') }}"></script>
    <script src="{{ url('global_assets/js/plugins/forms/styling/switchery.min.js') }}"></script>
    <script src="{{ url('global_assets/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
    <script src="{{ url('global_assets/js/plugins/ui/moment/moment.min.js') }}"></script>
    <script src="{{ url('global_assets/js/plugins/pickers/daterangepicker.js') }}"></script>
    <script src="{{ url('global_assets/js/demo_pages/dashboard.js') }}"></script>
@endsection
