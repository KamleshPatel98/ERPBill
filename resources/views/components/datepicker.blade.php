@push('style')
    <link rel="stylesheet" href="{{ asset('assets/jquery-ui/jquery-ui.min.css') }}">
@endpush

@push('script')
    <script src="{{ asset('assets/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var currentYear = new Date().getFullYear();
            $('.datepicker').datepicker({
                dateFormat: "dd-mm-yy",
                changeMonth: true,
                changeYear: true,
                yearRange: "1950:2035",
            });
        });
    </script>
@endpush