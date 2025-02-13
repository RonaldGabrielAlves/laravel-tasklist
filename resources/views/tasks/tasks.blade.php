@extends('layouts.app')
@section('title', 'Tasks')
<head>
    @vite(['resources/css/app.css'])
</head>
@section('content')
    <div class="container">
        <h1 class="text-center mt-5 title-page">Tasks</h1>
        <div class="mt-2 card p-3 card-style">
            <div class="d-flex-inputs2 justify-content-between">
                <button class="btn btn-outline-success addtask-btn" onclick="window.location.href='{{ route('tasks-create') }}'">Nova Tarefa</button>
                <form role="search" method="GET" action="{{ route('tasks-index') }}">
                    <div class="input-group">
                        <input class="form-control dark-input me-2" type="search" placeholder="Pesquisar" aria-label="Search" name="search" value="{{ request()->query('search') }}">
                        <button class="btn btn-outline-primary addtask-btn input-group-text" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
            <table class="table table-dark table-borderless table-rounded table-striped mt-3">
                <thead>
                    <tr>
                        <th scope="col">Tarefa</th>
                        <th scope="col">Modificado</th>
                        <th scope="col">Prazo</th>
                        <th scope="col">Feito</th>
                        <th scope="col">...</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        <tr>
                            <td data-label="Tarefa">{{ $task->task }}</td>
                            <td data-label="Modificado">{{ $task->edited_at }}</td>
                            <td data-label="Prazo">{{ $task->deadline }}</td>
                            <td data-label="Feito">{{ $task->status == 1 ? 'SIM' : 'NÃO' }}</td>
                            <td data-label="...">
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                    @if($task->status == 0)
                                        <button type="button" class="btn btn-outline-success actions-btn" onclick="completeTask('{{ route('tasks-complete', ['id' => $task->id]) }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z"/>
                                            </svg>
                                        </button>
                                    @endif
                                    <button type="button" class="btn btn-outline-primary actions-btn" onclick="window.location.href='{{ route('tasks-edit', ['id'=>$task->id]) }}'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                                        </svg>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger actions-btn" onclick="deleteTask('{{ route('tasks-destroy', ['id'=>$task->id]) }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @include('pagination')
        </div>
    </div>
    <script>
        function completeTask(url) {
            fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao completar a tarefa.');
            });
        }
        function deleteTask(url) {
            if (confirm('Tem certeza que deseja excluir esta tarefa?')) {
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        _method: 'DELETE'
                    })
                })
                .then(response => {
                    if (response.ok) {
                        window.location.reload();
                    } else {
                        alert('Erro ao excluir a tarefa.');
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao excluir a tarefa.');
                });
            }
        }
    </script>
@endsection
