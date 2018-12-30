<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Project extends Model
{
    protected $guarded = [];

    public function owner()
    {
       return $this->belongsTo(User::class);
    }
    /* Works with store() in Projects controller model. This helps with
      Mass Assignment concerns. (MassAssignmentException)

      What is a mass assignment? When you're getting more data than expected.
      The $fillable below helps you only take in whats expected, maintaining
      the integrity of all other data.

    protected $fillable = [

      'title', 'description'
    ];

 */

    /* Not in use but for reference, if $guarded, allow all changes except to
       those noted below
    protected $guarded = [

      'title', 'description'
    ];

    so in this case, title and description wouldnt be upated */

    public function tasks()
    {
      // example of an eloquent relationship
      return $this->hasMany(Task::class);
    }

    public function addTask($task)
    {

      $this->tasks()->create($task);
    }

}
