@push('css')
<!-- DataTables CSS -->
<link rel="stylesheet" href="{{ asset('bootstrap/css/dataTables.bootstrap.min.css') }}">
@endpush

@push('scripts')
<!-- DataTables JS-->
<script src="{{ asset('bootstrap/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bootstrap/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>
<script>
  var baca = "{{ can('b') }}";
  var ubah = "{{ can('u') }}";
  var hapus = "{{ can('h') }}";

  $.extend($.fn.dataTable.defaults, {
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "Semua"]
    ],
    pageLength: 10,
    language: {
    url: "{{ base_url('assets/bootstrap/js/dataTables.indonesian.lang') }}",
    }
  });
</script>
@endpush