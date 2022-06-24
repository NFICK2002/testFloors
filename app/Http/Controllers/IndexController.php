<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TaskRequest;

class IndexController extends Controller
{


    public function show_login_or_tasks()
    {
        if (auth('web')) {
            return redirect(route('show_home'));
        }
        return redirect(route('login'));
    }

}
