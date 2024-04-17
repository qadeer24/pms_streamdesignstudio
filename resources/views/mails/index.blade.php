<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation to Join PMS Stream Design Studio</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
   <div style="background-color: #fff; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); margin: auto; width: 600px;">
      <img src="https://streamdesignstudio.com/wp-content/uploads/2023/11/STREAM-LOGO.png" style="margin-top: 20px; text-align: center;">
       <table align="center" border="0" cellspacing="0" cellpadding="0">
           <tr>
               <td style="padding: 20px;">
                   <h2 style="color: #333;"><b>Invitation to Join PMS Stream Design Studio</b></h2>
                   <p style="color: #666;">Dear {{$to_email}},</p>
                   <p style="color: #666;">We are excited to invite you to join PMS Stream Design Studio – a comprehensive project management platform designed to streamline your project responsibilities and keep track of project progress efficiently for the role of {{$role}}.</p>
                   <p style="color: #666;">A short message from invitator:</p>
                   <p style="color: #666;">{{$short_message}}</p>
                   <p style="color: #666;">To start managing your projects effectively, simply click on the following link to create your account: <a href="{{ route('show_invited_details', ['email' => $to_email, 'id' => $user_id, 'role' => $role]) }}" style="color: #007bff;">Join Now</a>
                    </p>
                    <p style="color: #666;">Best regards,<br>{{Auth::user()->name}}<br>PMS Stream Design Studio</p>
               </td>
           </tr>
       </table>
   </div>

</body>
</html>
