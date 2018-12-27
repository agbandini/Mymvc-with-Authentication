<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- So that mobile will display zoomed in -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- enable media queries for windows phone 8 -->
        <meta name="format-detection" content="telephone=no"> <!-- disable auto telephone linking in iOS -->
        <title>%%SITE_NAME%%</title>
        <style>
            .header,
            .title,
            .subtitle,
            .footer-text {
                font-family: Helvetica, Arial, sans-serif;
            }

            .header {
                font-size: 24px;
                font-weight: bold;
                padding-bottom: 12px;
                color: #DF4726;
            }

            .footer-text {
                font-size: 12px;
                line-height: 16px;
                color: #aaaaaa;
            }
            .footer-text a {
                color: #aaaaaa;
            }

            .container {
                width: 600px;
                max-width: 600px;
            }

            .container-padding {
                padding-left: 24px;
                padding-right: 24px;
            }

            .content {
                padding-top: 12px;
                padding-bottom: 12px;
                background-color: #ffffff;
            }

            code {
                background-color: #eee;
                padding: 0 4px;
                font-family: Menlo, Courier, monospace;
                font-size: 12px;
            }

            hr {
                border: 0;
                border-bottom: 1px solid #cccccc;
            }

            h1 {
                color: #DF4726;
            }

            .hr {
                height: 1px;
                border-bottom: 1px solid #cccccc;
            }

            .title {
                font-size: 18px;
                font-weight: 600;
                color: #374550;
            }

            .subtitle {
                font-size: 16px;
                font-weight: 600;
                color: #2469A0;
            }
            .subtitle span {
                font-weight: 400;
                color: #999999;
            }

            .body-text {
                font-family: Helvetica, Arial, sans-serif;
                font-size: 14px;
                line-height: 20px;
                text-align: left;
                color: #333333;
            }

            body {
                margin: 0;
                padding: 0;
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
            }

            table {
                border-spacing: 0;
            }

            table td {
                border-collapse: collapse;
            }

            .ExternalClass {
                width: 100%;
            }

            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
                line-height: 100%;
            }

            .ReadMsgBody {
                width: 100%;
                background-color: #ebebeb;
            }

            table {
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt;
            }

            img {
                -ms-interpolation-mode: bicubic;
            }

            .yshortcuts a {
                border-bottom: none !important;
            }

            @media screen and (max-width: 599px) {
                table[class="force-row"],
                table[class="container"] {
                    width: 100% !important;
                    max-width: 100% !important;
                }
            }
            @media screen and (max-width: 400px) {
                td[class*="container-padding"] {
                    padding-left: 12px !important;
                    padding-right: 12px !important;
                }
            }
            .ios-footer a {
                color: #aaaaaa !important;
                text-decoration: underline;
            }

        </style>
    </head>
    <body style="margin:0; padding:0;" bgcolor="#F0F0F0" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

        <!-- 100% background wrapper (grey background) -->
        <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" bgcolor="#F0F0F0">
            <tr>
                <td align="center" valign="top" bgcolor="#F0F0F0" style="background-color: #F0F0F0;">

                    <br>

                    <!-- 600px container (white background) -->
                    <table border="0" width="600" cellpadding="0" cellspacing="0" class="container">
                        <tr>
                            <td class="container-padding header" align="left">
                                %%SITE_NAME%%
                            </td>
                        </tr>
                        <tr>
                            <td class="container-padding content" align="left">
                                <br>

                                <div class="title">Recupero password %%SITE_NAME%%!</div>
                                <br>

                                <div class="body-text">

                                    Salve, è stata richiesta una nuova password di accesso per %%SITE_NAME%%
                                    <br><br>
                                    Di seguito i nuovi dati di accesso, <br />
                                    <br>
                                    <b>La tua Email:</b> %%EMAIL%%
                                    <br><br>
                                    <b>La tua nuova password:</b> %%PASSWORD%%
                                    <br><br>Puoi effettuare il login direttamente da <a href="%%SITE_URL%%" target="_blank">qui</a>!
                                    <br><br>Per qualsiasi informazione e/o richiesta di supporto puoi scriverci su <a href="mailto:%%CUSTOMER_EMAIL%%">%%CUSTOMER_EMAIL%%</a>
                                    <br>
                                    Grazie per la preferenza accordataci, %%SITE_NAME%%.<br><br>
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <td class="container-padding footer-text" align="left">
                                <br><br>
                                Attenzione! Messaggio generato automaticamente, non rispondere a questa email.
                                <br><br>

                                <strong>%%SITE_NAME%%</strong><br>
                                <span class="ios-footer">
                                    -<br>
                                    -<br>
                                </span>
                                <br><br>

                                <a href="%%SITE_URL%%">%%SITE_NAME%%</a><br>
                            </td>
                        </tr>
                    </table><!--/600px container -->


                </td>
            </tr>
        </table><!--/100% background wrapper-->

    </body>
</html>