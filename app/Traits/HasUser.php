<?php

namespace App\Traits;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\IntraTraining;
use App\Models\ModelHasUser;
use App\Models\Quiz;
use App\Models\Support;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasUser
{

    public function managers(): Builder|HasManyThrough
    {
        return $this->hasManyThrough(User::class, ModelHasUser::class, 'model_id', 'id', 'id', 'user_id')
            ->where(
                ['model_type' => self::class]
            )->whereHas('roles', function ($query) {
                $query->whereIn('name', ['of']);
            });
    }


    public function users(): Builder|HasManyThrough
    {
        return $this->hasManyThrough(User::class, ModelHasUser::class, 'model_id', 'id', 'id', 'user_id')
            ->where(
                ['model_type' => self::class]
            );
    }


    public function addUser($id)
    {
        $relation = new ModelHasUser();
        $relation->user_id = $id;
        $relation->model()->associate($this);
        $relation->save();
    }

    //suppression lien manager, apprenant, formateur ... on conserve le user + profile + autre roles
    public function removeUser($user_id)
    {

        $user = User::find($user_id);

        ModelHasUser::where([
            'user_id' => $user_id,
            'model_id' => $this->id,
            'model_type' => self::class,
        ])->delete();

        $access = ModelHasUser::where([
            'user_id' => $user_id,
        ])->count();

        $enrollments = Enrollment::where([
            'user_id' => $user_id,
        ])->where('status','!=','deleted')->count();

        if ($access == 0 && $enrollments == 0) {

            //ce user n'avait qu'une seule utilité, et aucun historique d'inscription
            //on supprime tout en cascade
            //todo : affiner ? quid creator enrollment? > insérer  nom en dur, utilisée ?
            $user->delete();

        }

    }
}
