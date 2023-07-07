<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Translatable\HasTranslations;

class Navbar extends Model
{
    use HasFactory;
    use HasRoles;
    use HasTranslations;

    protected $guard_name = 'web';

    protected $fillable = [
        'title',
        'icon',
        'ordering',
        'parent_id',
        'route'
    ];

    public $translatable = ['title'];

    public function childrens()
    {
        return $this->hasMany(Navbar::class, 'parent_id', 'id');
    }

    public function getControllerAttribute()
    {
        $routes = Route::getRoutes();
        $route = $routes->getByName($this->route);
        if ($route) {
            // Get the action array
            $action = $route->getAction();
            // Get the controller class and method
            if (isset($action['controller'])) {
                list($class, $method) = explode('@', $action['controller']);
                // Now you have the controller class and method
                return $class;
            }
        }
    }

}
