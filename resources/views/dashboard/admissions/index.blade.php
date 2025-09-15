@extends('dashboard.base')

@section('css')
<style>
    .filter-row {
        background-color: #f8f9fa;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 5px;
        border: 1px solid #dee2e6;
    }
    .filter-row .form-group {
        margin-bottom: 10px;
    }
    .filter-buttons {
        margin-top: 15px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Admissions</h4>
                        <a href="/admission/exports" class="btn btn-info float-right m-1">Exporter</a>
                    </div>
                    <div class="card-body">
                        <!-- Section des filtres avancés -->
                        <div class="filter-row">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filter-lastname">Nom</label>
                                        <input type="text" id="filter-lastname" class="form-control filter-input" placeholder="Filtrer par nom">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filter-firstname">Prénom</label>
                                        <input type="text" id="filter-firstname" class="form-control filter-input" placeholder="Filtrer par prénom">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filter-email">Email</label>
                                        <input type="text" id="filter-email" class="form-control filter-input" placeholder="Filtrer par email">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filter-phone">Téléphone</label>
                                        <input type="text" id="filter-phone" class="form-control filter-input" placeholder="Filtrer par téléphone">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filter-status">Statut</label>
                                        <select id="filter-status" class="form-control filter-select">
                                            <option value="">Tous les statuts</option>
                                            <option value="0">En attente</option>
                                            <option value="1">Validée</option>
                                            <option value="2">En traitement</option>
                                            <option value="3">Rejetée</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filter-school">École</label>
                                        <select id="filter-school" class="form-control filter-select">
                                            <option value="">Toutes les écoles</option>
                                            <!-- Option: remplir dynamiquement -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filter-payment">Mode de paiement</label>
                                        <select id="filter-payment" class="form-control filter-select">
                                            <option value="">Tous les modes</option>
                                            <option value="card">Carte</option>
                                            <option value="bank">Virement</option>
                                            <option value="mobile">Mobile Money</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filter-nationality">Nationalité</label>
                                        <input type="text" id="filter-nationality" class="form-control filter-input" placeholder="Filtrer par nationalité">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Période de création</label>
                                        <div class="input-group">
                                            <input type="date" id="date-from" class="form-control filter-date">
                                            <div class="input-group-prepend input-group-append">
                                                <span class="input-group-text">à</span>
                                            </div>
                                            <input type="date" id="date-to" class="form-control filter-date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex align-items-end justify-content-end">
                                    <div class="filter-buttons">
                                        <button id="reset-filters" class="btn btn-secondary">Réinitialiser</button>
                                        <button id="apply-filters" class="btn btn-primary ml-2">Appliquer les filtres</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tableau des admissions -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                @include('dashboard.admissions.table')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
$(function () {
    // Initialisation du tableau DataTables
    var table = $('#admission-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admissions.datatables') }}",
            data: function (d) {
                // Paramètres de base
                d.school_id = $('#filter-school').val() || '{{session("school_id")}}';

                // Ajout des paramètres de filtrage
                d.last_name = $('#filter-lastname').val();
                d.first_name = $('#filter-firstname').val();
                d.email = $('#filter-email').val();
                d.phone = $('#filter-phone').val();
                d.status = $('#filter-status').val();
                d.paiement_mode = $('#filter-payment').val();
                d.nationality = $('#filter-nationality').val();
                d.date_from = $('#date-from').val();
                d.date_to = $('#date-to').val();
            }
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'status', name: 'status'},
            {data: 'study_path_id', name: 'study_path_id'},
            {data: 'first_name', name: 'first_name'},
            {data: 'last_name', name: 'last_name'},
            {data: 'phone', name: 'phone'},
            {data: 'email', name: 'email'},
            {data: 'school_id', name: 'school_id'},
            {data: 'paiement_mode', name: 'paiement_mode'},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
        ]
    });

    // Appliquer les filtres lors du clic sur le bouton
    $('#apply-filters').on('click', function() {
        table.draw();
    });

    // Réinitialiser tous les filtres
    $('#reset-filters').on('click', function() {
        $('.filter-input, .filter-select, .filter-date').val('');
        table.draw();
    });

    // Filtrer également lors de l'appui sur Entrée dans les champs de texte
    $('.filter-input').keypress(function(e) {
        if(e.which == 13) { // Touche Entrée
            table.draw();
        }
    });
});
</script>
@endsection
