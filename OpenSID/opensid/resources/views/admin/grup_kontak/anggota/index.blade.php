@include('admin.layouts.components.asset_datatables')

@extends('admin.layouts.index')

@section('title')
<h1>
  Anggota Grup {{ $grupKontak->nama_grup }}
</h1>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('grup_kontak') }}">Grup Kontak</a></li>
<li class="active">Anggota Grup {{ $grupKontak->nama_grup }}</li>
@endsection

@section('content')
@include('admin.layouts.components.notifikasi')
<div class="row">
  <div class="col-md-3">
    @include('admin.daftar_kontak.navigasi')
  </div>
  <div class="col-md-9">
    <div class="box box-info">
      <div class="box-header with-border">
        @if (can('u'))
          <a href="{{ route('grup_kontak.anggotaform', $grupKontak->id_grup) }}" class="btn btn-social btn-success btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block"><i class="fa fa-plus"></i> Tambah</a>
        @endif
        @if (can('h'))
          <a href="#confirm-delete" title="Hapus Data" onclick="deleteAllBox('mainform', '{{ route('grup_kontak.anggotadelete') }}')" class="btn btn-social btn-danger btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block hapus-terpilih"><i class='fa fa-trash-o'></i> Hapus</a>
        @endif
      </div>
      <div class="box-body">
        {!! form_open(null, 'id="mainform" name="mainform"') !!}
          <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tabeldata">
              <thead>
                <tr>
                  <th><input type="checkbox" id="checkall"/></th>
                  <th class="padat">NO</th>
                  <th class="padat">AKSI</th>
                  <th>NAMA ANGGOTA</th>
                  <th>TELEPON</th>
                  <th>EMAIL</th>
                  <th>TELEGRAM</th>
                  <th>KIRIM MELALUI</th>
                  <th>KONTAK</th>
                </tr>
              </thead>
            </table>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@include('admin.layouts.components.konfirmasi_hapus')

@endsection
@push('scripts')
<script>
  $(document).ready(function () {
    var TableData = $('#tabeldata').DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      ajax: "{{ route('grup_kontak.anggotadatatables', $grupKontak->id_grup) }}",
      columns: [
        { data: 'ceklist', class: 'padat', searchable: false, orderable: false },
        { data: 'DT_RowIndex', class: 'padat', searchable: false, orderable: false },
        { data: 'aksi', class: 'aksi', searchable: false, orderable: false},
        { data: 'nama', name: 'nama', searchable: true, orderable: true},
        { data: 'telepon', name: 'telepon', searchable: true, orderable: true },
        { data: 'email', name: 'email', searchable: true, orderable: true },
        { data: 'telegram', name: 'telegram', searchable: true, orderable: true },
        { data: 'hubung_warga', name: 'hubung_warga', searchable: true, orderable: true },
        { data: 'kontak', class: 'padat', searchable: false, orderable: false },
      ],
      order: [[ 3, 'asc' ]]
    });
    
    if (hapus == 0) {
      TableData.column(0).visible(false);
    }

    if (ubah == 0) {
      TableData.column(2).visible(false);
    }
  });
</script>
@endpush

