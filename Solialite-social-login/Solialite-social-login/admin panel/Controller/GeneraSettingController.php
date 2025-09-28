public function socialiteCredentials()
{
$pageTitle = 'Social Login Credentials';
return view('admin.setting.social_credential', compact('pageTitle'));
}

public function updateSocialiteCredentialStatus($key)
{
$general = gs();
$credentials = $general->socialite_credentials;
try {
$credentials->$key->status = $credentials->$key->status == Status::ENABLE ? Status::DISABLE : Status::ENABLE;
} catch (\Throwable $th) {
abort(404);
}

$general->socialite_credentials = $credentials;
$general->save();

$notify[] = ['success', 'Status changed successfully'];
return back()->withNotify($notify);
}

public function updateSocialiteCredential(Request $request, $key)
{
$general = gs();
$credentials = $general->socialite_credentials;
try {
@$credentials->$key->client_id = $request->client_id;
@$credentials->$key->client_secret = $request->client_secret;
} catch (\Throwable $th) {
abort(404);
}
$general->socialite_credentials = $credentials;
$general->save();

$notify[] = ['success', ucfirst($key) . ' credential updated successfully'];
return back()->withNotify($notify);
}