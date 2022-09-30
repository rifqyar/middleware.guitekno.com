<?php

namespace Vanguard\Repositories\UserTypes;

use Vanguard\Province;

class EloquentProvince implements ProvinceRepository
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Province::all();
    }

    /**
     * {@inheritdoc}
     */
    public function getAllWithUsersCount()
    {
        return Province::withCount('users')->get();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Province::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function lists($column = 'prop_nama', $key = 'prop_id')
    {
        return Province::pluck($column, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function findByName($name)
    {
        return Province::where('prop_nama', $name)->first();
    }
}
