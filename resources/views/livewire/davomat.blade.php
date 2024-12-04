<div>
    <h1>Davomat</h1>
    <input type="date" class="form-control" wire:change="changeDate($event.target.value)">
    <table class="table table-bordered table-striped table-dark mt-4">
        <tr>
            <th>Id</th>
            <th>Name</th>
            @foreach ($days as $day)
                <th> {{ $day->format('d') }}</th>
            @endforeach
        </tr>
        @foreach ($students as $student)
            <tr>
                <td>{{ $student->id }}</td>
                <td wire:click="editStudentName({{ $student->id }})" style="cursor: pointer;">{{ $student->name }}</td>
                @foreach ($days as $day)
                    @php
                        $studentDavomat = $student->checks($day->format('Y-m-d'));
                    @endphp
                    <td wire:click="inputView('{{ $student->id }}', '{{ $day->format('Y-m-d') }}')">
                        @if ($studentId == $student->id && $davomatDate == $day->format('Y-m-d'))
                            <input type="text" style="width: 30px;" autofocus
                                value="{{ $studentDavomat->value ?? '' }}"
                                wire:keydown.enter="createDavomat('{{ $student->id }}', '{{ $day->format('Y-m-d') }}', $event.target.value)">
                        @else
                            @if ($studentDavomat)
                                <span class="text-{{ $studentDavomat->value == '+' ? 'primary' : 'danger' }}">
                                    {{ $studentDavomat->value }}
                                </span>
                            @endif
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
        <tr>
            <td>#</td>
            @if (!$createNewStudent)
                <td><button class="btn btn-primary" wire:click="createInput">Create</button></td>
            @else
                <td><input type="text" wire:model="name" class="form-control" style="width: 80px;"
                        wire:keydown.enter="studentStore"></td>
            @endif
        </tr>
    </table>
</div>
