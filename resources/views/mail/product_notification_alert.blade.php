<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Verification Email</title>
    <style type="text/css">
        body {
            Margin: 0;
            padding: 0;
            background: #f6f9fc;
        }
        table {
            border-spacing: 0;
        }
        td {
            padding: 0;
        }
        img {
            border: 0;
        }

        @media screen and (max-width: 600px) {
        }
        @media screen and (max-width: 400px) {
        }
    </style>
</head>
<body>
<center style="width: 100%;table-layout: fixed;background-color: #f6f9fc;">
    <div style="max-width: 600px;background-color: #FFFFFF;">
        <table style="Margin:0 auto;width: 100%;max-width:600px;font-family: sans-serif;color: #4a4a4a;" align="center">
            <tr>
                <td style="background-color: #6EC7E0;padding:20px 10px;">
                    <h2
                        style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;float:left;color:black;padding:6px 6px 6px 30px; margin-left:-10px;margin-top:5%;font-size: 15px;text-transform: uppercase;"
                    >New Product</h2>
                    <a href="https://martekgh.com" style="float: right;"><img src="https://1.bp.blogspot.com/-FN5gJQyz8Ns/YDifO6x-HhI/AAAAAAAAEzc/Q8D3s0dnU1MR1ZRgyWtDFCUuUhO4h1BMQCLcBGAsYHQ/s320/martlogo.png" alt="wapatron-logo" title="waPatron" style="height: 75px;width: auto;"></a>
                </td>
            </tr>

            <tr>
                <td style="padding:0px 20px;">
                    <p style="font-size: 14px;color: #25383C; font-weight: 400;font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">
                        <span style="font-weight: 700;font-size: 18px;">Hello {{$user->name}}!</span><br/><br/>
                        Thank you for shoping on martekgh.com.<br/>
                        <b>{{$merchandiser->company_name}}</b> has uploaded a new products in stock just for you.
                        <br/>
                        <br/>
                        Click on the below to view shop.
                    </p>
                </td>
            </tr>

            <tr>
                <td style="padding: 30px;text-align: center;">
                    <a 	style="background-color: white;border:3px solid #6EC7E0;text-decoration:none;color: #6EC7E0;font-size: 18px;font-weight: bold;padding: 12px 22px;border-radius: 15px;font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;"
                          href="martekgh.com/user/product-details/{{$product->id}}/{{$product->product_name}}" target="_blank">
                        View Shop
                    </a>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px;"></td>
            </tr>

            <tr>
                <td style="background-color:#6EC7E0;text-align: center;">
                    <h5><a style="color: black !important;font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;" href="https://wa-patron.com/support/">FAQS</a> | <a style="color: black !important;font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;" href="http://form.123formbuilder.com/5595600/form">FEEDBACK</a></h5>
                    <h5><a style="color: black !important; text-decoration: none !important;font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;" href="tel:0558460557">[+233] 558460557 / 503201722</a></h5>
                </td>
            </tr>
            <tr>
                <td style="background-color:#6EC7E0;padding:0px 10px;">
                    <div style="float:left">
                        <h2
                            style="color:black;padding: 4px;font-size: 14px;font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;"
                        >Keep in touch</h2>
                        <h5>
                            <a style="color: white !important; text-decoration: none !important;" href="https://www.facebook.com/WaCommunicate-110523817249320" target="_black"><img src="https://1.bp.blogspot.com/-OPqfwt4b_Ic/YDO_YYUKhXI/AAAAAAAAAlc/BQj0nsT6n9gL0LmH2A-5bAPo1YRQZ2hogCLcBGAsYHQ/s320/facebook%2B%25281%2529.png" style="width: auto; height: 25px; margin-right: 5px;" alt="facebook"/></a>
                            <a style="color: white !important; text-decoration: none !important;" href="https://twitter.com/home"><img src="https://1.bp.blogspot.com/-W8MfFjEQAiY/YDO_ZIOsF4I/AAAAAAAAAlk/jRaxB1YInloXDAQAFsjy1iBpdoNPYyG0QCLcBGAsYHQ/s320/twitter-social-logotype.png" alt="twitter" style="width: auto; height: 25px; margin-right: 5px;"/></a>
                            <a style="color: white !important; text-decoration: none !important;" href="https://www.linkedin.com/company/11023236/admin/" target="_blank"><img src="https://1.bp.blogspot.com/-cA7YAoM264s/YDO_YdhS5XI/AAAAAAAAAlU/JBwK100K2Jwke2ILY7UpYRqPSnif5WG8QCLcBGAsYHQ/s320/instagram.png" style="width: auto; height: 25px; margin-right: 5px;" alt="instagram" /></a>
                        </h5>
                    </div>
                </td>
            </tr>

        </table>
    </div>
</center>
</body>
</html>
