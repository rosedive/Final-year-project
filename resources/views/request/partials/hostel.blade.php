<div class="row">
    <div class="col-md-12">
        <h2>Hostels checking</h2>
    </div>
    <div class="col-md-12">
        <table border="1" cellpadding="5" width="100%">
            <tr>
                <td class="text-center" colspan="20"><strong>Academic Year</strong></td>
            </tr>
            <tr>
                <td class="text-center" width="16%"><strong>Level</strong></td>
                <td class="text-center" width="28%">Year 1</td>
                <td class="text-center" width="28%">Year 2</td>
                <td class="text-center" width="28%">Year 3</td>
            </tr>
            <tr>
                <td class="text-center" width="16%"><strong>Debit</strong></td>
                <td class="text-center" width="28%">
                    <span class="text-{{$res['y1code']}}">
                        <strong>{{$res['y1debt'] !='' ? 'Rwf '. $res['y1debt'] : $res['y1note']}}</strong>
                    </span>
                </td>
                <td class="text-center" width="28%">
                    <span class="text-{{$res['y2code']}}">
                        <strong>{{$res['y2debt'] !='' ? 'Rwf '. $res['y2debt'] : $res['y2note']}}</strong>
                    </span>
                </td>
                <td class="text-center" width="28%">
                    <span class="text-{{$res['y3code']}}">
                        <strong>{{$res['y3debt'] !='' ? 'Rwf '. $res['y3debt'] : $res['y3note']}}</strong>
                    </span>
                </td>
            </tr>
        </table>

        <p class="mt-4">System decision: 
            <span class="text-{{$res['sys_code']}}">{{$res['sys_decision']}}</span>
        </p>
    </div>
</div>