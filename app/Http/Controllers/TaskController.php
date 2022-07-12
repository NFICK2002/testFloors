<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Models\User;
use App\Repositories\TaskRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class TaskController extends Controller
{
    /**
     * @param TaskRepository $repository
     *
     * @return Application|Factory|View
     */
    public function allTask(TaskRepository $repository): View
    {
        $my_id = auth('web')->user()->id;
        $boss_id = auth()->user()->boss_id;
        $responsible_people = null;

        $all_my_task = $repository->getTasksByDesc($my_id);
        $all_users = User::all();

        if (!isset($boss_id)) {
            $responsible_people = User::query()->where('boss_id', $my_id)->get();
        }

        return view('tasks', [
            'allTask' => $all_my_task,
            'all_users' => $all_users,
            'resp_people' => $responsible_people,
        ]);
    }


    /**
     * @param TaskRepository $repository
     * @param Request $req
     *
     * @return Application|Factory|View
     */
    public function showFilterTask(TaskRepository $repository, Request $req): View
    {
        $my_id = auth('web')->user()->id;

        $responsible_people = null;
        $boss_id = auth()->user()->boss_id;

        $allTask = $repository->getTasksByDesc($my_id);

        $all_users = User::all();

        if (!isset($boss_id)) {
            $responsible_people = User::query()->where('boss_id', $my_id)->get();
        }


        $value = $req->input('filter');
        switch ($value) {
            case 'tasks_today' :
                $allTask = $repository->getTasksToday($my_id);
                break;
            case 'tasks_week':
                $allTask = $repository->getTasksOnWeek($my_id);
                break;
            case 'tasks_more_week':
                $allTask = $repository->getTasksMoreWeek($my_id);
                break;

            default:
                return view('tasks', [
                    'allTask' => $allTask,
                    'all_users' => $all_users,
                    'resp_people' => $responsible_people,
                ]);

        }

        return view('tasks', [
            'allTask' => $allTask,
            'all_users' => $all_users,
            'resp_people' => $responsible_people
        ]);
    }


    /**
     * @param TaskRepository $repository
     * @param Request $req
     *
     * @return Application|Factory|View
     */
    public function showFilterTaskResponsible(TaskRepository $repository, Request $req): View
    {
        $my_id = auth('web')->user()->id;
        $responsible_id = $req->input('filter_responsible');
        $responsible_people = null;
        $boss_id = auth()->user()->boss_id;

        $allTask = $repository->getTasksByDesc($my_id);


        $all_users = User::all();

        if (!isset($boss_id)) {
            $responsible_people = User::query()->where('boss_id', $my_id)->get();
        }


        if (isset($responsible_id)) {
            $allTask = $repository->getTasksResponsible($my_id, $responsible_id);
        }


        return view('tasks', [
            'allTask' => $allTask,
            'all_users' => $all_users,
            'resp_people' => $responsible_people
        ]);
    }


    /**
     * @param TaskRequest $req
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function addTaskSubmit(TaskRequest $req): Redirector
    {

        $task = Task::create([
            'title' => $req->title,
            'description' => $req->description,
            'date_end' => $req->date_end,
            'priority' => $req->priority,
            'creator_id' => $req->creator_id,
            'responsible_id' => $req->responsible_id,
        ]);

        return redirect(route('show_home'));
    }


    /**
     * @param TaskRepository $repository
     * @param Request $req
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function changeTask(TaskRepository $repository, Request $req): Redirector
    {
        $task = $repository->findById($req->id_course);
        $task->title = $req->title ?? $task->title;
        $task->description = $req->description ?? $task->description;
        $task->date_end = $req->date_end ?? $task->date_end;
        $task->priority = $req->priority ?? $task->priority;
        $task->status = $req->status ?? $task->status;
        $task->date_end = $req->date_end ?? $task->date_end;
        $task->responsible_id = $req->responsible_id ?? $task->responsible_id;
        $task->save();

        return redirect(route('show_home'));
    }
}
