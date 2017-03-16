
<style type="text/css">
	body{
		font-size:9pt;
		font-family:Calibri;
	}

	.footer div{
		font-family:Arial;
		font-size:5pt;
	}

	.tbl-info tbody tr td{
		font-size:11pt;
		padding: 10px;
		border:1px solid black;
	}

	.tbl-terms tr td{
		font-size:9pt;
	}

	.tbl-addlinfo tr td{
		font-size:11pt;
		margin:0;
		line-height:1.0;
	}

	.footer div{
		font-family:Arial;
		font-size:5pt;
	}

	.footer, .header{
		display:none;
	}

	@media  print{
		body { margin:0px; }

		.header{
			display: block;
			position: fixed;
			padding-top: 10px;
			height: 100px;
			margin: auto;
		}

		.footer{
			display:block;
			position: fixed;
			width:100%;
			bottom: 0;
		}

		.next-page{page-break-after:always}
	}

	@page  { margin: 2mm; }
</style>

<div class="header">

	<img style="width:35%; float:left;" src="{{ url('img/newsim_logo.jpg') }}"/>

	<div style="float:right; width:65%; padding-top:5px;">

		<span style="font-size:14pt; font-family:Arial; font-weight:bold;">NEW SIMULATOR CENTER OF THE PHILIPPINES, INC.</span><br/>

		<span style="font-size:9pt; font-family:Arial; font-style:italic;">The Preferred Training and Assessment Center</span>

	</div>

	<img style="width:100%; height:10%; margin-top: 5px;" src="{{ url('img/newsim_line_bar.png') }}" />

</div>

<div style="width:90%; margin:auto; padding-top: 85px;">

	<div style="text-align:center; font-size:12pt; font-weight:normal; margin-bottom:7px;">REVISION REQUEST

		<table class="tbl-info" style="width:100%; border: 1px solid; border-bottom: 0px; margin-top: 7px;">
			<tbody>
				<tr>

					<td style="width:65%;">
						<div>
							Date: &nbsp;&nbsp;{{ $revisionRequest->created_at->toFormattedDateString() }} <br>
							To: {{ $revisionRequest->reference_document->title }} <br>
							From: {{ $revisionRequest->user_name }}
						</div>
					</td>

					<td style="width:35%;">
						<div>
							Revision Request No: <br> NCPi-QM-566-2
						</div>
					</td>

				</tr>
			</tbody>
		</table>

		<table class="tbl-info" style="width:100%; border: 1px solid; border-top: 0px; margin-bottom: 10px;">
			<tbody>
				<tr>
					<td>
						<div>
							Section A: Formal Requests <br>
							This is to formalize a request for a revision to the document as follows: <br> <br>
							Section / Procedure / Page Number: {{ $revisionRequest->reference_document_tags }} <br>
							Revision Date / Status: &nbsp;&nbsp;<text style="border-bottom: 1px solid black;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</text> <br>
							Proposed Revision Details: &nbsp;&nbsp; (Please see the attached file at the back.) <br>
							Reason for Revision: {{ $revisionRequest->revision_reason }} <br>

						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div>
							Section B: QMR's Recommendation <br>
							For Approval/Disapproval (Delete as Appropriate) <br>
							Reason for Recommendation: {{ $revisionRequest->section_b->recommendation_reason }} <br><br>
							Signature of QMR: <text style="border-bottom: 1px solid black;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</text>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date: {{ $revisionRequest->section_b->created_at->toFormattedDateString()}}
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div>
							Section C: Approval / Disapproval <br>
							For Approval/Disapproval (Delete as Appropriate) <br>
							<div style="width: 100%px; border-bottom: 1px solid black; margin-top: 22px;">

							</div> <br>
							Signature of Chief Executive Officer: <text style="border-bottom: 1px solid black;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</text>&nbsp;&nbsp;&nbsp;&nbsp;
							Date: <text style="border-bottom: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</text>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div>
							Section D: Action Taken <br>
							Document Revised/Up-dated/Distributed to Holders (Delete as Appropriate)/Others <br>
							(Please Specify)		: <text style="border-bottom: 1px solid black;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</text><br>
							<div style="width: 100%px; border-bottom: 1px solid black; margin-top: 22px;"></div> <br>
							<div style="width: 100%px; border-bottom: 1px solid black;"></div> <br>
							Signature of QMR: <text style="border-bottom: 1px solid black;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</text>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date:

						</div>
					</td>
				</tr>
			</tbody>
		</table>

		<div class="" style="text-align:left;">
			NSCPi-QM-006-07/10July2015
		</div>

	</div>

</div>

<div class="footer" style="height:100px;">
	<img style="width:100%; height:10%;" src="{{ url('img/newsim_line_bar.png') }}"/>
	<div style="width:2.5%; float:left;">&nbsp;</div>
	<div style="width:80%; float:left;">
		<div style="width:100%; margin-top:7px;">
			<div style="width:21%; float:left;">
				<b>NEWSIM EDISON</b><br/>
				5F 2053 Bldg. Edison St.<br/>
				Brgy. San Isidro, Makati City 1234<br/>
				<b>Tel #:</b> (02) 8432864
			</div>

			<div style="width:22%; float:left;">
				<b>NEWSIM TRAINING ACADEMY</b><br/>
				Monte Vista Beach Resort<br/>
				Brgy.Bignay 2 Sariaya Quezon 4322<br/>
				<b>Tel #</b>: 2451195 or 8884544
			</div>

			<div style="width:22%; float:left;">
				<b>NEWSIM BACOLOD</b><br/>
				3F LKC Bldg. Locsin-Burgos St.<br/>
				Brgy. 11 Bacolod City 6100<br/>
				<b>Tel #:</b> (034) 4350701
			</div>

			<div style="width:35%; float:left;">
				<b>NEWSIM DAVAO</b><br/>
				3F Court View Hotel, Pink Walters Bldg, Quimpo Blvd.<br/>
				Matina Davao City 8000<br/>
				<b>Tel #:</b> (082) 2850224; +63 (915) 1084078
			</div>
		</div>

		<br/><br/><br/><br/>

		<div style="width:100%; margin-top:7px;">
			<div style="width:21%; float:left;">
				<b>NEWSIM MARCONI</b><br/>
				2323 NEWSIM Bldg. Marconi St.<br/>
				Brgy. San Isidro, Makati City 1234<br/>
				<b>Tel #:</b> (02) 8882764<br/>
				<b>Fax #:</b> (02) 8872759
			</div>

			<div style="width:22%; float:left;">
				<b>NEWSIM ILOILO</b><br/>
				2F 402 Arguelles Bldg. E. Lopez St.<br/>
				Jaro, Iloilo City 5000<br/>
				<b>Tel #:</b> (033) 3203776
			</div>

			<div style="width:22%; float:left;">
				<b>NEWSIM CEBU</b><br/>
				6F 731 Bldg. Escario St.<br/>
				Brgy. Capitol Site, Cebu City 6000<br/>
				<b>Tel #:</b> (032) 5203141 or 5203747<br/>
				+63 (917) 6294142
			</div>

			<div style="width:35%; float:left;">
				<b>NEWSIM CEBU Annex</b>             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Website:</b> www.newsim.ph<br/>
				3F Capitol Square, Escario St.       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>E-mail:</b> info@newsim.ph<br/>
				Brgy. Capitol Site, Cebu City 6000<br/>
				<b>Tel #:</b> (032) 5203141 or 5203747<br/>
				+63 (917) 6294142
			</div>
		</div>
	</div>
	<div style="width:15%; float:right;">
		<br/><br/>
		<img style="width:60%;"  src="{{ url('img/footer_logos.png') }}" />
	</div>
</div>
<script type="text/javascript" src="{{ url('js/plugins/jquery/jquery.min.js') }}"></script>
<script type="text/javascript">
	$(function(){window.print();});
</script>
