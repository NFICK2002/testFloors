<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository
{

    /**
     * @param mixed $id
     *
     * @return Task|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|Collection|\Illuminate\Database\Eloquent\Model
     */
    public function find_by_id($id): Task
    {
        return Task::query()->find($id);
    }

    /**
     * @param int $user_id
     *
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|Collection
     */
    public function get_tasks_by_desc(int $user_id): Collection
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
     * @return \Illuminate\Database\Eloquent\Builder[]|Collection
     */
    public function get_tasks_today(int $user_id): Collection
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
     * @return \Illuminate\Database\Eloquent\Builder[]|Collection
     */
    public function get_tasks_on_week(int $user_id): Collection
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
     * @return \Illuminate\Database\Eloquent\Builder[]|Collection
     */
    public function get_tasks_more_week(int $user_id): Collection
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
     * @return \Illuminate\Database\Eloquent\Builder[]|Collection
     */
    public function get_tasks_responsible(int $user_id, int $responsible_id): Collection
    {
        return Task::query()
            ->where(function ($query) use ($user_id, $responsible_id) {
                $query->where('creator_id', $user_id)
                    ->where('responsible_id', $responsible_id);
            })->orderBy('date_end')->get();
    }
}
