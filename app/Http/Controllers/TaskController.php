<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Models\User;
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * @param TaskRepository $repository
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function all_task(TaskRepository $repository)
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
            'all_task' => $all_my_task,
            'all_users' => $all_users,
            'resp_people' => $responsible_people,
        ]);
    }


    /**
     * @param TaskRepository $repository
     * @param Request $req
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show_filter_task(TaskRepository $repository, Request $req)
    {
        $my_id = auth('web')->user()->id;

        $responsible_people = null;
        $boss_id = auth()->user()->boss_id;

        $all_task = $repository->getTasksByDesc($my_id);

        $all_users = User::all();

        if (!isset($boss_id)) {
            $responsible_people = User::query()->where('boss_id', $my_id)->get();
        }


        $value = $req->input('filter');
        switch ($value) {
            case 'tasks_today' :
                $all_task = $repository->getTasksToday($my_id);
                break;
            case 'tasks_week':
                $all_task = $repository->getTasksOnWeek($my_id);
                break;
            case 'tasks_more_week':
                $all_task = $repository->getTasksMoreWeek($my_id);
                break;

            default:
                return view('tasks', [
                    'all_task' => $all_task,
                    'all_users' => $all_users,
                    'resp_people' => $responsible_people,
                ]);

        }

        return view('tasks', [
            'all_task' => $all_task,
            'all_users' => $all_users,
            'resp_people' => $responsible_people
        ]);
    }


    /**
     * @param TaskRepository $repository
     * @param Request $req
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show_filter_task_responsible(TaskRepository $repository, Request $req)
    {
        $my_id = auth('web')->user()->id;
        $responsible_id = $req->input('filter_responsible');
        $responsible_people = null;
        $boss_id = auth()->user()->boss_id;

        $all_task = $repository->getTasksByDesc($my_id);


        $all_users = User::all();

        if (!isset($boss_id)) {
            $responsible_people = User::query()->where('boss_id', $my_id)->get();
        }


        if (isset($responsible_id)) {
            $all_task = $repository->getTasksResponsible($my_id, $responsible_id);
        }


        return view('tasks', [
            'all_task' => $all_task,
            'all_users' => $all_users,
            'resp_people' => $responsible_people
        ]);
    }


    /**
     * @param TaskRequest $req
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function add_task_submit(TaskRequest $req)
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
     * @param Request $req
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function change_task(TaskRepository $repository, Request $req)
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
