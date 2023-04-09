<?php

namespace App\Services;


use App\Helpers\ResponseError;
use App\Traits\ApiResponse;

abstract class CoreService
{
    use ApiResponse;
    private $model;

    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    abstract protected function getModelClass();

    protected function model() {
        return clone $this->model;
    }


    /**
     * Set Default status of Model
     * @param int|null $id
     * @param int|null $default
     * @return array
     */
    public function setDefault(int $id = null, int $default = null, $user = null): array
    {
        $model = $this->model()->orderByDesc('id')
            ->when(isset($user), function ($q) use($user) {
            $q->where('user_id', $user);
        })->get();

        // Check Languages list, if first records set it default.
        if (count($model) <= 1) {
            $this->model()->first()->update(['default' => 1, 'active' => 1]);
        }

        // Check and update default language if another language came with DEFAULT
        if ($default) {
            $defaultItem = $this->model()->orderByDesc('id')
                ->when(isset($user), function ($q) use($user) {
                    $q->where('user_id', $user);
                })->whereDefault(1)->first();

            $defaultItem->update(['default' => 0]);

            if ($id) {
                $item = $this->model()->orderByDesc('id')
                    ->when(isset($user), function ($q) use($user) {
                        $q->where('user_id', $user);
                    })->find($id);
                $item->update(['default' => 1, 'active' => 1]);
            }
        }
        return ['status' => true, 'code' => ResponseError::NO_ERROR];
    }
}
