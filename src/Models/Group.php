<?php

namespace Jurager\Teams\Models;

use Jurager\Teams\Teams;
use Illuminate\Database\Eloquent\Model;

abstract class Group extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'team_id', 'name' ];

    public $timestamps = false;
    /**
     * Get the team that the ability belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Teams::teamModel());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(Teams::$userModel, 'user_group', 'group_id', 'user_id');
    }

    /**
     * @param $user
     * @return bool
     */
    public function attachUser($user): bool
    {
        if ($this->team->hasUser($user)) {
            return $this->users()->sync($user, false);
        }

        return false;
    }

    /**
     * @param $user
     * @return int
     */
    public function detachUser($user)
    {
        return $this->users()->detach($user->id);
    }
}
