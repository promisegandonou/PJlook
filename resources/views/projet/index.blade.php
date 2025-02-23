@extends('layout.app')
@php $id=Auth::user()->personne->id @endphp



@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-users icon-gradient bg-deep-blue"></i>
                </div>
                <div>
                    Projets
                    <div class="page-title-subheading">Liste des projet</div>
                </div>
            </div>
            
        </div>
    </div>

    <div class="main-card mb-3 card">
    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover table-striped" id="items-table" style="width: 100%;">
                <thead>
                <tr>
                    <th>N°</th>
                    <th>Titre</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Nombre de membre</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@stop

@section('modal')
@stop

@section('scripts')
<script>
    $(document).ready(function () {
        $('#items-table').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.3/i18n/fr_fr.json'
            },
            processing: true,
            serverSide: true,
            ajax: '{!! route('projets_datatable', ['id' => $id]) !!}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'titre', name: 'titre' },
                { data: 'date_debut', name: 'date_debut' },
                { data: 'date_fin', name: 'date_fin' },
                { data: 'nombre_membres', name: 'nombre_membres' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],

           
        });
    });

 /*   $(document).on('click', '.btn-delete-projet', function () {
        let projectId = $(this).data('id');
        if (confirm("Voulez-vous vraiment supprimer ce projet?")) {
            $.ajax({
                url: '/projets/' + projectId, 
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}' // Protection CSRF
                },
                success: function (response) {
                    alert(response.message);
                    $('#dataTable').DataTable().ajax.reload(); // Recharge le tableau
                },
                error: function (xhr) {
                    alert("Une erreur s'est produite !");
                }
            });
        }
    });*/

</script>
@endsection


