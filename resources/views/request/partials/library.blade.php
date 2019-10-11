<div class="row">
    <div class="col-md-12">
        <h2>Library checking</h2>
    </div>
    <div class="col-md-12">
        <table border="1" cellpadding="5" width="100%">
            <tr>
                <td class="text-center" colspan="2"><strong>Books</strong></td>
            </tr>
            <tr>
                <td class="text-center" width="16%"><strong>Unreturned Books</strong></td>
                <td class="text-center" width="28%">
                    <span class="text-{{$res['uncode']}}">
                        <strong>{{$res['unreturned']}}</strong>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="text-center" colspan="2"><strong>Final Year Book</strong></td>
            </tr>
            <tr>
                <td class="text-center" width="28%" colspan="2">
                    @if($res['submitted'])
                        <span class="text-{{$res['subcode']}}">{{$res['subnote'] }}</span>
                    @else
                        <span class="text-{{$res['subcode']}}">{{$res['subnote'] }}</span>
                    @endif
                </td>
            </tr>
        </table>

        <p class="mt-4">System decision: 
            <span class="text-{{$res['sys_code']}}">{{$res['sys_decision']}}</span>
        </p>
    </div>
</div>