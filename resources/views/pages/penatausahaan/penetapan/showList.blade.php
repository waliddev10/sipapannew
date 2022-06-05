<div class="table-responsive mt-3">
    <table id="penetapan-showTable" class="table table-sm table-bordered table-hover table-striped" width="100%"
        cellspacing="0">
        <thead class="bg-secondary text-white">
            <tr>
                <th></th>
                <th>No.</th>
                <th>Tanggal Penetapan</th>
                <th>No. SKPD</th>
            </tr>
        </thead>
    </table>
</div>

<script type="text/javascript">
    tablePenetapan = $('#penetapan-showTable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: '{!! route('penetapan.list', $pelaporan_id) !!}',
        columns: [
            { data: 'action', name: 'action', className: 'text-nowrap text-center', width: '1%', orderable: false, searchable: false },
            { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center', width: '1%' , searchable: false, orderable: false},
            { data: 'tgl_penetapan', name: 'tgl_penetapan', className: 'text-center', orderable: false },
            { data: 'no_penetapan', name: 'no_penetapan', className: 'text-center', orderable: false },
        ],
        pageLength: 10
    });
</script>