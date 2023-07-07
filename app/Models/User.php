<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use App\Traits\HasEnrollment;
use App\Traits\HasIndicator;
use App\Traits\HasRating;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Tags\HasTags;

class User extends Authenticatable implements MustVerifyEmail, HasMedia
{
    use HasFactory, Notifiable;
    use SpatieLogsActivity;
    use HasRoles;
    use InteractsWithMedia;
    use HasTags;
    use HasIndicator;
    use HasEnrollment;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected $guard_name = 'web';

    /**
     * User relation to profile model
     *
     * @return HasOne
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'model_has_users', 'user_id', 'model_id')->where(['model_type' => Company::class]);
    }

    /**
     *
     * @return BelongsToMany
     */
    public function ofs(): BelongsToMany
    {
        return $this->belongsToMany(Of::class, 'model_has_users', 'user_id', 'model_id')->where(['model_type' => Of::class]);
    }

    protected function accountName(): Attribute
    {
        $name = '';

        $account = Cache::get('account');
        if (!empty($account)) {
            switch ($account->route) {
                case 'of':
                    $name = Of::find($account->id)->entity->name;
                    break;

                case 'company':
                    $name = Company::find($account->id)->entity->name;
                    break;

                case 'learner':
                    $name = Learner::find($account->id)->profile->full_name;
                    break;
            }
        }

        return Attribute::make(
            get: fn() => $name,
        );

    }

    public function getAccounts(): array
    {
        $accounts = [];
        foreach (config('services.roles') as $role) {

            if ($this->hasRole($role)) {
                $model = "App\Models\\" . ucfirst($role);
                switch ($role) {
                    case 'of':
                        foreach ($this->ofs->pluck('id')->toArray() as $id) {
                            $account = (object)array(
                                'model' => $model,
                                'name' => Of::find($id)->entity->name,
                                'route' => strtolower($role),
                                'id' => $id
                            );
                            $accounts[] = $account;
                        }
                        break;

                    case 'company':
                        foreach ($this->companies->pluck('id')->toArray() as $id) {
                            $account = (object)array(
                                'model' => $model,
                                'name' => Company::find($id)->entity->name,
                                'route' => strtolower($role),
                                'id' => $id
                            );
                            $accounts[] = $account;
                        }
                        break;

                    case 'learner':
//todo

                        break;

                }

            }
        }

        return $accounts;
    }

    public function setAccount($account_role = null, $account_id = null): bool
    {
        Cache::forget('account');

        foreach (config('services.roles') as $role) {

            if ($this->hasRole($role)) {

                if (empty($account_role)) {
                    $account_role = $role;
                }

                switch ($account_role) {
                    case 'of':
                        $ids = $this->ofs->pluck('id')->toArray();
                        break;

                    case 'company':
                        $ids = $this->companies->pluck('id')->toArray();
                        break;

                    case 'trainer':
                        $ids = [$this->id];
                        break;

                    case 'learner':
                        $ids = [$this->id];
                        break;
                    //todo : tous les roles
                }

                //Aucun rôle
                if ((!empty($account_id) && !in_array($account_id, $ids)) || empty($ids)) {
                    return false;
                }

                $id = empty($account_id) ? $ids[0] : $account_id;

                $model = "App\Models\\" . ucfirst($account_role);

                $account = (object)array(
                    'model' => $model,
                    'route' => strtolower($account_role),
                    'id' => $id
                );

                Cache::put('account', $account);

                return true;
            }

        }
        return false;
    }


    public function enrollments()
    {
        return $this->HasMany(Enrollment::class, 'user_id');
    }
}
