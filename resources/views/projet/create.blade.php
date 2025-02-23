@extends('layout.app')
@php $personneC=Auth::user()->personne @endphp


@section('content')



<div>
    <form action="{{route('projet.store')}}" method="post">
        @csrf
        <div class="">
            <div class="">
                <h4 class="modal-title">Créer un projet</h4>
                
            </div>
            <div class="card card-primary">
                <div class="card-body">
                    
                    <div class="col-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Titre</label>
                            <input type="text" class="form-control" id="" placeholder="Entrer le titre du projet.." name="titre">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Description</label>
                            <textarea class="form-control" rows="2" placeholder="Entrer une description ..." name="description"></textarea>
                        </div>
                    </div>
                    
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Chef Projet</label>
                            <select name="personne_id" id="personne" class="form-control">
                                @foreach($personnes as $personne)
                                <option value="{{ $personne->id }}"
                                    {{  $personne->id == Auth::user()->personne->id ? 'selected' : '' }}>
                                    {{ $personne->nom }} {{ $personne->prenom }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Date Début</label>
                            <input type="date" class="form-control" id="" name="date_debut">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Date Fin</label>
                            <input type="date" class="form-control" id="" name="date_fin">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="statut">Statut</label>
                            <select name="statut_id" id="statut" class="form-control">
                                @foreach($statuts as $statut)
                                <option value="{{ $statut->id }}"
                                    {{  $statut->libelle == "En cours" ? 'selected' : '' }}>
                                    {{ $statut->libelle}} 
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                   <!-- <div class="col-12">
                         <div class="form-group">
                            <label for="exampleInputEmail1">Remarks</label>
                            <textarea class="form-control" rows="2" placeholder="Enter ..."></textarea>
                        </div>
                    </div>-->

                    <div class="col-6">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Submit</button>
                    </div>
                </div>
            </div>
        </div>

</div>
</form>
</div>



@endsection