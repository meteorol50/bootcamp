<?php

return [

    /*
    |--------------------------------------------------------------------------
    | General Error messages which are part of response
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */
    //Client errors
    'bad_request' => 'Something went wrong please try again',
    'unauthorized' => 'Unauthenticated',
    'payment_required' => 'Payment required to proceed further',
    'forbidden' => 'You are not authorised to view this resource',
    'not_found' => 'Not found',
    'method_not_allowed' => 'Method not allowed',
    'conflict' => 'Duplicate resource found',
    'unprocessable_entity' => 'The given data was invalid.',
    'too_many_requests' => 'Too many request has been sent to server',
    'internal_server_error' => 'Internal server error, contact system adminstrator for more information',
    //auth
    'invalid_token' => 'The bearer token is invalid or expired',
    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'email_not_found' => 'Could not find the email address.',
    'recovery_mail_sent' => 'Recovery mail has been sent to your email address.',
    'recovery_mail_not_sent' => 'Could not send recovery mail.',
    'reset_token_not_found' => 'Reset Password token not found.',
    'reset_token_expired' => 'Reset Password token has expired. Please generate a new request.',
    'password_updated' => 'Your password has been updated successfully. Please login to continue.',
    'two_factor_auth_failed' => 'Two factor authentication failed',
    'register_mail_link_sent' => 'Registration Link has been sent to your email address.',
    'logout_successful' => 'Successfully logged out.',
    'invalid_credentials' => 'Invalid credentials.',
    'account_invalid' => 'Invalid account.',
    'login_success' => 'Login successfull.',
    'invalid_access' => 'Invalid access.',
    'password_reset_token_expired' => 'The password reset has expired. Please reset your password again.',
    'invalid_token' => 'The token is invalid.',
    'old_new_password_same' => 'The new password cannot be same as the old password.',

    //common success
    'request_successful' => "Your request has been completed successfully.",
    'creation_successful' => "Requested data has been created successfully.",
    'acceptance_successful' => "We will process your request.",
    'deletion_successful' => "Resource deleted successfully.",

    'validation_error' => "The given data was invalid.",

    //Uzone Error messages
    'email_already_registered' => "Duplicate email address.",
    'mail_transmission_error' => "Failed to send the email. Please check if your email address is correct.",

    'verification_code_incorrect' => "The verification code is incorrect. Please enter the correct verification code.",
    'verification_code_expired' => "The verification code has expired. Please enter your e-mail address again.",
    'user_info_already_registered' => "This user's info is already registered, please use update feature.",
    'cannot_delete_incharge' => 'Edit contact person , no delete.',
    'cannot_edit_incharge' => 'You do not have permission to edit the person in charge.',
    'incharge_deleted' => 'Incharge is deleted.',
    'unauthorised_shipping_update' => 'You do not have permission to edit the shipping address.',
    'image_height_width_mismatch' => 'The image height and width are different, the ratio must be 1:1.'
];
