Route::controller('GeneralSettingController')->group(function () {


//socialite credentials
Route::get('setting/social/credentials', 'socialiteCredentials')->name('setting.socialite.credentials');
Route::post('setting/social/credentials/update/{key}',
'updateSocialiteCredential')->name('setting.socialite.credentials.update');
Route::post('setting/social/credentials/status/{key}',
'updateSocialiteCredentialStatus')->name('setting.socialite.credentials.status.update');
});