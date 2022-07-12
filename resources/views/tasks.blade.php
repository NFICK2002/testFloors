@extends('layouts.main')

@section('title')
    Мои задачи
@endsection

@section('main_content')
    <div class="info_block">
        <p>Ваш Логин : {{auth('web')->user()->login}}</p>

        <button id="my_btn_reg" class="c-button btn_reg" type="button">Добавить задачу</button>
        <div class="my_modal_reg">
            <div id="my_modal_reg" class="modal_content_reg">
                <span class="close_reg">&times;</span>
                <div class="task_form_block">
                    <form class="form_add_task" action="{{route('addTaskSubmit')}}" method="post">
                        @csrf

                        <label for="title">Название</label>
                        @error('title')
                        <p class="red_text">{{$message}}</p>
                        @enderror
                        <input class="@error('title') red_border @enderror" type="text" name="title" id="title">

                        <label for="description">Описание</label>
                        @error('description')
                        <p class="red_text">{{$message}}</p>
                        @enderror
                        <textarea class="@error('description') red_border @enderror" name="description" id="description"
                                  cols="30" rows="10"></textarea>

                        <label for="date_end">Дата окончания</label>
                        @error('date_end')
                        <p class="red_text">{{$message}}</p>
                        @enderror
                        <input class="@error('date_end') red_border @enderror" type="date" name="date_end"
                               id="date_end">

                        <label for="priority">Приоритет</label>
                        @error('priority')
                        <p class="red_text">{{$message}}</p>
                        @enderror
                        <select class="select @error('priority') red_border @enderror" name="priority" id="priority">
                            <option disabled hidden selected>Выберите приоритетность</option>
                            <option value="Высокий">Высокий</option>
                            <option value="Средний">Средний</option>
                            <option value="Низкий">Низкий</option>
                        </select>

                        <input type="hidden" name="creator_id" value="{{auth('web')->user()->id}}">

                        @if(isset($resp_people))
                            <label for="responsible_id">Ответственный</label>
                            @error('responsible_id')
                            <p class="red_text">{{$message}}</p>
                            @enderror
                            <select class="@error('responsible_id') red_border @enderror" name="responsible_id"
                                    id="responsible_id">
                                <option disabled selected hidden>Выберите подчиненного</option>
                                <option value="{{auth('web')->user()->id}}">Сделаю сам</option>
                                @foreach($resp_people as $human)
                                    <option
                                        value="{{$human->id}}">{{'id:('.$human->id . ') ' . $human->name . ' ' .
                                $human->surname . ' ' .$human->last_name}}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <input type="hidden" name="responsible_id" value="{{auth('web')->user()->id}}">
                        @endif

                        <button class="c-button form_button" type="submit">Добавить</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <div class="block_filter">
        <form class="form_filter" action="{{route('showFilterTask')}}" method="post">
            @csrf
            <label for="filter">Фильтр</label>
            <select name="filter" id="filter">
                <option disabled selected hidden>Выбери</option>
                <option>Без группировки</option>
                <option value="tasks_today">Задачи на сегодня</option>
                <option value="tasks_week">Задачи на неделю</option>
                <option value="tasks_more_week">Задачи на будущее</option>
            </select>
            <button class="c-button form_button" type="submit">Показать</button>
        </form>

        @if(isset($resp_people))
            <div class="block_filter">
                <form class="form_filter" action="{{route('show_task_resp')}}" method="post">
                    @csrf
                    <label for="filter_responsible">Фильтр по ответственным</label>
                    <select name="filter_responsible" id="filter_responsible">
                        <option disabled selected hidden>Выбери ответственного</option>
                        <option value="{{auth('web')->user()->id}}">Мои записи</option>
                        @foreach($resp_people as $human)
                            <option
                                value="{{$human->id}}">{{'id:('.$human->id . ') ' . $human->name . ' ' .
                                                                            $human->surname . ' ' .$human->last_name}}
                            </option>
                        @endforeach
                    </select>
                    <button class="c-button form_button" type="submit">Показать</button>
                </form>
            </div>
        @endif

    </div>
    @if($allTask->isNotEmpty())
        @foreach($allTask as $task)
            <div class="block_task">
                <form action="{{route('changeTask')}}" method="post">
                    @csrf
                    <ul>
                        <li>Заголовок : <span style="color:
                     @if($task->status == 'Выполнена') green

                     @elseif($task->status !== 'Выполнена' and $task->date_end < date('Y-m-d' ))
                     red
                     @else
                     #cabcbc;
                     @endif

                    ">{{$task->title}}</span></li>
                        <li>Приоритет : {{$task->priority}}</li>
                        <li>Дата окончания : {{\Illuminate\Support\Carbon::parse($task->date_end
                                            )->format(config('app.date_format'))}}</li>

                        @foreach($all_users as $user)
                            @if($task->creator_id === $user->id)
                                <li>Создатель : {{$user->name . ' ' . $user->surname . ' ' . $user->last_name}}</li>
                            @endif
                            @if($task->responsible_id === $user->id)
                                <li>Ответственный
                                    : {{ $user->name . ' ' . $user->surname . ' ' . $user->last_name}}</li>
                                <input type="hidden" name="id_course" value="{{$task->id}}">
                            @endif
                        @endforeach

                        <li>Статус : {{ $task->status}}</li>

                        <button id="my_btn" class="c-button btn_change" type="button">Изменить</button>
                        <div id="my_modal" class="modal">
                            <div class="modal_content">
                                <span class="close">&times;</span>

                                @if((isset($resp_people) && $task->creator_id === auth()->user()->id)
                                                ||  $task->creator_id === auth()->user()->id )

                                    <label for="title">Заголовок</label>
                                    <input id="title" type="text" name="title">

                                    <label for="description">Описание</label>
                                    <textarea name="description" id="description" cols="30" rows="10"></textarea>

                                    <label for="date_end">Дата окончания</label>
                                    <input type="date" name="date_end" id="date_end">

                                    <label for="priority">Приоритет</label>
                                    <select class="select" name="priority" id="priority">
                                        <option disabled hidden selected>Выберите приоритетность</option>
                                        <option value="Высокий">Высокий</option>
                                        <option value="Средний">Средний</option>
                                        <option value="Низкий">Низкий</option>
                                    </select>


                                    <label for="status">Статус</label>
                                    <select class="select" name="status" id="status">
                                        <option disabled hidden selected>Выберите cтатус</option>
                                        <option value="Выполняется">Выполняется</option>
                                        <option value="Выполнена">Выполнена</option>
                                        <option value="Отменена">Отменена</option>
                                    </select>

                                    @if(isset($resp_people))
                                        <label for="responsible_id">Ответственный</label>
                                        <select name="responsible_id" id="responsible_id">
                                            <option disabled selected hidden>Выберите подчиненного</option>
                                            <option value="{{auth('web')->user()->id}}">Сделаю сам</option>
                                            @foreach($resp_people as $human)
                                                <option
                                                    value="{{$human->id}}">{{'id:('.$human->id . ') ' . $human->name . ' ' .
                                                                            $human->surname . ' ' .$human->last_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                @else
                                    <label for="status">Статус</label>
                                    <select class="select" name="status" id="status">
                                        <option value="Выполняется">Выполняется</option>
                                        <option value="Выполнена">Выполнена</option>
                                        <option value="Отменена">Отменена</option>
                                        <option disabled selected hidden>Выберите cтатус</option>
                                    </select>
                                @endif
                                <button type="submit" class="c-button">Изменить</button>
                            </div>
                        </div>
                    </ul>

                </form>
            </div>
        @endforeach
    @else
        <div class="block_task">
            <h1>Не найдено</h1>
        </div>
    @endif
@endsection
