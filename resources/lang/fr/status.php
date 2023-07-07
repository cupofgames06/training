<?php

use App\Casts\Status;


return [
    Status::CONFIRMED => 'Confirmé',
    Status::PENDING => 'En attente',
    Status::CANCELLED => 'Annulé',
    Status::REFUSED => 'Refusé',
    Status::ACTIVE => 'Actif',
    Status::INACTIVE => 'Inactif',
    Status::DELETED => 'Supprimé',
    Status::PLANNED => 'Planifié',
    Status::CARRIED_OUT => 'Effectuée',
    Status::INTERRUPTED => 'Interrompue',
    Status::VALIDATED => 'Validé',
];
