<div class="row">
    <div class="col-md-12">
        <h2>Registration checking</h2>
    </div>
    <div class="col-md-12">
        <table border="1" cellpadding="5" width="100%">
            <tr>
                <td class="text-center" colspan="20"><strong>Academic Year</strong></td>
            </tr>
            <tr>
                <td class="text-center" width="33%">Year 1</td>
                <td class="text-center" width="33%">Year 2</td>
                <td class="text-center" width="33%">Year 3</td>
            </tr>
            <tr>
                <td class="text-center">
                    <span class="text-{{ $res['y1code']}}">
                        {{ $res['y1note']}} <br>
                    </span>
                    <span>
                        {{ $res['y1aca']}}
                    </span>
                </td>
                <td class="text-center">
                    <span class="text-{{ $res['y2code']}}">
                        {{ $res['y2note']}} <br>
                    </span>
                    <span>
                        {{ $res['y2aca']}}
                    </span>
                </td>
                <td class="text-center">
                    <span class="text-{{ $res['y3code']}}">
                        {{ $res['y3note']}} <br>
                    </span>
                    <span>
                        {{ $res['y3aca']}}
                    </span>
                </td>
            </tr>
        </table>

        <p class="mt-4">System decision: 
            <span class="text-{{$res['sys_code']}}">{{$res['sys_decision']}}</span>
        </p>
    </div>
</div>