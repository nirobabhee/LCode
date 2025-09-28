 Route::controller('LoginController')->group(function () {
        Route::post('login/metamask', 'metamaskLogin')->name('login.metamask');
        Route::post('login/metamask/verify', 'metamaskLoginVerify')->name('login.metamask.verify');
    });