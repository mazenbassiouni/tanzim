<?php

namespace App\Http\Controllers\Traits;
use App\Models\Mission;

trait Functions {
    public function isOfficer(int $id){
        if( $id <= 20){
            return true;
        }else{
            return false;
        }
    }

    public function missionsCollection($category){
        $active = Mission::join('tasks', 'missions.id', '=', 'tasks.mission_id')
            ->where('category_id', $category)
            ->where('tasks.status', 'active')
            ->groupBy('missions.id')
            ->select('missions.*')
            ->selectRaw('MIN(tasks.due_to) as due_date')
            ->orderBy('due_date')
            ->get();
        
        $pending = Mission::join('tasks', 'missions.id', '=', 'tasks.mission_id')
            ->where('category_id', $category)
            ->where('tasks.status', 'pending')
            ->whereNotExists(function($query){
                $query->selectRaw(1)
                    ->from('tasks')
                    ->whereColumn('tasks.mission_id', '=', 'missions.id')
                    ->where('tasks.status', 'active');
            })
            ->groupBy('missions.id')
            ->select('missions.*')
            ->selectRaw('MAX(tasks.done_at) as done_at')
            ->orderByDesc('done_at')
            ->get();

        $done = Mission::join('tasks', 'missions.id', '=', 'tasks.mission_id')
            ->where('category_id', $category)
            ->whereNotExists(function($query){
                $query->selectRaw(1)
                    ->from('tasks')
                    ->whereColumn('tasks.mission_id', '=', 'missions.id')
                    ->where(function($query){
                        $query->where('tasks.status', 'pending')
                            ->orWhere('tasks.status', 'active');
                    });
            })
            ->groupBy('missions.id')
            ->select('missions.*')
            ->selectRaw('MAX(tasks.done_at) as done_at')
            ->orderByDesc('done_at')
            ->get();
        
        return [
            'active' => $active,
            'pending' => $pending,
            'done' => $done
        ];
    }
}