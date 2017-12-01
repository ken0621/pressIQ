<table class="table table-bordered table-striped table-condensed">
    <thead style="text-transform: uppercase">
        <tr>
            <th class="text-center">Plan Code</th>
            <th class="text-center">Point Log Name</th>
            <th class="text-center">Notification</th>
            <th class="text-center">Type</th>
            <th class="text-center">Type</th>
        </tr>
    </thead>
    <tbody>
        @foreach($settings as $setting)
        <tr id="{{$setting->point_log_setting_id}}">
            <td class="text-center">$setting->point_log_setting_plan_code</td>
            <td class="text-center">$setting->point_log_setting_name</td>
            <td class="text-center">$setting->point_log_notification</td>
            <td class="text-center">$setting->point_log_setting_type</td>
            <td class="text-center"><a>Modify</a></td>
        </tr>
        @endforeach
    </tbody>
</table>