<div class="row">
    <div class="col-md-12">
        <h2>Finance checking</h2>
    </div>
    <div class="col-md-12">
        <table border="1" cellpadding="5" width="100%">
            <tr>
                <td class="text-center" width="31%" rowspan="2"><strong>Amount</strong></td>
                <td class="text-center" colspan="20"><strong>Academic Year</strong></td>
            </tr>
            <tr>
                <td class="text-center" width="23%">Year 1</td>
                <td class="text-center" width="23%">Year 2</td>
                <td class="text-center" width="23%">Year 3</td>
            </tr>
            <tr>
                <td class="text-center">Expected Amount</td>
                <td class="text-right" width="23%">
                    <span>{{$res['y1x'] !='' ? 'Rwf '. $res['y1x'] : ''}}</span>
                </td>
                <td class="text-right" width="23%">
                    <span>{{$res['y2x'] !='' ? 'Rwf '. $res['y2x'] : ''}}</span>
                </td>
                <td class="text-right" width="23%">
                    <span>{{$res['y3x'] !='' ? 'Rwf '. $res['y3x'] : ''}}</span>
                </td>
            </tr>
            <tr>
                <td class="text-center">Amount Paid</td>
                <td class="text-right" width="23%">
                    <span>{!! $res['y1note'] !!}</span>
                </td>
                <td class="text-right" width="23%">
                    <span>{!! $res['y2note'] !!}</span>
                </td>
                <td class="text-right" width="23%">
                    <span>{!! $res['y3note'] !!}</span>
                </td>
            </tr>
            <tr>
                <td class="text-center"><strong>TOTAL</strong></td>
                <td class="text-right">
                    <span class="text-{{$res['y1code']}}">
                        <strong>{{$res['total_yr1'] !='' ? 'Rwf '. $res['total_yr1'] : ''}}</strong>
                    </span>
                </td>
                <td class="text-right">
                    <span class="text-{{$res['y2code']}}">
                        <strong>{{$res['total_yr2'] !='' ? 'Rwf '. $res['total_yr2'] : ''}}</strong>
                    </span>
                </td>
                <td class="text-right">
                    <span class="text-{{$res['y3code']}}">
                        <strong>{{$res['total_yr3'] !='' ? 'Rwf '. $res['total_yr3'] : ''}}</strong>
                    </span>
                </td>
            </tr>
        </table>

        <p class="mt-4">Note:</p>
        <p>
            Year 1: 
            <span class="text-{{$res['y1code']}}"><strong>{{$res['y1note2']}}</strong></span><br>
            Year 2:
            <span class="text-{{$res['y2code']}}"><strong>{{$res['y2note2']}}</strong></span><br>
            Year 3:
            <span class="text-{{$res['y3code']}}"><strong>{{$res['y3note2']}}</strong></span><br>
        </p>

        <p class="mt-4">System decision: 
            <span class="text-{{$res['sys_code']}}">{{$res['sys_decision']}}</span>
        </p>
    </div>
</div>