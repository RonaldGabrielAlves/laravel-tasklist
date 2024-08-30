@extends('layouts.app')
@section('title', isset($task) ? 'Editar Task' : 'Criar Task')
<head>
    @vite(['resources/css/app.css'])
</head>
@section('content')
    <div class="container">
        <h1 class="text-center mt-5 title-page">{{ isset($task) ? 'Editar Task' : 'Criar Task' }}</h1>
        <div class="mt-2 card p-3 card-style card-style-form mx-auto">
            <form id="taskForm" action="{{ isset($task) ? route('tasks-update', ['id' => $task->id]) : route('tasks-store') }}" method="POST">
                @csrf
                @if(isset($task))
                    @method('PUT')
                @endif
                <div class="form-group">
                    <div>
                        <label for="exampleFormControlTextarea1" class="form-label text-color-page">Tarefa</label>
                        <textarea class="form-control dark-input" id="exampleFormControlTextarea1" rows="3" name="task" maxlength="300" oninput="updateCharacterCount()">{{ $task->task ?? '' }}</textarea>
                        <small id="charCount" class="form-text text-muted text-color-page">0/300 caracteres usados</small>
                    </div>
                    <div class="d-flex-inputs justify-content-between mt-2">
                        <div class="form-check">
                            <input type="hidden" name="status" value="0">
                            <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="status"{{ isset($task) && $task->status == 1 ? 'checked' : '' }}>
                            <label class="form-check-label text-color-page" for="flexCheckDefault">Marcar como concluído?</label>
                        </div>
                        <div>
                            <label class="form-check-label text-color-page" for="exampleFormControlInput1">Data de entrega</label>
                            <input type="date" class="form-control dark-input" id="exampleFormControlInput1" name="deadline" value="{{ isset($task) ? \Carbon\Carbon::createFromFormat('d/m/Y', $task->deadline)->format('Y-m-d') : '' }}">
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-2">
                        <button type="submit" class="btn btn-outline-success addtask-btn" id="submitBtn">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        function updateCharacterCount() {
            const textarea = document.getElementById('exampleFormControlTextarea1');
            const charCount = document.getElementById('charCount');
            charCount.textContent = `${textarea.value.length}/300 caracteres usados`;
        }
        document.addEventListener('DOMContentLoaded', updateCharacterCount);

        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const day = String(today.getDate()).padStart(2, '0');
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const year = today.getFullYear();
            const formattedToday = `${year}-${month}-${day}`;
            @if(isset($task))
                const minDeadline = '{{ \Carbon\Carbon::createFromFormat('d/m/Y', $task->deadline)->format('Y-m-d') }}';
            @else
                const minDeadline = formattedToday;
            @endif
            document.getElementById('exampleFormControlInput1').setAttribute('min', minDeadline);
        });

        document.getElementById('taskForm').addEventListener('submit', function(event) {
            const task = document.querySelector('textarea[name="task"]').value.trim();
            const deadline = document.querySelector('input[name="deadline"]').value;
            if (!task || !deadline) {
                alert('Por favor, preencha todos os campos obrigatórios.');
                event.preventDefault();
            }
        });
    </script>
@endsection
