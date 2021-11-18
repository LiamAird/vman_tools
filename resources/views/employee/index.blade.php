<h2>Talentspejder</h2>
<table>
    <tbody>
    @foreach($staff_scout as $employee)
        <tr>
            <td>
                <a href="https://www.virtualmanager.com/employees/{{$employee->staff_id}}">
                    {{ $employee->name }} ({{$employee->age}})
                </a>
            </td>
            <td>
                Potentiale: {{ $employee->potential }}
            </td>
            <td>
                Disciplin: {{ $employee->discipline }}
            </td>
            <td>
                Motivation: {{ $employee->motivation }}
            </td>
            <td>
                Potential: {{ $employee->employee_potential }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<hr>

<h2>Trænere</h2>
<table>
    <tbody>
    @foreach($staff_trainer as $employee)
        <tr>
            <td>
                <a href="https://www.virtualmanager.com/employees/{{$employee->staff_id}}">
                    {{ $employee->name }} ({{$employee->age}})
                </a>
            </td>
            <td>
                Ungdom: {{ $employee->youth }}
            </td>
            <td>
                Målmand: {{ $employee->keeper }}
            </td>
            <td>
                Markspiller: {{ $employee->mark }}
            </td>
            <td>
                Potential: {{ $employee->employee_potential }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>