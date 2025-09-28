Route::namespace('User\Auth')->name('user.')->group(function () {
Route::controller('SocialiteController')->group(function () {
    Route::get('social-login/{provider}', 'socialLogin')->name('social.login');
    Route::get('social-login/callback/{provider}', 'callback')->name('social.login.callback');
});
});