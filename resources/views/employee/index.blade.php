{{--<h2>Talentspejder</h2>--}}
{{--<table>--}}
{{--    <tbody>--}}
{{--    @foreach($staff_scout as $employee)--}}
{{--        <tr>--}}
{{--            <td>--}}
{{--                <a href="https://www.virtualmanager.com/employees/{{$employee->staff_id}}">--}}
{{--                    {{ $employee->name }} ({{$employee->age}})--}}
{{--                </a>--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                Potentiale: {{ $employee->potential }}--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                Disciplin: {{ $employee->discipline }}--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                Motivation: {{ $employee->motivation }}--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                Potential: {{ $employee->employee_potential }}--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--    @endforeach--}}
{{--    </tbody>--}}
{{--</table>--}}

{{--<hr>--}}

{{--<h2>Trænere</h2>--}}
{{--<table>--}}
{{--    <tbody>--}}
{{--    @foreach($staff_trainer as $employee)--}}
{{--        <tr>--}}
{{--            <td>--}}
{{--                <a href="https://www.virtualmanager.com/employees/{{$employee->staff_id}}">--}}
{{--                    {{ $employee->name }} ({{$employee->age}})--}}
{{--                </a>--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                Ungdom: {{ $employee->youth }}--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                Målmand: {{ $employee->keeper }}--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                Markspiller: {{ $employee->mark }}--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                Potential: {{ $employee->employee_potential }}--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--    @endforeach--}}
{{--    </tbody>--}}
{{--</table>--}}

@for($i = 33; $i <= 66;$i++)
    <strong>{{ $i }} 1 coach</strong><br>
{{--    <span>https://www.virtualmanager.com/employees/search?age_max={{ $i }}&age_min={{ $i }}&commit=S%C3%B8g&country_id=&job_status=1&page=1&search=1&speciality=coach&utf8=%E2%9C%93</span>--}}
{{--    <br>--}}
    <strong>{{ $i }} 2 coach</strong><br>
{{--    <span>https://www.virtualmanager.com/employees/search?age_max={{ $i }}&age_min={{ $i }}&commit=S%C3%B8g&country_id=&job_status=2&page=1&search=1&speciality=coach&utf8=%E2%9C%93</span>--}}
    <br>

    <strong>{{ $i }} 1 scout</strong><br>
{{--    <span>https://www.virtualmanager.com/employees/search?age_max={{ $i }}&age_min={{ $i }}&commit=S%C3%B8g&country_id=&job_status=1&page=1&search=1&speciality=scout&utf8=%E2%9C%93</span>--}}
{{--    <br>--}}
    <strong>{{ $i }} 2 scout</strong><br>
{{--    <span>https://www.virtualmanager.com/employees/search?age_max={{ $i }}&age_min={{ $i }}&commit=S%C3%B8g&country_id=&job_status=2&page=1&search=1&speciality=scout&utf8=%E2%9C%93</span>--}}
    <br>
@endfor