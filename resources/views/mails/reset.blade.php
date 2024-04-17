<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset - PMS Stream Design Studio</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
   <div style="background-color: #fff; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); margin: auto; width: 600px;">
      <img src="https://streamdesignstudio.com/wp-content/uploads/2023/11/STREAM-LOGO.png" style="margin-top: 20px; text-align: center;">
       <table align="center" border="0" cellspacing="0" cellpadding="0">
           <tr>
               <td style="padding: 20px;">
                   <h2 style="color: #333;"><b>Password Reset - PMS Stream Design Studio</b></h2>
                   <p style="color: #666;">Dear {{$email}},</p>
                   <p style="color: #666;">You have requested to reset your password for your PMS Stream Design Studio account. Please use the following pin code to proceed:</p>
                   <h3 style="color: #333; font-size: 24px;">{{$pin_code}}</h3>
                   <p style="color: #666;">If you didn't request this password reset, you can safely ignore this email.</p>
               </td>
           </tr>
       </table>
   </div>

</body>
</html>
