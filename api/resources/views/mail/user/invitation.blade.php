@component('mail::message')

# Invitation to Join {{ $workspaceName }} on LP Forms

Hello,

You have been invited to join the workspace "{{ $workspaceName }}" on LP Forms, a platform that simplifies form creation and data collection. With LP Forms, you can easily create, distribute, and manage forms for any purpose.

To join us, please click the button below.

@component('mail::button', ['url' => $inviteLink])
Accept Invitation
@endcomponent

Looking forward to having you on board.

Best Regards,
The LP Forms Team

@endcomponent