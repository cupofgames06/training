<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class OfferDescription extends Model implements HasMedia
{
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;

    protected $table = 'offer_descriptions';

    public $timestamps = false;

    protected $fillable = [
        'max_learners',
        'reference',
        'code',
        'name',
        'video',
        'objectives',
        'public',
        'pre_requisite',
        'program',
        'pedago',
        'eval',
        'equipment',
        'intra',
        'pre_requisite_quiz',
        'psh_accessibility',
        'promo_message',
        'learner_message',
        'internal_comment',
    ];

    public $translatable = ['name', 'pre_requisite', 'psh_accessibility', 'objectives', 'program', 'pedago', 'eval', 'equipment', 'public', 'learner_message', 'promo_message'];

    public function describable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {

        $this->addMediaConversion('aside')->crop('crop-center', 310, 170);

    }

    public function getAsideImageAttribute()
    {
        $url = '';
        $image = $this->getFirstMedia('image');

        if (!empty($image)) {
            $url = $image('aside');
        }

        return $url;
    }
}
