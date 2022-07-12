<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TaskRepository
{

    /**
     * @param mixed $id
     *
     * @return Task|Builder|Builder[]|Collection|Model
     */
    public function findById($id): Task
    {
        return Task::query()->find($id);
    }

    /**
     * @param int $user_id
     *
     *
     * @return Builder[]|Collection
     */
    public function getTasksByDesc(int $user_id): Collection
    {
        return Task::query()
            ->where('responsible_id', $user_id)
            ->orWhere('creator_id', $user_id)
            ->orderByDesc('updated_at')
            ->get();
    }

    /**
     * @param int $user_id
     *
     * @return Builder[]|Collection
     */
    public function getTasksToday(int $user_id): Collection
    {
        $today = date('Y-m-d');

        return Task::query()
            ->where(function ($query) use ($user_id) {
                $query->where('responsible_id', $user_id)
                    ->orWhere('creator_id', $user_id);
            })
            ->whereDate('date_end', '=', $today)
            ->orderBy('date_end')
            ->get();
    }


    /**
     * @param int $user_id
     *
     * @return Builder[]|Collection
     */
    public function getTasksOnWeek(int $user_id): Collection
    {
        $today = date('Y-m-d');
        $date_week = date("Y-m-d", strtotime($today . '+ 7 days'));

        return Task::query()
            ->where(function ($query) use ($user_id) {
                $query->where('responsible_id', $user_id)
                    ->orWhere('creator_id', $user_id);
            })
            ->whereBetween('date_end', [$today, $date_week])
            ->orderBy('date_end')
            ->get();
    }

    /**
     * @param int $user_id
     *
     * @return Builder[]|Collection
     */
    public function getTasksMoreWeek(int $user_id): Collection
    {
        $today = date('Y-m-d');
        $date_week = date("Y-m-d", strtotime($today . '+ 7 days'));

        return Task::query()
            ->where(function ($query) use ($user_id) {
                $query->where('responsible_id', $user_id)
                    ->orWhere('creator_id', $user_id);
            })
            ->whereDate('date_end', '>', $date_week)
            ->orderBy('date_end')
            ->get();
    }

    /**
     * @param int $user_id
     * @param int $responsible_id
     *
     * @return Builder[]|Collection
     */
    public function getTasksResponsible(int $user_id, int $responsible_id): Collection
    {
        return Task::query()
            ->where(function ($query) use ($user_id, $responsible_id) {
                $query->where('creator_id', $user_id)
                    ->where('responsible_id', $responsible_id);
            })->orderBy('date_end')->get();
    }
}
