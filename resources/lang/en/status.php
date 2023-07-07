<?php 

use App\Casts\Status;


return [
    Status::CONFIRMED => 'Confirmed',
    Status::PENDING => 'Pending',
    Status::CANCELLED => 'Cancelled',
    Status::REFUSED => 'Refused',
    Status::ACTIVE => 'Active',
    Status::INACTIVE => 'Inactive',
    Status::DELETED => 'Deleted',
    Status::VALIDATED => 'Validated'
];
