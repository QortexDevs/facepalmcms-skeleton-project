<?php

namespace App\Models;

use Facepalm\Models\Foundation\BaseEntity;
use Illuminate\Support\Str;

/**
 * @property int id
 * @property int parent_id
 * @property int status
 * @property int show_order
 * @property int created_by
 */
class User extends \Facepalm\Models\User
{
    protected $textFields = [];
    protected $stringFields = [];

    public function __get($key)
    {
        if ($key === 'full_name') {
            return $this->last_name . ' ' . $this->first_name;
        }
        if ($key === 'shortened_name') {
            return $this->last_name . ' ' . Str::substr($this->first_name, 0, 1) . '.';
        }
        return parent::__get($key);
    }

    /**
     * @param $key
     * @return bool
     */
    public function __isset($key)
    {
        if ($key === 'full_name') {
            return true;
        }
        if ($key === 'shortened_name') {
            return true;
        }
        return parent::__isset($key);
    }

}
