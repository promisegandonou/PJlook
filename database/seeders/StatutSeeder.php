<?php

namespace Database\Seeders;

use App\Models\Statut;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $statut1= new Statut();
       $statut1->libelle="En cours";
       $statut1->save();

       $statut2= new Statut();
       $statut2->libelle="Terminé";
       $statut2->save();

       $statut3= new Statut();
       $statut3->libelle="En attente";
       $statut3->save();
    }
}
