<?php

namespace Vanguard\Repositories\UserTypes;

use Vanguard\Events\Types\Created;
use Vanguard\Events\Types\Deleted;
use Vanguard\Events\Types\Updated;
use Vanguard\Type;

class EloquentType implements TypeRepository
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Type::all();
    }

    /**
     * {@inheritdoc}
     */
    public function getAllWithUsersCount()
    {
        return Type::withCount('users')->get();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Type::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        $types = Type::create($data);

        event(new Created($types));

        return $types;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $types = $this->find($id);

        $types->update($data);

        event(new Updated($types));

        return $types;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $types = $this->find($id);

        event(new Deleted($types));

        return $role->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function updatePermissions($roleId, array $permissions)
    {
        $types = $this->find($roleId);

        $types->syncPermissions($permissions);
    }

    /**
     * {@inheritdoc}
     */
    public function lists($column = 'ut_name', $key = 'ut_id')
    {
        return Type::pluck($column, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function findByName($name)
    {
        return Type::where('ut_name', $name)->first();
    }
}
