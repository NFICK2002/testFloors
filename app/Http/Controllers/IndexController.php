<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TaskRequest;
use Illuminate\View\View;

class IndexController extends Controller
{


    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function showLoginOrTasks() : Redirector
    {
        if (auth('web')) {
            return redirect(route('show_home'));
        }
        return redirect(route('login'));
    }

}
