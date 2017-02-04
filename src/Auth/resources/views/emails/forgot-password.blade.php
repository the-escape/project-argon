Hello {{ $user->name }},
<br>
Click here to reset your password: {{ url('admin/reset-password/'.$token) }}
