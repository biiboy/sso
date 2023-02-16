<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

</head>

<body class="" style="background-color: #ffffff; font-family: sans-serif; font-size: 16px;">
    <table style="background-color: #ffffff;">
        <td class="container" style="font-family: sans-serif; font-size: 16px;">
            <div>
                <!-- START CENTERED WHITE CONTAINER -->
                <table class="main" style="background: #ffffff;">

                    <!-- START MAIN CONTENT AREA -->
                    <tr>
                        <td class="wrapper" style="font-family: sans-serif; font-size: 16px; text-align: justify;">
                            <table>
                                <tr>
                                    <td style="font-family: sans-serif; font-size: 16px;">
                                        <p
                                            style="font-family: sans-serif; font-size: 16px; font-weight: normal; Margin-bottom: 15px;">
                                            Dear <b>{{ $name_manager }},</p>
                                        <p
                                            style="font-family: sans-serif; font-size: 16px; font-weight: normal; margin: 0; Margin-bottom: 15px;">
                                            <b>{{ $name_coor }}</b> has submitted KPI on <?php date_default_timezone_set('Asia/Jakarta');
                                            echo date('d-M-Y H:i A'); ?> and need
                                            your <a style="color:blue;text-decoration: underline;"
                                                href="{{ route('assessment_all_approval_approval', ['id' => $crement]) }}">review</a>.
                                        </p>


                                        <!-- Key Result Area -->
                                        <p
                                            style="font-family: sans-serif; font-size: 16px; font-weight: normal; margin: 0;">
                                            <b>Key Result Area:</b>
                                        </p>
                                        <p
                                            style="font-family: sans-serif; font-size: 16px; font-weight: normal; margin: 0; Margin-bottom: 15px;">
                                            {{ $k_label }}</p>

                                        <!-- Goal -->
                                        <p
                                            style="font-family: sans-serif; font-size: 16px; font-weight: normal; margin: 0;">
                                            <b>Goal:</b>
                                        </p>
                                        <p
                                            style="font-family: sans-serif; font-size: 16px; font-weight: normal; margin: 0; Margin-bottom: 15px;">
                                            {!! $goal !!}</p>

                                        <!-- Target Date -->
                                        <p
                                            style="font-family: sans-serif; font-size: 16px; font-weight: normal; margin: 0;">
                                            <b>Target Date:</b>
                                        </p>
                                        <p
                                            style="font-family: sans-serif; font-size: 16px; font-weight: normal; margin: 0; Margin-bottom: 15px;">
                                            {{ date('d-M-Y', strtotime($k_targetdate)) }}</p>

                                        <!-- Due Date -->
                                        <p
                                            style="font-family: sans-serif; font-size: 16px; font-weight: normal; margin: 0;">
                                            <b>Due Date For First Tactical Step:</b>
                                        </p>
                                        <p
                                            style="font-family: sans-serif; font-size: 16px; font-weight: normal; margin: 0; Margin-bottom: 15px; color: red;">
                                            {{ date('d-M-Y', strtotime($kd_duedate)) }}</p>

                                        <!-- Collaboration -->
                                        <p
                                            style="font-family: sans-serif; font-size: 16px; font-weight: normal; margin: 0;">
                                            <b>Collaboration:</b>
                                        </p>
                                        <p
                                            style="font-family: sans-serif; font-size: 16px; font-weight: normal; margin: 0; Margin-bottom: 15px;">
                                            @if ($k_collab_helpdesk == 'ya' && $k_collab_assets == null && $k_collab_support == null)
                                                <label class="page-title">IT Helpdesk </label>
                                            @elseif ($k_collab_helpdesk == 'ya' && $k_collab_assets == 'ya' && $k_collab_support == null)
                                                <label class="page-title">IT Asset dan Helpdesk</label>
                                            @elseif ($k_collab_helpdesk == 'ya' && $k_collab_assets == null && $k_collab_support == 'ya')
                                                <label class="page-title">IT Support dan IT Helpdesk</label>
                                            @elseif ($k_collab_helpdesk == 'ya' && $k_collab_assets == 'ya' && $k_collab_support == 'ya')
                                                <label class="page-title">All IT Services</label>
                                            @endif

                                            {{-- Collab sama IT ASset --}}
                                            @if ($k_collab_helpdesk == null && $k_collab_assets == 'ya' && $k_collab_support == null)
                                                <label class="page-title">IT Asset </label>
                                            @elseif ($k_collab_helpdesk == null && $k_collab_assets == 'ya' && $k_collab_support == 'ya')
                                                <label class="page-title">IT Asset dan IT Support</label>
                                            @elseif ($k_collab_helpdesk == null && $k_collab_assets == null && $k_collab_support == 'ya')
                                                <label class="page-title">IT Support</label>
                                            @endif

                                            @if ($k_collab_helpdesk == null && $k_collab_assets == null && $k_collab_support == null)
                                                <label class="page-title">-</label>
                                            @endif
                                        </p>



                                        <p
                                            style="font-family: sans-serif; font-size: 16px; font-weight: normal; margin: 0;">
                                            Performance Appraisal</p>
                                        <p
                                            style="font-family: sans-serif; font-size: 16px; font-weight: bold; margin: 0; Margin-bottom: 15px;">
                                            IT Services - PT. Gudang Garam Tbk.</p>
                                    </td>
                                </tr>
                            </table>


                        </td>
                    </tr>
                    <!-- END MAIN CONTENT AREA -->
                </table>

                <!-- END CENTERED WHITE CONTAINER -->
            </div>
        </td>
        <td style="font-family: sans-serif; font-size: 16px; vertical-align: top;">&nbsp;</td>
        </tr>
    </table>
</body>

</html>
