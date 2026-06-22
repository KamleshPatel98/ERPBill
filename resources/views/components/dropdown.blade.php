@push('style')
    <link rel="stylesheet" href="{{ asset('assets/select2/select2.min.css') }}">
    <style>
        .select2-container .select2-selection--single {
            height: 36px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }
    </style>
@endpush

@push('script')
    <script src="{{ asset('assets/select2/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.form-select').select2({
                width: '100%',
                placeholder: 'Select an option',
                allowClear: true
            });
            $('.select-dropdown.multiple').select2({
                width: '100%',
                multiple: true,
                placeholder: 'Select options',
                allowClear: true
            });
            $('#addModal').on('shown.bs.modal', function() {
                $('.modal-select-dropdown').select2({
                    width: '100%',
                    placeholder: 'Select an option',
                    allowClear: true,
                    dropdownParent: $('#addModal')
                });
            });
        });
    </script>
@endpush