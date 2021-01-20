@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => $titlePage])

@section('content')

    <div class="modal fade" id="dateSelectModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="get" action="" id="formDateSelect" target="ifrDownload">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tarih Seçiniz</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <label class="col-sm-4 col-form-label">Başlangıç Tarihi</label>
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <input class="form-control datetime-picker" name="startDate" type="text"
                                           value="{{ date('Y-m-d') }}"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-4 col-form-label">Bitiş Tarihi</label>
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <input class="form-control datetime-picker" name="endDate" type="text"
                                           value="{{ date('Y-m-d') }}"/>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                        <button type="submit" class="btn btn-primary">Excel'e Aktar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ $titlePage }}</h4>
                        </div>
                        <div class="card-body table-responsive">
                            <table id="ourCentersListTable" class="table table-hover">
                                <thead class="text-primary">
                                <th>ID</th>
                                <th>Başlık</th>
                                <th>Durum</th>
                                <th>Tarih</th>
                                <th>İşlem</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <iframe name="ifrDownload" id="ifrDownload" style="border: 0px; width: 1px; height: 1px;"></iframe>

@endsection

@push('js')
    <script>
        function selectDate(id) {
            $('#formDateSelect').attr('action', 'admin/forms/exportExcel/' + id)
        }

        $(".datetime-picker").datepicker({dateFormat: 'yy-mm-dd'});
        $(document).ready(function () {
            $('#ourCentersListTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "deferRender": true,
                "ajax": {
                    url: "admin/forms/listDT",
                    type: 'POST'
                },
                "autoWidth": false,
                "drawCallback": function (settings) {
                    console.log('DataTables has redrawn the table ' + (new Date()));
                },
                "columnDefs": [
                    {
                        "targets": -1,
                        "render": function (data, type, row, meta) {
                            console.log(row);
                            return '<a href="admin/forms/edit/' + row[0] + '" class="btn btn-danger btn-sm">\
                            <i class="fas fa-edit"></i></a> \
                        \
						<a href="admin/forms/exportExcel/' + row[0] + '" class="btn btn-success btn-sm" target="ifrDownload">\
	    					<i class="fas fa-calendar-week"></i></a> \
						\
						<button onclick="selectDate(' + row[0] + ')" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#dateSelectModal">\
    						<i class="fas fa-calendar-week"></i></button> \
						\
						<a href="' + row[4] + '" class="btn btn-info btn-sm" target="_blank">\
                            <i class="fas fa-external-link-alt"></i></a>';
                        }
                    }
                ]
            });
        });
    </script>
@endpush
