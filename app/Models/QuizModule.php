<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;


/**
 * Class QuizModule
 *
 * @property int $id
 * @property int $quiz_page_id
 * @property string $type
 * @property int $position
 * @property array $content
 *
 * @property QuizPage $quiz_page
 *
 * @package App\Models
 */
class QuizModule extends Model  implements HasMedia
{
    use HasTranslations;
    use InteractsWithMedia;

    protected $table = 'quiz_modules';

    protected $casts = [
        'quiz_page_id' => 'int',
        'position' => 'int',
        'content' => 'json'
    ];

    protected $fillable = [
        'quiz_page_id',
        'type',
        'subtype',
        'name',
        'position',
        'content'
    ];

    public $translatable = ['name'];

    public function page(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(QuizPage::class);
    }


}
