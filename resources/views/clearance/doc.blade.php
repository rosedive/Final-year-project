<!DOCTYPE html>
<html>
<head>
	<title>CLearance-{{$regno}}</title>
</head>

<style type="text/css">
	body {
		font-family: sans-serif;
		padding: 25px;
	}
	
	p {
		position: relative;
	}
	.title {
		font-size: 13px;
	}
	.center {
		text-align: center;
	}
	.b {
		font-weight: 600;
	}

	.data {
		position: absolute;
		left: 100px;
		top: 6px;
		font-weight: 600;
	}

	.data-2 {
		position: absolute;
		left: 170px;
		top: 6px;
		font-weight: 600;
	}

	.data-3 {
		position: absolute;
		left: 100px;
		top: -11px;
		font-weight: 600;
	}
    .footer {
        position: fixed; 
        left: 25px;
        right: 25px;
        bottom: 25px;
        width: 100%;
        text-align: center;
        background: #000;
        color: #fff;
        padding: 4px;
        font-style: italic;
        font-weight: 600;
    }
</style>
<body>
	<table width="100%" style="font-size: 11px;">
		<tr>
			<td valign="center" width="10%">
				<img src="{{ public_path().'\assets\img\logo.png' }}" alt="Logo" height="80">
			</td>
			<td valign="center" width="50%" style="padding-left: 20px;">
				<h1>IPRC KIGALI</h1>
				Integrated Polytechnic Regional College
			</td>
			<td valign="bottom">
				P.O Box: 6579 Kigali-Rwanda<br>
				KK 13 Rd kigali<br>
				Tel: 25025520063<br>
				E-mail: info@iprckigali.ac.rw<br>
				www.iprckigali.ac.rw
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<hr>
			</td>
	</table>

	<h3>CLEARANCE FROM</h3>

	<p>
		<span class="data">{{$names}}</span>
		<span class="title">
			Name of <br>Student:....................................................................................................................................................
		</span>
	</p>
	<p>
		<span class="data">{{$regno}}</span>
		<span class="title">
			Registration <br>Number:....................................................................................................................................................
		</span>
	</p>
	<p>
		<span class="data-2">{{$sponsor}}</span>
		<span class="title">
			Government / Private <br>Student:....................................................................................................................................................
		</span>
	</p>
	<p>
		<span class="data-3">{{$department}}</span>
		<span class="title">
			Department:.............................................................................................................................................
		</span>
	</p>
	<p>
		<span class="data">{{$option}} ({{$program}})</span>
		<span class="title">
			Option <br>(Program):................................................................................................................................................
		</span>
	</p>
	<p>
		<span class="data">{{$level}}</span>
		<span class="title">
			Academic <br>Year:.........................................................................................................................................................
		</span>
	</p>
	<p>
		<span class="data-3">{{$phone}}</span>
		<span class="title">
			Phone:......................................................................................................................................................
		</span>
	</p>
	<h3>Reason for clearance</h3>
	<table border="1" cellpadding="5" cellspacing="0" width="100%" style="font-size: 13px;">
		<tr>
			<td>Graduation</td>
			<td class="center b">{{$graduation}}</td>
		</tr>
		<tr>
			<td>Suspension / Postponent studies</td>
			<td class="center b">{{$supension}}</td>
		</tr>
		<tr>
			<td>Issue of certificate / To whom it may concern / Transcript / Diploma</td>
			<td class="center b">{{$issue}}</td>
		</tr>
	</table>
	<br>
	<table border="1" cellpadding="5" cellspacing="0" width="100%" style="font-size: 13px;">
		<tr>
			<th>Office in charge</th>
			<th class="center">Date</th>
			<th class="">Name of Officer</th>
			<th class="center">Remarks</th>
		</tr>
		<tr>
			<td>Head of Department</td>
			<td class="center">{{date('Y-m-d', strtotime($hod_date))}}</td>
			<td class="">{{$hod_name}}</td>
			<td class="center b">{{$hod_remarks}}</td>
		</tr>
		<tr>
			<td>Director of students affairs</td>
			<td class="center">{{date('Y-m-d', strtotime($drsa_date))}}</td>
			<td class="">{{$drsa_name}}</td>
			<td class="center b">{{$drsa_remarks}}</td>
		</tr>
		<tr>
			<td>Chield of Librarian</td>
			<td class="center">{{date('Y-m-d', strtotime($lib_date))}}</td>
			<td class="">{{$lib_name}}</td>
			<td class="center b">{{$lib_remarks}}</td>
		</tr>
		<tr>
			<td>Addmission and Registration Officer</td>
			<td class="center">{{date('Y-m-d', strtotime($reg_date))}}</td>
			<td class="">{{$reg_name}}</td>
			<td class="center b">{{$reg_remarks}}</td>
		</tr>
		<tr>
			<td>Income controller</td>
			<td class="center">{{date('Y-m-d', strtotime($finance_date))}}</td>
			<td class="">{{$finance_name}}</td>
			<td class="center b">{{$finance_remarks}}</td>
		</tr>
	</table>

	<br><br>

	Verified by<br>
	Director of Finance


	<div class="footer">Skills that shape a better destiny</div>
</body>
</html>