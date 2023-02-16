<script src="{{ asset('js/tabler.min.js') }}"></script>
<script src="{{ asset('datatables/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('izitoast/dist/js/iziToast.min.js') }}"></script>
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('tinymce/popper.min.js') }}"></script>
{{-- <script src="{{ asset('litepicker/dist/litepicker.js') }}"></script> --}}
<script src="{{asset('bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ asset('moment/moment.js') }}"></script>
<script>
    jQuery('.mydatepicker, #datepicker, .input-group.date').datepicker();
    jQuery('.datepicker-autoclose').datepicker({
        autoclose: true,
        format:'dd/mm/yyyy',
        todayHighlight: true
    });
    jQuery('#date-range').datepicker({
        toggleActive: true
    });
    jQuery('#datepicker-inline').datepicker({
        todayHighlight: true
    });

    var baseUrl = "{{ url('/') }}";
</script>
