<div class="table-responsive">
    <table class="table table-hover table-bordered table-striped table-condensed">
        <thead>
            <tr>
                <th class="text-center">{{$title}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($_location as $location)
            <tr class="location_data">
                <td class="hidden location-id">{{ $location->locale_id}} </td>
                <td class="text-left">{{ $location->locale_name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>