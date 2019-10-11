<div class="row">
    <div class="col-md-12">
        <h2>Results checking</h2>
    </div>
    <div class="col-md-12">
        <table border="1" cellpadding="5" width="100%">
            <tr>
                <td class="text-center" width="31%" rowspan="2"><strong>Terms</strong></td>
                <td class="text-center" colspan="20"><strong>Academic Year</strong></td>
            </tr>
            <tr>
                <td class="text-center" width="23%">Year 1</td>
                <td class="text-center" width="23%">Year 2</td>
                <td class="text-center" width="23%">Year 3</td>
            </tr>
            <tr>
                <td class="text-center">Semester 1</td>
                <td class="text-center" width="23%">
                    {{ $res['year1_term1'] !='' ? $res['year1_term1'].'%' : ''}}
                </td>
                <td class="text-center" width="23%">
                    {{ $res['year2_term1'] !='' ? $res['year2_term1'].'%' : ''}}
                </td>
                <td class="text-center" width="23%">
                    {{ $res['year3_term1'] !='' ? $res['year3_term1'].'%' : ''}}
                </td>
            </tr>
            <tr>
                <td class="text-center">Semester 2</td>
                <td class="text-center">
                    {{ $res['year1_term2'] !='' ? $res['year1_term2'].'%' : ''}}
                </td>
                <td class="text-center">
                    {{ $res['year2_term2'] !='' ? $res['year2_term2'].'%' : ''}}
                </td>
                <td class="text-center">
                    {{ $res['year3_term2'] !='' ? $res['year3_term2'].'%' : ''}}
                </td>
            </tr>
            <tr>
                <td class="text-center"><strong>TOTAL</strong></td>
                <td class="text-center">
                    <span class="text-{{$res['total_yr1'] >= 50? 'success' : 'danger'}}">
                        <strong>{{$res['total_yr1'] !='' ? $res['total_yr1'] .'%' : ''}}</strong>
                    </span>
                </td>
                <td class="text-center">
                    <span class="text-{{$res['total_yr2'] >= 50? 'success' : 'danger'}}">
                        <strong>{{$res['total_yr2'] !='' ? $res['total_yr2'] .'%' : ''}}</strong>
                    </span>
                </td>
                <td class="text-center">
                    <span class="text-{{$res['total_yr3'] >= 50? 'success' : 'danger'}}">
                        <strong>{{$res['total_yr3'] !='' ? $res['total_yr3'] .'%' : ''}}</strong>
                    </span>
                </td>
            </tr>
        </table>

        <p class="mt-4">Note:</p>
        <p>
            Year 1: 
            <span class="text-{{$res['y1code']}}"><strong>{{$res['y1note']}}</strong></span><br>
            Year 2:
            <span class="text-{{$res['y2code']}}"><strong>{{$res['y2note']}}</strong></span><br>
            Year 3:
            <span class="text-{{$res['y3code']}}"><strong>{{$res['y3note']}}</strong></span><br>
        </p>

        <p class="mt-4">System decision: 
            <span class="text-{{$res['sys_code']}}">{{$res['sys_decision']}}</span>
        </p>
    </div>
</div>