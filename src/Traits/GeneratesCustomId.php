<?php

namespace TimYouri\CustomId\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use TimYouri\CustomId\Exceptions\MaxAttemptsException;

/**
 * Trait GeneratesCustomId
 * @package TimYouri\CustomId
 */
trait GeneratesCustomId
{
    protected $uniqueCustomId = true;

    protected $customIdAttempts = 10;

    protected $customIdLength = 12;

    protected $lockCustomId = true;

    /**
     * Used by Eloquent to get if the primary key is auto increment value.
     * A custom is likely not compatible for auto increment.
     * 
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Add behavior to creating and saving Eloquent events.
     * 
     * @return void
     */
    public static function bootGeneratesCustomId()
    {
        // Create a UUID to the model if it does not have one
        static::creating(function (Model $model) {
            $model->incrementing = false;

            if (!$model->getKey()) {
                $currentId = (string) $model->generateId(1);

                if ($model->uniqueCustomId) {
                    $attempts = 1;

                    // Make sure generated id is unique in database.
                    while ($model::where($model->getKeyName(), $currentId)->exists()) {
                        $attempts++;

                        // Quit if unable to generate a unique id within set maximum attempts.
                        // This is done so the loop will never run forever if all possible combinations
                        // have been stored in the database.
                        if ($attempts >= $model->customIdAttempts ?? 10) {
                            throw new MaxAttemptsException($attempts);
                        }

                        $currentId = (string) $model->generateId($attempts);
                    }
                }

                $model->{$model->getKeyName()} = $currentId;
            }
        });

        // Set original if someone tries to change the id on update/save existing model when locked.
        static::saving(function (Model $model) {
            $original_id = $model->getOriginal('id');
            if (!is_null($original_id) && $model->lockCustomId) {
                if ($original_id !== $model->id) {
                    $model->id = $original_id;
                }
            }
        });
    }

    /**
     * Generate a random id.
     *
     * @param int $attempts Number of attempts to generate a unique id.
     * @return string Ggenerated string to be used as id.
     */
    public function generateId(int $attempts = 1)
    {
        return Str::random($this->customIdLength);
    }
}
