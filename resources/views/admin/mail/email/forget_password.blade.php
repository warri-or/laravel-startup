@extends('EmailTemplate.mail_template')
@section('preview_text', 'Please click on the following link or paste the link on address bar of your browser to reset your password.')
@section('content')
    <tr>
        <!-- Bulletproof Background Images c/o https://backgrounds.cm -->
        <td background="{{asset('mailtemplate/background.png')}}" bgcolor="#222222" align="center" valign="top"
            style="text-align: center; background-position: center center !important; background-size: cover !important;">
            <!--[if gte mso 9]>
            <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false"
                    style="width:680px; height:380px; background-position: center center !important;">
                <v:fill type="tile" src="background.png" color="#222222"/>
                <v:textbox inset="0,0,0,0">
            <![endif]-->
            <div>
                <!--[if mso]>
                <table role="presentation" border="0" cellspacing="0" cellpadding="0" align="center" width="500">
                    <tr>
                        <td align="center" valign="middle" width="500">
                <![endif]-->
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" width="100%"
                       style="max-width:500px; margin: auto;">
                    <tr>
                        <td height="20" style="font-size:20px; line-height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center" valign="middle">
                            <table>
                                <tr>
                                    <td valign="top" style="text-align: center; padding: 60px 0 10px 20px;">
                                        <h1 style="margin: 0; font-family: 'IBM Plex Sans', sans-serif; font-size: 30px;
                                     line-height: 36px; color: #ffffff; font-weight: bold;">
                                            WELCOME, {{ isset($name) ? $name : ''}}</h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top" style="text-align: center; padding: 10px 20px 15px 20px;
                                 font-family: sans-serif; font-size: 15px; line-height: 20px; color: #757575;">
                                        <p style="margin: 0;">{{__('Please click on the following link or paste the link on address bar of your browser to reset your password.')}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top" align="center"
                                        style="text-align: center; padding: 15px 0px 60px 0px;">
                                        <table role="presentation" align="center" cellspacing="0" cellpadding="0"
                                               border="0" class="center-on-narrow" style="text-align: center;">
                                            <tr>
                                                <td style="border-radius: 50px; background: #17A2B8; text-align: center;"
                                                    class="button-td">
                                                    <a href="{{url('forget-password-change/'.$remember_token)}}"
                                                       style="background: #17A2B8; border: 15px solid #17A2B8; font-family: 'IBM Plex Sans', sans-serif; font-size: 14px; line-height: 1.1; text-align: center; text-decoration: none; display: block; border-radius: 50px; font-weight: bold;"
                                                       class="button-a">
                                                        <span style="color:#ffffff;"
                                                              class="button-link"> {{__('Password Recovery')}}</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top"
                                        style="text-align: center; padding: 10px 20px 15px 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #757575;">
                                        <p style="margin: 0;">{{__('Thank You')}}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="20" style="font-size:20px; line-height:20px;">&nbsp;</td>
                    </tr>

                </table>
                <!--[if mso]>
                </td>
                </tr>
                </table>
                <![endif]-->
            </div>
            <!--[if gte mso 9]>
            </v:textbox>
            </v:rect>
            <![endif]-->
        </td>
    </tr>
@endsection
