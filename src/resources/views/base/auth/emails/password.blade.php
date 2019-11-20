{{ trans('xylophone::base.click_here_to_reset') }}: <a href="{{ $link = xylophone_url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
