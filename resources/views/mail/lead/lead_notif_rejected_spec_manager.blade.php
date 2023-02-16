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
                                            Dear <b>{{ $name_lead }},</b></p>

                                        @if ($k_created_by == 26 || $k_created_by == 27)
                                            <p
                                                style="font-family: sans-serif; font-size: 16px; font-weight: normal; margin: 0; Margin-bottom: 15px;">
                                                Your KPI has been rejected by <b>{{ $name_manager }}</b> on
                                                <?php date_default_timezone_set('Asia/Jakarta');
                                                echo date('d-M-Y H:i A'); ?>.</p>
                                        @else
                                            <p
                                                style="font-family: sans-serif; font-size: 16px; font-weight: normal; margin: 0; Margin-bottom: 15px;">
                                                <b>{{ $name_manager }}</b> has rejected KPI
                                                <b>
                                                    @if ($k_created_by == 25)
                                                        <label class="page-title">Firdaus Santoso</label>
                                                        {{-- @elseif ($k_created_by == 26)
                              <label class="page-title">Tjandra Hadiwidjaja</label>
                              @elseif ($k_created_by == 27)
                              <label class="page-title">Marini Susanti</label> --}}
                                                    @elseif ($k_created_by == 28)
                                                        <label class="page-title">Yudi Muji Prasetyo</label>
                                                    @elseif ($k_created_by == 29)
                                                        <label class="page-title">Syuchrisyanto Hari Susanto</label>
                                                    @elseif ($k_created_by == 30)
                                                        <label class="page-title">Muhammad Lukman</label>
                                                    @elseif ($k_created_by == 31)
                                                        <label class="page-title">Mohamad Faizal Rohman</label>
                                                    @elseif ($k_created_by == 32)
                                                        <label class="page-title">Hendra Yunianto Tri Sarjana</label>
                                                    @elseif ($k_created_by == 33)
                                                        <label class="page-title">Denok Puspitasari</label>
                                                    @elseif ($k_created_by == 34)
                                                        <label class="page-title">Febri Dwi Santoso</label>
                                                    @elseif ($k_created_by == 35)
                                                        <label class="page-title">Rony Febriadi</label>
                                                    @elseif ($k_created_by == 36)
                                                        <label class="page-title">Abdus Shahrir Rozaq</label>
                                                    @elseif ($k_created_by == 37)
                                                        <label class="page-title">Bondan Handoko</label>
                                                    @elseif ($k_created_by == 38)
                                                        <label class="page-title">Khasan Soleh</label>
                                                    @elseif ($k_created_by == 39)
                                                        <label class="page-title">Filsuf Hidayat</label>
                                                    @elseif ($k_created_by == 40)
                                                        <label class="page-title">Tri Margiono</label>
                                                    @elseif ($k_created_by == 41)
                                                        <label class="page-title">Tjahyadi Wijaya</label>
                                                    @elseif ($k_created_by == 42)
                                                        <label class="page-title">Gilang Tresna</label>
                                                    @elseif ($k_created_by == 43)
                                                        <label class="page-title">Marien Mutiara</label>
                                                    @elseif ($k_created_by == 44)
                                                        <label class="page-title">Ika Kurniasari</label>
                                                    @elseif ($k_created_by == 45)
                                                        <label class="page-title">Albertus Wellma Sandria Kusuma</label>
                                                    @elseif ($k_created_by == 46)
                                                        <label class="page-title">Dana Ardiansyah</label>
                                                    @elseif ($k_created_by == 47)
                                                        <label class="page-title">Serny Datu Rantetampang</label>
                                                    @elseif ($k_created_by == 48)
                                                        <label class="page-title">Ambar Hamim</label>
                                                    @elseif ($k_created_by == 49)
                                                        <label class="page-title">Chandra Kusuma</label>
                                                    @elseif ($k_created_by == 50)
                                                        <label class="page-title">Nanda Sabrina</label>
                                                    @elseif ($k_created_by == 51)
                                                        <label class="page-title">Nourma Yunita</label>
                                                    @elseif ($k_created_by == 52)
                                                        <label class="page-title">Novita Handariati</label>
                                                    @elseif ($k_created_by == 53)
                                                        <label class="page-title">Normiati</label>
                                                    @elseif ($k_created_by == 54)
                                                        <label class="page-title">Desy Zulfiany Juwita</label>
                                                    @elseif ($k_created_by == 55)
                                                        <label class="page-title">Dwi Handoko</label>
                                                    @elseif ($k_created_by == 56)
                                                        <label class="page-title">Hendrian Rajitama</label>
                                                    @elseif ($k_created_by == 57)
                                                        <label class="page-title">Stifanus Benny Sabdiyanto</label>
                                                    @elseif ($k_created_by == 58)
                                                        <label class="page-title">rendra Yuwono Wicaksono</label>
                                                    @elseif ($k_created_by == 59)
                                                        <label class="page-title">Liem Reza Johansaputra
                                                            Wananegara</label>
                                                    @elseif ($k_created_by == 60)
                                                        <label class="page-title">Alief Ghuruf Al Faris</label>
                                                    @elseif ($k_created_by == 61)
                                                        <label class="page-title">Afib Asyari</label>
                                                    @elseif ($k_created_by == 62)
                                                        <label class="page-title">Aditya Darmawan</label>
                                                    @elseif ($k_created_by == 63)
                                                        <label class="page-title">Abraham Kristianto</label>
                                                    @elseif ($k_created_by == 64)
                                                        <label class="page-title">Sigid Susetyo</label>
                                                    @elseif ($k_created_by == 65)
                                                        <label class="page-title">Vincentius Henry</label>
                                                    @elseif ($k_created_by == 66)
                                                        <label class="page-title">Charis Majid Teguh Pamadya</label>
                                                    @else
                                                        Something Wrong
                                                    @endif
                                                </b> on <?php date_default_timezone_set('Asia/Jakarta');
                                                echo date('d-M-Y H:i A'); ?>.
                                            </p>

                                        @endif



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
                                            <b>Justification:</b>
                                        </p>
                                        <p
                                            style="font-family: sans-serif; font-size: 16px; font-weight: normal; margin: 0; Margin-bottom: 15px;">
                                            {{ $k_justification_manager }}</p>



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
    </table>
</body>

</html>
