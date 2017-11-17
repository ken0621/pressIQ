<table class="table table-bordered table-striped table-condensed">
    <thead style="text-transform: uppercase">
        <tr>
            <th class="text-center">Project Name</th>
            <th class="text-center">Project Type</th>
            <th class="text-center">Project Owner</th>
            <th class="text-center">Project Company E-Mail</th>
            <th class="text-center">Project Contact</th>
            @if(count($_project)!=0)
            <th class="text-center" colspan="2">Action</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @if(count($_project) == 0)
            <tr>
                <td class="text-center" colspan="5">NO DATA</td>
            </tr>
        @else
            @foreach($_project as $project)
            <tr project_id="{{ $project->project_id }}">
                <td class="text-center">{{ $project->project_name }}</td>
                <td class="text-center">{{ $project->project_type_name }}</td>
                <td class="text-center">{{ $project->project_email }}</td>
                <td class="text-center">{{ $project->project_email }}</td>
                <td class="text-center">{{ $project->project_contact }}</td>
                @if($project->archived==0)
                <td class="text-center"><a class="action-archive" href="javascript:">Archive</a></td>
                @else
                <td class="text-center"><a class="action-archive" href="javascript:">Restore</a></td>
                @endif
                <td class="text-center"><a class="action-modify" href="javascript:">Modify</a></td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>