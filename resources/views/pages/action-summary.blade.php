    <script src="https://use.fontawesome.com/bfaff207b9.js"></script>

    <style type="text/css">

        span.box {
            margin-left: 10px;
        }

        .footer div{
            font-family:Arial;
            font-size:5pt;
        }

        .tbl-info tr td{
            padding: 3px;
            font-size:9pt;
            padding-left:5px;
            border:1px solid black;
            width: 800px;
        }

        .footer div{
            font-family:Arial;
            font-size:5pt;
        }

        .footer, .header{
            display:none;
        }

        @media    print{
            body { margin: 0px; }

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
        }

        @page    { margin: 2mm; }

    </style>

    <div class="header">
        <img style="width:35%; float:left;" src="{{ url('img/newsim_logo.jpg') }}"/>

        <div style="float:right; width:65%; padding-top:5px;">
            <span style="font-size:14pt; font-family:Arial; font-weight:bold;">NEW SIMULATOR CENTER OF THE PHILIPPINES, INC.</span><br/>
            <span style="font-size:9pt; font-family:Arial; font-style:italic;">The Preferred Training and Assessment Center</span>
        </div>

        <img style="width:100%; height:10%; margin-top: 5px;" src="{{ url('img/newsim_line_bar.png') }}" />
    </div>


<div style="display: block; width:90%; margin: auto; padding-top: 50px;">
    <span>&nbsp;</span>
    <table class="tbl-info" style="width:100%; border-collapse:collapse;">
        <tbody>
            <tr>
                <td colspan="10" align="center">CORRECTIVE AND PREVENTIVE ACTION REPORT FORM</td>
            </tr>
            <tr>
                <td colspan="6" align="center">RAISED BY</td>
                <td colspan="4">CPAR#: {{ $cpar->cpar_number or '&nbsp;' }}</td>
            </tr>
            <tr>
                <td>NAME</td>
                <td>{{ $cpar->person_reporting }}</td>
                <td style="border-left-style: hidden;">&nbsp;</td>
                <td style="border-left-style: hidden;">&nbsp;</td>
                <td style="border-left-style: hidden;">&nbsp;</td>
                <td style="border-left-style: hidden;">&nbsp;</td>
                <td style="border-left-style: hidden;">&nbsp;</td>
                <td style="border-left-style: hidden;">&nbsp;</td>
                <td style="border-left-style: hidden;">&nbsp;</td>
                <td style="border-left-style: hidden;">&nbsp;</td>
            </tr>
            <tr>
                <td>DEPARTMENT</td>
                <td colspan="9">{{ $cpar->department }}</td>
            </tr>
            <tr>
                <td>BRANCH</td>
                <td colspan="9">{{ $cpar->branch }}</td>
            </tr>
            <tr>
                <td colspan="10" align="center">SEVERITY OF FINDINGS (marked checked)</td>
            </tr>
            <tr>
                <td colspan="10">
                    <span style="margin-left: 100px">MAJOR</span><span class="@if(strip_tags($cpar->severity) == 'Major') fa fa-check-square-o @else fa fa-square-o @endif box"></span>
                    <span style="margin-left: 140px">MINOR</span><span class="@if(strip_tags($cpar->severity) == 'Minor') fa fa-check-square-o @else fa fa-square-o @endif box"></span>
                    <span style="margin-left: 140px">OBSERVATION</span><span class="@if(strip_tags($cpar->severity) == 'Observation') fa fa-check-square-o @else fa fa-square-o @endif box"></span>
                </td>
            </tr>
            <tr style="border-bottom-style: hidden;">
                <td colspan="10">PROCEDURE /PROCESS / SCOPE / OTHER REFERENCES:</td>
            </tr>
            <tr style="border-top-style: hidden;">
                <td colspan="10">{{ $cpar->other_source }}</td>
            </tr>
            <tr>
                <td colspan="10" align="center">SOURCE OF NON-CONFORMITY (marked checked)</td>
            </tr>
            <tr>
                <td colspan="10">
                    <span style="margin-left: 80px">EXTERNAL</span><span class="@if($cpar->source == 'External') fa fa-check-square-o @else fa fa-square-o @endif box"></span>
                    <span style="margin-left: 100px">INTERNAL</span><span class="@if($cpar->source == 'Internal') fa fa-check-square-o @else fa fa-square-o @endif box"></span>
                    <span style="margin-left: 80px">OPERATIONAL PERFORMANCE</span><span class="@if($cpar->source == 'Operational Performance') fa fa-check-square-o @else fa fa-square-o @endif box"></span>
                    <span style="margin-left: 150px">CUSTOMER FEEDBACK</span><span class="@if($cpar->source == 'Customer Feedback') fa fa-check-square-o @else fa fa-square-o @endif box"></span>
                    <span style="margin-left: 80px">CUSTOMER COMPLAIN</span><span class="@if($cpar->source == 'Customer Complain') fa fa-check-square-o @else fa fa-square-o @endif box"></span>
                </td>
            </tr>
            <tr style="border-bottom-style: hidden;">
                <td colspan="10">OTHERS: (Please specify)</td>
            </tr>
            <tr style="border-top-style: hidden;">
                <td colspan="10">{{ $cpar->other_source }}</td>
            </tr>
            <tr style="border-bottom-style: hidden;">
                <td colspan="10">DETAILS:</td>
            </tr>
            <tr style="border-top-style: hidden;">
                <td colspan="10">{{ $cpar->details }}</td>
            </tr>
            <tr>
                <td colspan="10">NAME: (PERSON REPORTING TO NON-CONFORMITY)</td>
            </tr>
            <tr>
                <td colspan="10">{{ $cpar->person_reporting or '&nbsp;' }}</td>
            </tr>
            <tr>
                <td colspan="10">NAME: (PERSON RESPONSIBLE FOR TAKING THE CPAR)</td>
            </tr>
            <tr>
                <td colspan="10">{{ $cpar->person_responsible or '&nbsp;' }}</td>
            </tr>
            <tr style="border-bottom-style: hidden;">
                <td colspan="10">CORRECTION (Action to eliminate detected non-conformity)</td>
            </tr>
            <tr style="border-top-style: hidden;">
                <td colspan="10">{{ $cpar->correction or '&nbsp;' }}</td>
            </tr>
            <tr style="border-bottom-style: hidden;">
                <td colspan="10">ROOT CAUSE ANALYSIS (What failed in the system to allow this non conformance to occur?)</td>
            </tr>
            <tr style="border-top-style: hidden;">
                <td colspan="10">{{ $cpar->root_cause or '&nbsp;' }}</td>
            </tr>
            <tr style="border-bottom-style: hidden;">
                <td colspan="10">CORRECTIVE/PREVENTIVE ACTION: (Specific details of corrective action taken to prevent recurrence/ occurrence)</td>
            </tr>
            <tr style="border-top-style: hidden;">
                <td colspan="10">{{ $cpar->cp_action or '&nbsp;' }}</td>
            </tr>
            <tr>
                <td colspan="5">PROPOSED CORRECTIVE ACTION COMPLETE DATE:<br>{{ Carbon\Carbon::parse($cpar->proposed_date)->toFormattedDateString() }}</td>
                <td colspan="5">CORRECTIVE / PREVENTIVE ACTION COMPLETE DATE: {{ Carbon\Carbon::parse($cpar->date_completed)->toFormattedDateString() }}</td>
            </tr>
            <tr>
                <td colspan="5">DEPARTMENT HEAD:</td>
                <td colspan="5">DATE CONFIRMED BY DEPARTMENT HEAD:</td>
            </tr>
            <tr>
                <td colspan="5" style="border-top-style: hidden;">{{ $cpar->department_head or '&nbsp;' }}</td>
                <td colspan="5" style="border-top-style: hidden;">{{ \Carbon\Carbon::parse($cpar->date_confirmed)->toFormattedDateString() }}</td>
            </tr>
        </tbody>
    </table>
</div>

    <div style="display: block; width:90%; margin: auto; padding-top: 50px; page-break-before: always;">
        <table class="tbl-info" style="width:100%; border-collapse:collapse;">
            <tbody>
            <tr>
                <td colspan="10" align="center">TO BE FILLED BY THE QMR / AUDITOR</td>
            </tr>
            <tr>
                <td colspan="10">ACCEPTANCE OF CPAR (Comments if any)</td>
            </tr>
            <tr>
                <td colspan="10">{{ $cpar->cpar_acceptance or '&nbsp;'}}</td>
            </tr>
            <tr>
                <td colspan="5">DATE CPAR ACCEPTED:</td>
                <td colspan="5">NAME & SIGNATURE: (QMR/ AUDITOR / CEO)</td>
            </tr>
            <tr>
                <td colspan="5" style="border-top-style: hidden;">{{ Carbon\Carbon::parse($cpar->date_accepted)->toFormattedDateString() }}</td>
                <td colspan="5" style="border-top-style: hidden;">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5">VERIFICATION DATE:</td>
                <td colspan="5">VERIFIED BY:</td>
            </tr>
            <tr>
                <td colspan="5" style="border-top-style: hidden;">{{ Carbon\Carbon::parse($cpar->date_verified)->toFormattedDateString() }}</td>
                <td colspan="5" style="border-top-style: hidden;">{{ $cpar->verified_by or '&nbsp;'}}</td>
            </tr>
            <tr style="border-bottom-style: hidden;">
                <td colspan="10">RESULT OF VERIFICATION:</td>
            </tr>
            <tr style="border-top-style: hidden;">
                <td colspan="10">{{ $cpar->result or '&nbsp;' }}</td>
            </tr>
            </tbody>
        </table>
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
