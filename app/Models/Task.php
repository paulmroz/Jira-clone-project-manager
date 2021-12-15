<?php

namespace App\Models;

use App\Traits\RecordsActivity;
use App\Utilities\BaseFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class Task extends Model
{
    use HasFactory, RecordsActivity;

    protected $guarded = [];

    protected $touches = [
        'project'
    ];

    protected $casts =[
      'completed' => 'boolean'
    ];

    protected  static $recordableEvents = ['created','updated', 'deleted'];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function path()
    {
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }

    public function complete()
    {
//        $this->update(['status_id' => 3]);

        $this->status_id = 3;
        $this->saveQuietly();
        $this->recordActivity('completed_task');
    }

    public function incomplete()
    {
        //$this->update(['status_id' => 1]);
        $this->status_id = 1;
        $this->saveQuietly();

        $this->recordActivity('incompleted_task');

    }

    public function inprogress()
    {
        //$this->update(['status_id' => 2]);
        $this->status_id = 2;
        $this->saveQuietly();

        $this->recordActivity('inprogess_task');

    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function activity()
    {
        return $this->morphMany(Activity::class,'subject')->latest();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeCanFilter(Builder $builder, $filters){
        return (new BaseFilter($filters))->filter($builder);
    }
}
